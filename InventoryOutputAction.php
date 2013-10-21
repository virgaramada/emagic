<?php
/*
 SIKOPIS - Sistem Komputerisasi Data Pelaporan Inventory SPBU
 ===================================
 Author: Virga Ramada
 Version: 1.0
 URL: http://www.sikopis.net/


 Copyright And License Information
 =================================
 Copyright (c) 2007 Virga Ramada

 Permission is hereby granted, free of charge, to any person obtaining a copy of this
 software and associated documentation files (the "Software"), to deal in the Software
 without restriction, including without limitation the rights to use, copy, modify, merge,
 publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons
 to whom the Software is furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in all copies or
 substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING
 BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
require_once 'classes/InventoryOutputManager.class.php';
require_once 'classes/InventorySupplyManager.class.php';
require_once 'vo/InventoryOutput.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'vo/InventoryType.class.php';
require_once 'classes/InventoryCustomerManager.class.php';
require_once 'vo/Customer.class.php';
require_once 'classes/InventoryPriceManager.class.php';
require_once 'vo/InventoryPrice.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/PaginateIt.class.php';


if (empty($_REQUEST['PHPSESSID'])) {
	$tpl_engine = TemplateEngine::getEngine();

	$tpl_engine->assign("errors", array ("session_expired" => "Anda harus login terlebih dahulu"));
	$tpl_engine->display('login.tpl');

} else {
	session_id($_REQUEST['PHPSESSID']);
	session_start();
	validateSession();
}
function validateSession() {
	$method_type = @ $_REQUEST["method"];
  if (empty($_SESSION["station_id"])) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("station_id" => "SPBU tidak dikenal!"));
		$tpl_engine->display('login.tpl');
	}
	else if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] == 'NO') {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk merubah penyaluran"));
		$tpl_engine->display('login.tpl');

	} else if (empty ($_SESSION['user_role'])) {

		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');

	}
	else {

		if (empty ($method_type)) {
			prepare();
		}

		if ($method_type == 'create') {
			create();
		}
		if ($method_type == 'update') {
			update();
		}
		if ($method_type == 'delete') {
			delete();
		}
		if ($method_type == 'edit') {
			edit();
		}
		if ($method_type == 'deleteAll') {
			deleteAll();
		}
	}
}

function prepare() {

	$tpl_engine = TemplateEngine::getEngine();


	$productType = @$_REQUEST['productType'];
	if ($productType == 'BBM') {
		$tpl_engine->assign("pump_id_list", groupByPumpId($tpl_engine));
	} else {
		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_output_list", $result);
	}



	$inv_types = findAllInventoryType();
	$tpl_engine->assign("inv_types", $inv_types);

	$cust_types = findAllCustomer();
	$tpl_engine->assign("cust_types", $cust_types);

	$all_price = findAllUnitPrices();
	$tpl_engine->assign("inv_all_price_list", $all_price);

	$tpl_engine->display('inventory_output.tpl');
}
function findAllInventoryType() {
	$inv_mgr = new InventoryTypeManager();
	$result = $inv_mgr->findByProductType(@$_REQUEST['productType'], $_SESSION["station_id"]);
	return $result;
}
function findAllCustomer() {
	$inv_mgr = new InventoryCustomerManager();
	$result = $inv_mgr->findAll(NULL, NULL, $_SESSION["station_id"]);
	return $result;
}
function edit() {
	try {
		$inv_id = @$_REQUEST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new InventoryOutputManager();
		$vo = $inv_mgr->findByPrimaryKey($inv_id);
		$tpl_engine->assign("inventoryOutput", $vo);

		$productType = @$_REQUEST['productType'];
		if ($productType == 'BBM') {
			$tpl_engine->assign("pump_id_list", groupByPumpId($tpl_engine));
		} else {
			$result = findAll($tpl_engine);
			$tpl_engine->assign("inv_output_list", $result);
		}

		$all_price = findAllUnitPrices();
		$tpl_engine->assign("inv_all_price_list", $all_price);

		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);

		$cust_types = findAllCustomer();
		$tpl_engine->assign("cust_types", $cust_types);

		$tpl_engine->display('inventory_output.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function groupByPumpId($tpl_engine=NULL) {
	$inv_mgr = new InventoryOutputManager();
	$inv_output_list = $inv_mgr->findAllPumpId(@$_REQUEST['productType'], $_SESSION["station_id"]);
	
	$j = 0;
	$pumps = array ();
	if ($inv_output_list != NULL && sizeof($inv_output_list) > 0)
	{
		for ($j = 0; $j < sizeof($inv_output_list); $j ++) {
		  $pump_id = $inv_output_list[$j];
		  if ($pump_id) {
		     $pumps = array_merge($pumps, array($pump_id => _findByPumpId($pump_id, $tpl_engine)));
		  }
	    }
	}
	
	
	
	return $pumps;
}

function _findByPumpId($pump_id, $tpl_engine) {
	$pageNumber = @ $_REQUEST['page'];
	$inv_mgr = new InventoryOutputManager();
	$totalData = (int) $inv_mgr->countAll(@$_REQUEST['productType'], $pump_id, $_SESSION["station_id"]);
	if (empty ($pageNumber)) {
		$pageNumber = 1;
	}
	$itemsPerPage = 10;
	$PaginateIt = new PaginateIt();
	$PaginateIt->SetItemsPerPage($itemsPerPage);
	$PaginateIt->SetItemCount($totalData);
	$pageIndex = ((int) $pageNumber * $itemsPerPage - $itemsPerPage);
	if ($pageIndex > $totalData) {
		$pageIndex = 0;
	}
	$result = $inv_mgr->findByPumpId($pump_id, $pageIndex, $itemsPerPage, $_SESSION["station_id"]);
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("paginatedOutputList_".$pump_id, $PaginateIt->GetPageLinks());
	}

	return $result;
}

function groupByCustomerType() {
	$inv_mgr = new InventoryOutputManager();
	$customer_type_list = $inv_mgr->findAllCustomerType(@$_REQUEST['productType'], $_SESSION["station_id"]);
	$j = 0;
	$customer_list = array ();
	for ($j = 0; $j < count($customer_type_list); $j ++) {
		$customer_type = $customer_type_list[$j];
		$customer_list = array_merge($customer_list, array($customer_type => $inv_mgr->findTotalOutputByCustomerType($customer_type, @$_REQUEST['productType'], $_SESSION["station_id"])));
	}
	return $customer_list;
}

function create() {

	try {
		$tpl_engine = TemplateEngine::getEngine();
		
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new InventoryOutput();
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setOutputValue($_POST["output_value"]);
			if (!empty($_POST["begin_stand_meter"]) && !empty($_POST["end_stand_meter"])) {
				$_vo->setOutputValue((double) $_POST["end_stand_meter"] - (double)$_POST["begin_stand_meter"]);
			}

			$output_day = $_POST["Date_Day"];
			if (strlen($output_day) == 1) {
				$output_day = '0'.$output_day;
			}
			
			if (!empty($_POST["Time_Hour"])) {
				$_vo->setOutputTime($_POST["Time_Hour"].':'.$_POST["Time_Minute"]);
			}
			$date_formatted = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["Date_Month"], (int) $output_day, (int) @$_POST["Date_Year"]));
			$_vo->setOutputDate($date_formatted);
			$_vo->setCustomerType($_POST["customer_type"]);
			$_vo->setUnitPrice($_POST["unit_price"]);
			$_vo->setCategory($_POST["category"]);
			$_vo->setBeginStandMeter(@$_POST["begin_stand_meter"]);
			$_vo->setEndStandMeter(@$_POST["end_stand_meter"]);
			$_vo->setVehicleType($_POST["vehicle_type"]);
			$_vo->setTeraValue(@$_POST["tera_value"]);
			$_vo->setPumpId(@$_POST["pump_id"]);
			$_vo->setNoselId(@$_POST["nosel_id"]);
			$_vo->setStationId($_SESSION["station_id"]);

			$inv_mgr = new InventoryOutputManager();
			$inv_mgr->create($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$productType = @$_REQUEST['productType'];
		if ($productType == 'BBM') {
			$tpl_engine->assign("pump_id_list", groupByPumpId($tpl_engine));
		} else {
			$result = findAll($tpl_engine);
			$tpl_engine->assign("inv_output_list", $result);
		}


		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);

		$cust_types = findAllCustomer();
		$tpl_engine->assign("cust_types", $cust_types);

		$all_price = findAllUnitPrices();
		$tpl_engine->assign("inv_all_price_list", $all_price);

		$tpl_engine->display('inventory_output.tpl');
	} catch (Exception $e) {
		die($e);
	}
}
function update() {
	try {
		$inv_id = $_POST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();
		
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new InventoryOutput();
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setOutputValue($_POST["output_value"]);
			if (!empty($_POST["begin_stand_meter"]) && !empty($_POST["end_stand_meter"])) {
				$_vo->setOutputValue((double) $_POST["end_stand_meter"] - (double)$_POST["begin_stand_meter"]);
			}
			$output_day = $_POST["Date_Day"];
			if (strlen($output_day) == 1) {
				$output_day = '0'.$output_day;
			}
			$output_date = $output_day.'/'.$_POST["Date_Month"].'/'.$_POST["Date_Year"];
			if (!empty($_POST["Time_Hour"])) {
				$_vo->setOutputTime($_POST["Time_Hour"].':'.$_POST["Time_Minute"]);
			}
			$date_formatted = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["Date_Month"], (int) $output_day, (int) @$_POST["Date_Year"]));
			$_vo->setOutputDate($date_formatted);
			$_vo->setCustomerType($_POST["customer_type"]);
			$_vo->setUnitPrice($_POST["unit_price"]);
			$_vo->setCategory($_POST["category"]);
			$_vo->setBeginStandMeter(@$_POST["begin_stand_meter"]);
			$_vo->setEndStandMeter(@$_POST["end_stand_meter"]);
			$_vo->setVehicleType($_POST["vehicle_type"]);
			$_vo->setTeraValue(@$_POST["tera_value"]);
			$_vo->setPumpId(@$_POST["pump_id"]);
			$_vo->setNoselId(@$_POST["nosel_id"]);

			$_vo->setInvId($inv_id);

			$inv_mgr = new InventoryOutputManager();
			$inv_mgr->update($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}


		$productType = @$_REQUEST['productType'];
		if ($productType == 'BBM') {
			$tpl_engine->assign("pump_id_list", groupByPumpId($tpl_engine));
		} else {
			$result = findAll($tpl_engine);
			$tpl_engine->assign("inv_output_list", $result);
		}


		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);

		$cust_types = findAllCustomer();
		$tpl_engine->assign("cust_types", $cust_types);

		$all_price = findAllUnitPrices();
		$tpl_engine->assign("inv_all_price_list", $all_price);

		$tpl_engine->display('inventory_output.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function delete() {
	try {
		$inv_id = @$_REQUEST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new InventoryOutputManager();
		$inv_mgr->delete($inv_id, $_SESSION["station_id"]);


		$productType = @$_REQUEST['productType'];
		if ($productType == 'BBM') {
			$tpl_engine->assign("pump_id_list", groupByPumpId($tpl_engine));
		} else {
			$result = findAll($tpl_engine);
			$tpl_engine->assign("inv_output_list", $result);
		}

		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);

		$cust_types = findAllCustomer();
		$tpl_engine->assign("cust_types", $cust_types);

		$all_price = findAllUnitPrices();
		$tpl_engine->assign("inv_all_price_list", $all_price);

		$tpl_engine->display('inventory_output.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function deleteAll() {
	try {

		$tpl_engine = TemplateEngine::getEngine();

		$productType = @$_REQUEST['productType'];

		$inv_mgr = new InventoryOutputManager();
		$inv_mgr->deleteAll($productType, $_SESSION["station_id"]);

		if ($productType == 'BBM') {
			$tpl_engine->assign("pump_id_list", groupByPumpId($tpl_engine));
		} else {
			$result = findAll($tpl_engine);
			$tpl_engine->assign("inv_output_list", $result);
		}

		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);

		$cust_types = findAllCustomer();
		$tpl_engine->assign("cust_types", $cust_types);

		$all_price = findAllUnitPrices();
		$tpl_engine->assign("inv_all_price_list", $all_price);

		$tpl_engine->display('inventory_output.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function findAll($tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];
	$inv_mgr = new InventoryOutputManager();
	$totalData = (int) $inv_mgr->countAll(@$_REQUEST['productType'], NULL, $_SESSION["station_id"]);
	if (empty ($pageNumber)) {
		$pageNumber = 1;
	}
	$itemsPerPage = 10;
	$PaginateIt = new PaginateIt();
	$PaginateIt->SetItemsPerPage($itemsPerPage);
	$PaginateIt->SetItemCount($totalData);
	$PaginateIt->SetCurrentPage($pageNumber);
	$pageIndex = ((int) $pageNumber * $itemsPerPage - $itemsPerPage);
	if ($pageIndex > $totalData) {
		$pageIndex = 0;
	}
	$result = $inv_mgr->findAll(@$_REQUEST['productType'], $pageIndex, $itemsPerPage, $_SESSION["station_id"]);
    if (!empty ($tpl_engine)) {
		$tpl_engine->assign("paginatedOutputList", $PaginateIt->GetPageLinks());
		$tpl_engine->assign("total_output_by_customer_type", groupByCustomerType());
	}
	return $result;
}
function findAllUnitPrices() {
	$inv_mgr = new InventoryPriceManager();
	$result = $inv_mgr->findAll(@$_REQUEST['productType'], NULL, NULL, $_SESSION["station_id"]);
	return $result;
}
function validate() {
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();
	$result = array ();
	if (empty ($_POST["inventory_type"])) {
		$result = array ("inventory_type" => "Silahkan isi jenis bahan bakar dengan benar");
	}
	
	
	if (@$_REQUEST['productType'] == 'LUB') {
		if (empty ($_POST["output_value"]) || !is_numeric($_POST["output_value"])) {
			$result = array ("output_value" => "Silahkan isi jumlah penyaluran dengan benar");
		} else if (strlen($_POST["output_value"]) > 10) {
			$result = array ("output_value" => "Jumlah penyaluran max 10 digit");
		} else if ((int)$_POST["output_value"] <= 0) {
			$result = array ("output_value" => "Jumlah penyaluran tidak boleh kurang/sama dengan nol");
		} else {
		    $total_output = (double) $inv_output_mgr->findAllOutputByInvTypeAndDate($_POST["inventory_type"], NULL, date("Y-m-d", mktime()), $_SESSION["station_id"]);
	        $total_supply = (double) $inv_supply_mgr->findTotalSupplyByInventoryType($_POST["inventory_type"], NULL, date("Y-m-d", mktime()), $_SESSION["station_id"]);

	         $total_output = $total_output + (double) $_POST["output_value"];
	         if ($total_output > $total_supply) {
	         	$result = array ("total_output" => "Jumlah penyaluran tidak boleh melebihi jumlah suplai");
	         }
		}
	}

	if (@$_REQUEST['productType'] == 'BBM') {
		if (empty ($_POST["begin_stand_meter"]) || !is_numeric($_POST["begin_stand_meter"])) {
			$result = array ("begin_stand_meter" => "Silahkan isi stand meter awal dengan benar");
		} else if (strlen($_POST["begin_stand_meter"]) > 10) {
			$result = array ("begin_stand_meter" => "Stand meter awal max 10 digit");
		} else if ((int)$_POST["begin_stand_meter"] <= 0) {
			$result = array ("begin_stand_meter" => "Stand meter awal tidak boleh kurang/sama dengan nol");
		}
		if (empty ($_POST["end_stand_meter"]) || !is_numeric($_POST["end_stand_meter"])) {
			$result = array ("end_stand_meter" => "Silahkan isi stand meter akhir dengan benar");
		} else if (strlen($_POST["end_stand_meter"]) > 10) {
			$result = array ("end_stand_meter" => "Stand meter akhir max 10 digit");
		} else if ((int)$_POST["end_stand_meter"] <= 0) {
			$result = array ("end_stand_meter" => "Stand meter akhir tidak boleh kurang/sama dengan nol");
		} else if ((int)$_POST["begin_stand_meter"] >= (int)$_POST["end_stand_meter"]) {
			$result = array ("end_stand_meter" => "Stand meter akhir tidak boleh lebih dari atau sama dengan stand meter awal");
		}

		if (empty ($_POST["pump_id"])) {
			$result = array ("pump_id" => "Silahkan isi No. dispenser");
		}
	    else if (is_numeric ($_POST["pump_id"])) {
			$result = array ("pump_id" => "No. dispenser tidak valid");
		}
		else if (empty ($_POST["nosel_id"])) {
			$result = array ("nosel_id" => "Silahkan isi No. nosel");
		} else {
		    $total_output = (double) $inv_output_mgr->findAllOutputByInvTypeAndDate($_POST["inventory_type"], NULL, date("Y-m-d", mktime()), $_SESSION["station_id"]);
	        $total_supply = (double) $inv_supply_mgr->findTotalSupplyByInventoryType($_POST["inventory_type"], NULL, date("Y-m-d", mktime()), $_SESSION["station_id"]);

	         $total_output = $total_output + ((double) $_POST["end_stand_meter"] - (double) $_POST["begin_stand_meter"]);
	         if ($total_output > $total_supply) {
	         	$result = array ("total_output" => "Stand meter tidak boleh melebihi jumlah suplai");
	         }
		
		}
	}

	if (empty ($_POST["customer_type"])) {
		$result = array ("customer_type" => "Silahkan isi tipe penyaluran");
	}
	if (empty ($_POST["vehicle_type"])) {
		$result = array ("vehicle_type" => "Silahkan pilih tipe kendaraan");
	}
	if (empty ($_POST["unit_price"]) || !is_numeric($_POST["unit_price"])) {
		$result = array ("unit_price" => "Silahkan isi harga satuan");

	} else if (strlen($_POST["unit_price"]) > 10) {
		$result = array ("unit_price" => "Harga satuan max 10 digit");
	} else if ((int)$_POST["unit_price"] <= 0) {
		$result = array ("unit_price" => "Harga satuan tidak boleh kurang/sama dengan nol");
	}
	if (empty ($_POST["Date_Month"])) {
		$result = array ("Date_Month" => "Silahkan pilih bulan penyaluran");
	}
	if (empty ($_POST["Date_Year"])) {
		$result = array ("Date_Year" => "Silahkan pilih tahun penyaluran");
	}
	if (empty ($_POST["Date_Day"])) {
		$result = array ("Date_Day" => "Silahkan pilih tanggal penyaluran");
	}
	if (empty ($_POST["category"])) {
		$result = array ("category" => "Silahkan pilih kategori");
	}
	return $result;
}
?>
