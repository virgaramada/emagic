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

require_once 'classes/DeliveryRealisationManager.class.php';
require_once 'classes/StationManager.class.php';
require_once 'classes/SalesOrderManager.class.php';
require_once 'classes/InventorySupplyManager.class.php';
require_once 'classes/TankCapacityManager.class.php';
require_once 'classes/InventoryOutputManager.class.php';
require_once 'vo/InventorySupply.class.php';

require_once 'classes/ControllerUtils.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/PaginateIt.class.php';



if (empty ($_REQUEST['PHPSESSID'])) {
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
	if (!isset($_SESSION["station_id"])) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("station_id" => "SPBU tidak dikenal!"));
		$tpl_engine->display('login.tpl');
	} else if (!isset ($_SESSION['user_role'])) {

		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');

	}
	else if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_ADMINISTRATOR && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_OWNER && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_OPERATOR) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk melihat realisasi sales order"));
		$tpl_engine->display('login.tpl');

	}  else {
		
	       if (empty ($method_type)) {
				prepare();
			}

			if ($method_type == 'confirm') {
				confirmReceive();
			}
	       if ($method_type == 'prepareConfirm') {
				prepareConfirm();
			}
	}
}

function prepare($tpl_engine = NULL) {
	if ($tpl_engine == NULL) {
	    $tpl_engine = TemplateEngine::getEngine();	

	}
	

	$st_mgr = new StationManager();
	$so_mgr = new SalesOrderManager();
	$gas_station = $st_mgr->findByPrimaryKey($_SESSION["station_id"]);
	$tpl_engine->assign("gas_station", $gas_station);
	
	$inv_types = ControllerUtils::findAllInventoryType();
	$tpl_engine->assign("inv_types", $inv_types);

	$sales_order_number = @$_REQUEST["sales_order_number"];
	$delivery_shift_number = @$_REQUEST["delivery_shift_number"];
	$dr_mgr = new DeliveryRealisationManager();
	$deliveryRealisationPageNumber = @ $_REQUEST['deliveryRealisationPage'];

	$totalDeliveryRealisation = (int) $dr_mgr->countAll($_SESSION["station_id"]);
	if (empty ($deliveryRealisationPageNumber)) {
		$deliveryRealisationPageNumber = 1;
	}
	$dr_itemsPerPage = 10;
	$dr_PaginateIt = new PaginateIt();
	$dr_PaginateIt->SetItemsPerPage($dr_itemsPerPage);
	$dr_PaginateIt->SetItemCount($totalDeliveryRealisation);
	$dr_PaginateIt->SetQueryStringVar('deliveryRealisationPage');
	$dr_PaginateIt->SetCurrentPage($deliveryRealisationPageNumber);

	$dr_pageIndex = ((int) $deliveryRealisationPageNumber * $dr_itemsPerPage - $dr_itemsPerPage);
	if ($dr_pageIndex > $totalDeliveryRealisation) {
		$dr_pageIndex = 0;
	}

	$delivery_realisation_list = $dr_mgr->findAll($dr_pageIndex, $dr_itemsPerPage, $_SESSION["station_id"]);
	$tpl_engine->assign("paginatedDeliveryRealisationList", $dr_PaginateIt->GetPageLinks());

	$sales_order_invalid = "false";
	if (isset($sales_order_number) && !empty($sales_order_number)) {
		$delivery_realisation_list = array();
		$vo = $dr_mgr->findBySalesOrderNumberAndStation($sales_order_number, $_SESSION["station_id"]);
		if (empty($vo)) {
			$sales_order_invalid = "true";
			$tpl_engine->assign("errors", array ("sales_order_number" => "No Sales Order tidak ditemukan"));
		} else {	
			$delivery_realisation_list = array_merge($delivery_realisation_list, array($vo));
		    $tpl_engine->clear_assign("paginatedDeliveryRealisationList");
		}
		
	}
	if (($delivery_realisation_list == NULL || sizeof($delivery_realisation_list) == 0 ) && $sales_order_invalid == "false") {
		$tpl_engine->assign("errors", array ("delivery_realisation_list" => "Belum ada data realisasi pengiriman"));
	} else {
		$tpl_engine->assign("delivery_realisation_list", $delivery_realisation_list);
		$tpl_engine->assign("now", mktime());
		$sales_order_list = array();
		foreach ($delivery_realisation_list as $key=>$value) {
			$sales_order_list = array_merge($sales_order_list, array($so_mgr->findBySalesOrderNumberAndStation($value->getSalesOrderNumber(), $_SESSION["station_id"],$delivery_shift_number)));
			
		}
		if (sizeof($sales_order_list) > 0) {
			$tpl_engine->assign("sales_order_list", $sales_order_list);
		
		}
		
	}
	
	
	$tpl_engine->display('sales_order_realisation.tpl');

}

function confirmReceive() {
	$sales_order_number = @$_REQUEST["sales_order_number"];
	$station_id = $_SESSION["station_id"];
	
	
	// add supply
	
	try {
		$tpl_engine = TemplateEngine::getEngine();	

	   // $errors = validate();
		//if (empty ($errors)) {
			$_vo = new InventorySupply();
		    $_vo->setInvType($_POST["inventory_type"]);
			$_vo->setSupplyValue($_POST["supply_value"]);

            $date_formatted = date("Y-m-d", mktime());
			$_vo->setSupplyDate($date_formatted);
			$_vo->setDeliveryOrderNumber($_POST["delivery_order_number"]);
			$_vo->setNiapNumber($_POST["niap_number"]);
			$_vo->setPlateNumber($_POST["plate_number"]);
			$_vo->setStationId($station_id);
			
			/*$_vo->setInvType("2");//$_POST["inventory_type"]);
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setSupplyValue("16000");//$_POST["supply_value"]);

            $date_formatted = date("Y-m-d", mktime());
			$_vo->setSupplyDate("2010-10-22");//$date_formatted);
			$_vo->setDeliveryOrderNumber("2");//$_POST["delivery_order_number"]);
			$_vo->setNiapNumber("222");//$_POST["niap_number"]);
			$_vo->setPlateNumber("b234xz");//$_POST["plate_number"]);
			$_vo->setStationId($station_id);*/

			$inv_mgr = new InventorySupplyManager();
			$inv_mgr->create($_vo);
			//$tpl_engine->display('sales_order_realisation.tpl');
			//$tpl_engine->display('sales_order_realisation.tpl');
			if (isset($sales_order_number) && !empty($sales_order_number)) {
			   $so_mgr = new SalesOrderManager();
	           $so_mgr->confirmReceive($sales_order_number, $station_id, $_POST["delivery_shift_number"]);
	       
	           $tpl_engine->assign("messages", array ("sales_order_number" => "Penerimaan untuk Sales Order No. ". $sales_order_number ." sudah dikonfirmasi dengan sukses"));	
			  // $tpl_engine->display('sales_order_realisation.tpl');
			}
			$tpl_engine->display('sales_order_realisation.tpl');			
			
			/*********************************************/
			
			//******Delivery Plan Module*********/
			/*$stationId=$_SESSION["station_id"];
			$vo = new DeliveryPlan();


			$dday = $_POST["Delivery_Date_Day"];
			if (strlen($dday) == 1) {
				$dday = '0'.$dday;
			}

			$delivery_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Delivery_Date_Month"], (int) $dday, (int) $_POST["Delivery_Date_Year"]));

			$vo->setDeliveryDate($delivery_date);
			$vo->setStationId($stationId);
			$vo->setDeliveryShiftNumber($_POST["delivery_shift_number"]);
			$vo->setInvType($_POST["inv_type"]);
			$vo->setQuantity($_POST["quantity"]);
			//$vo->setDeliveryMessage($_POST["delivery_message"]);
			$vo->setDeliveryMessage($_POST["order_message"]);
			$vo->setSalesOrderNumber($_POST["sales_order_number"]);
            $vo->setPlanStatus("PLN");
			$dp_mgr = new DeliveryPlanManager();
			$dp_mgr->create($vo);*/
			
			
			
			
			/*********************************************/
			
	    // prepare($tpl_engine);
	    //$tpl_engine->assign("messages", array ("sales_order_number" => "Penerimaan untuk Sales Order No. ". $sales_order_number ." sudah dikonfirmasi dengan sukses"));
			
			
//	} else {
///			$tpl_engine->assign("errors", $errors);

			
	//	}

	} catch (Exception $e) {
		die($e);
	}
	
	
}

function prepareConfirm() {
	$tpl_engine = TemplateEngine::getEngine();	
	$sales_order_number = @$_REQUEST["sales_order_number"];
	$delivery_realisation_id = @$_REQUEST["delivery_realisation_id"];
	$delivery_shift_number = @$_POST["delivery_shift_number"];
	if (isset($sales_order_number) && !empty($sales_order_number)) {
		$station_id = $_SESSION["station_id"];
		$so_mgr = new SalesOrderManager();
		$dr_mgr = new DeliveryRealisationManager();

		$sales_order = $so_mgr->findBySalesOrderNumberAndStation($sales_order_number, $station_id,$delivery_shift_number);
		$delivery_realisation = $dr_mgr->findByPrimaryKey($delivery_realisation_id);
		if ($sales_order) {
			$tpl_engine->assign("salesOrder", $sales_order);
		}
		if ($delivery_realisation) {
			$tpl_engine->assign("deliveryRealisation", $delivery_realisation);
		}
	}

	prepare($tpl_engine);
	
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

	/**
	if (empty ($_POST["Date_Month"])) {
		$result = array ("Date_Month" => "Silahkan pilih bulan suplai");
	}
	if (empty ($_POST["Date_Year"])) {
		$result = array ("Date_Year" => "Silahkan pilih tahun suplai");
	}
	if (empty ($_POST["Date_Day"])) {
		$result = array ("Date_Day" => "Silahkan pilih tanggal suplai");
	}
*/
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
