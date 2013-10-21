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
require_once 'classes/InventorySupplyManager.class.php';
require_once 'classes/TankCapacityManager.class.php';
require_once 'classes/InventoryOutputManager.class.php';

require_once 'vo/InventorySupply.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'vo/InventoryType.class.php';
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

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk merubah supply"));
		$tpl_engine->display('login.tpl');

	} else if (empty ($_SESSION['user_role'])) {

		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');

	} else {

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
function findAllInventoryType() {
	$inv_mgr = new InventoryTypeManager();
	$result = $inv_mgr->findAll(NULL, NULL, $_SESSION["station_id"]);
	return $result;
}

/*function findAllTankByType() {
	$inv_mgr = new InventoryTypeManager();
	$result = $inv_mgr->findAll(NULL, NULL, $_SESSION["station_id"]);
	return $result;
}*/

function edit() {
	try {
		$inv_id = $_REQUEST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new InventorySupplyManager();
		$vo = $inv_mgr->findByPrimaryKey($inv_id);
		$tpl_engine->assign("inventorySupply", $vo);

		$result = findGasSupply($tpl_engine);
		$tpl_engine->assign("inv_supply_list", $result);

		$result = findLubSupply($tpl_engine);
		$tpl_engine->assign("lub_supply_list", $result);

		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('inventory_supply.tpl');
		
		

	} catch (Exception $e) {
		die($e);
	}
}

function prepare() {

	$tpl_engine = TemplateEngine::getEngine();


	$result = findGasSupply($tpl_engine);
	$tpl_engine->assign("inv_supply_list", $result);

	$result = findLubSupply($tpl_engine);
	$tpl_engine->assign("lub_supply_list", $result);

	$inv_types = findAllInventoryType();
	$tpl_engine->assign("inv_types", $inv_types);
	$tpl_engine->display('inventory_supply.tpl');
}

function create() {

	try {
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$_vo = new InventorySupply();
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setSupplyValue($_POST["supply_value"]);
			$supply_day = $_POST["Date_Day"];
			if (strlen($supply_day) == 1) {
				$supply_day = '0'.$supply_day;
			}
			$supply_date = $supply_day.'/'.$_POST["Date_Month"].'/'.$_POST["Date_Year"];
			$date_formatted = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Date_Month"], (int) $supply_day, (int) $_POST["Date_Year"]));
			$_vo->setSupplyDate($date_formatted);
			$_vo->setDeliveryOrderNumber($_POST["delivery_order_number"]);
			$_vo->setNiapNumber($_POST["niap_number"]);
			$_vo->setPlateNumber($_POST["plate_number"]);
			$_vo->setStationId($_SESSION["station_id"]);

			$inv_mgr = new InventorySupplyManager();
			$inv_mgr->create($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}
		$result = findGasSupply($tpl_engine);
		$tpl_engine->assign("inv_supply_list", $result);

		$result = findLubSupply($tpl_engine);
		$tpl_engine->assign("lub_supply_list", $result);
		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('inventory_supply.tpl');
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
			$_vo = new InventorySupply();
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setSupplyValue($_POST["supply_value"]);
			$supply_day = $_POST["Date_Day"];
			if (strlen($supply_day) == 1) {
				$supply_day = '0'.$supply_day;
			}
			$supply_date = $supply_day.'/'.$_POST["Date_Month"].'/'.$_POST["Date_Year"];
			$date_formatted = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Date_Month"], (int) $supply_day, (int) $_POST["Date_Year"]));
			$_vo->setSupplyDate($date_formatted);
			$_vo->setDeliveryOrderNumber($_POST["delivery_order_number"]);
			$_vo->setNiapNumber($_POST["niap_number"]);
			$_vo->setPlateNumber($_POST["plate_number"]);
			$_vo->setInvId($inv_id);

			$inv_mgr = new InventorySupplyManager();
			$inv_mgr->update($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$result = findGasSupply($tpl_engine);
		$tpl_engine->assign("inv_supply_list", $result);

		$result = findLubSupply($tpl_engine);
		$tpl_engine->assign("lub_supply_list", $result);
		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('inventory_supply.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function delete() {
	try {
		$inv_id = $_REQUEST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();


		$inv_mgr = new InventorySupplyManager();
		$inv_mgr->delete($inv_id);

		$result = findGasSupply($tpl_engine);
		$tpl_engine->assign("inv_supply_list", $result);

		$result = findLubSupply($tpl_engine);
		$tpl_engine->assign("lub_supply_list", $result);
		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('inventory_supply.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function deleteAll() {
	try {
		$tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new InventorySupplyManager();
		$inv_mgr->deleteAll($_SESSION["station_id"]);

		$result = findGasSupply($tpl_engine);
		$tpl_engine->assign("inv_supply_list", $result);

		$result = findLubSupply($tpl_engine);
		$tpl_engine->assign("lub_supply_list", $result);
		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('inventory_supply.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function findLubSupply($tpl_engine=NULL) {
	$pageNumber = @$_REQUEST['page'];
	$inv_mgr = new InventorySupplyManager();
	$totalData = (int) $inv_mgr->countAll('LUB', $_SESSION["station_id"]);
	if (empty($pageNumber)) {
		$pageNumber = 1;
	}
	$itemsPerPage = 10;
	$PaginateIt = new PaginateIt();
	$PaginateIt->SetItemsPerPage($itemsPerPage);
	$pageIndex = ((int) $pageNumber * $itemsPerPage - $itemsPerPage);
	if ($pageIndex > $totalData) {
		$pageIndex = 0;
	}
	$result = $inv_mgr->findAll('LUB', $pageIndex, $itemsPerPage, $_SESSION["station_id"]);

	$PaginateIt->SetItemCount($totalData);
	$PaginateIt->SetCurrentPage($pageNumber);
	if (!empty($tpl_engine)) {
		$tpl_engine->assign("paginatedLubLinks", $PaginateIt->GetPageLinks());
		$tpl_engine->assign("total_lub", $inv_mgr->findTotalSupplyByProductType('LUB', $_SESSION["station_id"]));
	}
	return $result;
}
function findGasSupply($tpl_engine=NULL) {
	$pageNumber = @$_REQUEST['page'];
	$inv_mgr = new InventorySupplyManager();
	$totalData = (int) $inv_mgr->countAll('BBM', $_SESSION["station_id"]);
	if (empty($pageNumber)) {
		$pageNumber = 1;
	}
	$itemsPerPage = 10;
	$PaginateIt = new PaginateIt();
	$PaginateIt->SetItemsPerPage($itemsPerPage);
	$PaginateIt->SetCurrentPage($pageNumber);
	$pageIndex = ((int) $pageNumber * $itemsPerPage - $itemsPerPage);
	if ($pageIndex > $totalData) {
		$pageIndex = 0;
	}
	$result = $inv_mgr->findAll('BBM', $pageIndex, $itemsPerPage, $_SESSION["station_id"]);

	$PaginateIt->SetItemCount($totalData);
	if (!empty($tpl_engine)) {
		$tpl_engine->assign("paginatedGasLinks", $PaginateIt->GetPageLinks());
		$tpl_engine->assign("total_gas", $inv_mgr->findTotalSupplyByProductType('BBM', $_SESSION["station_id"]));
	}
	return $result;
}

function validate() {
	$tank_mgr = new TankCapacityManager();
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();
	$result = array ();
	if (empty ($_POST["inventory_type"])) {
		$result = array ("inventory_type" => "Silahkan pilih jenis bahan bakar");
	}
	if (empty ($_POST["supply_value"]) || !is_numeric($_POST["supply_value"])) {
		$result = array ("supply_value" => "Silahkan isi jumlah suplai dengan benar");

	} else if (strlen($_POST["supply_value"]) > 10) {
		$result = array ("supply_value" => "Jumlah suplai max 10 digit");
	} else if ((int)$_POST["supply_value"] <= 0) {
		$result = array ("supply_value" => "Jumlah suplai tidak boleh kurang/sama dengan nol");
	} else {
		$tank_cap = $tank_mgr->findByInventoryType($_POST["inventory_type"], $_SESSION["station_id"]);
	    if (!($tank_cap)) {
			$result = array ("tank_cap" => "SPBU " .$_SESSION["station_id"]. " belum mempunyai kapasitas tanki");
		} else {
		
			$total_output = (double) $inv_output_mgr->findAllOutputByInvTypeAndDate($_POST["inventory_type"], NULL, date("Y-m-d", mktime()), $_SESSION["station_id"]);
			$total_supply = (double) $inv_supply_mgr->findTotalSupplyByInventoryType($_POST["inventory_type"], NULL, date("Y-m-d", mktime()), $_SESSION["station_id"]);

			$total_supply = $total_supply + (double) $_POST["supply_value"];
			//echo("total stok " . ($total_supply - $total_output));
			//echo("kapasitas tanki " . $tank_cap->getTankCapacity());
			if (($total_supply - $total_output) > $tank_cap->getTankCapacity()) {
				$result = array ("total_supply" => "Jumlah total suplai tidak boleh melebihi kapasitas tanki");
			}
		}
		
	}
	
	if (empty ($_POST["delivery_order_number"])) {
		$result = array ("delivery_order_number" => "Silahkan isi delivery order dengan benar");

	} else if (strlen($_POST["delivery_order_number"]) > 20) {
		$result = array ("delivery_order_number" => "Delivery order max 20 karakter");
	}

	if (empty ($_POST["Date_Month"])) {
		$result = array ("Date_Month" => "Silahkan pilih bulan suplai");
	}
	if (empty ($_POST["Date_Year"])) {
		$result = array ("Date_Year" => "Silahkan pilih tahun suplai");
	}
	if (empty ($_POST["Date_Day"])) {
		$result = array ("Date_Day" => "Silahkan pilih tanggal suplai");
	}
	if (empty ($_POST["niap_number"])) {
		$result = array ("niap_number" => "Silahkan isi NIAP dengan benar");

	} else if (strlen($_POST["niap_number"]) > 20) {
		$result = array ("niap_number" => "NIAP max 20 karakter");

	}
	if (empty ($_POST["plate_number"])) {
		$result = array ("plate_number" => "Silahkan isi No. Pol dengan benar");

	} else if (strlen($_POST["plate_number"]) > 10) {
		$result = array ("plate_number" => "No. Pol max 10 karakter");

	}
	return $result;
}

?>