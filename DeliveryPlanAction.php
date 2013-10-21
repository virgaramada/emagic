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

require_once 'classes/DeliveryPlanManager.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/PaginateIt.class.php';
require_once 'classes/ControllerUtils.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'classes/SalesOrderManager.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'classes/DistributionLocationManager.class.php';
require_once 'classes/StationManager.class.php';
require_once 'vo/DeliveryPlan.class.php';


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
	if (isset ($_SESSION['user_role'])) {
			
		if ($_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::DEPOT ) {

			$tpl_engine = TemplateEngine::getEngine();

			$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk membuat jadwal pengiriman"));
			$tpl_engine->display('login.tpl');

		}  else {
			if (empty ($method_type)) {
				prepare();
			}

			if ($method_type == 'create') {
				create();
			}
			if ($method_type == 'update') {
				update();
			}

			if ($method_type == 'edit') {
				edit();
			}
		if ($method_type == 'viewSalesOrder') {
				viewSalesOrder();
			}
		}

	} else {
		$tpl_engine = TemplateEngine::getEngine();
		
		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');
	}

}

function _findAllData($tpl_engine) {

	$so_mgr = new SalesOrderManager();
    $inv_mgr = new InventoryTypeManager();
    $st_mgr = new StationManager();
    $dist_mgr = new DistributionLocationManager();
    $sales_order_number = @$_POST["sales_order_number"];
	$hasInventory = "false";
	$hasStation = "false";
	$dp_mgr = new DeliveryPlanManager();
	$inv_types = $dp_mgr->findAllPlanInventoryType();
	if (($inv_types == NULL || sizeof($inv_types)  == 0)) {
		$inv_types = $inv_mgr->findAll();
	}


	$so_list = $so_mgr->findAll(NULL, NULL, NULL);
	if (isset($sales_order_number) && !empty($sales_order_number)) {
		$so_list = $so_mgr->findBySalesOrderNumber(NULL, NULL, $sales_order_number);
	}
	if ($so_list != NULL && sizeof($so_list) > 0) {
		$inv_types = array();
		foreach ($so_list as $key=>$value) {
			// find inv type
			$inv_list = $inv_mgr->findByInventoryType($value->getInvType());
			
		    $intersect = ControllerUtils::checkArray($inv_list, $inv_types);

			if ($intersect === FALSE) {
				$inv_types = array_merge($inv_types, $inv_list);
			}
			
			
		}
	}

    if (isset($sales_order_number) && !empty($sales_order_number) && ($so_list == NULL || sizeof($so_list)  == 0)) {

		$tpl_engine->clear_all_assign();
		$tpl_engine->assign("errors", array ("so_list" => "Sales Order tidak ditemukan!"));


	} else if (($inv_types == NULL || sizeof($inv_types)  == 0)) {
		$tpl_engine->clear_all_assign();
		$tpl_engine->assign("errors", array ("inv_type" => "Belum ada SPBU yang memiliki inventory!"));

	} else {
		$hasInventory = "true";
		$tpl_engine->assign("inv_types", $inv_types);

		$gas_stations = $dp_mgr->findAllPlanGasStation();
		if (($gas_stations == NULL || sizeof($gas_stations)  == 0)) {
			$gas_stations = $st_mgr->findAll();
		}

		if ($so_list != NULL && sizeof($so_list) > 0) {
			$gas_stations = array();
		      foreach ($so_list as $key=>$value) {
					// find inv type
					$gas_st = $st_mgr->findByPrimaryKey($value->getStationId());
					if ($gas_st) {
					  $intersect = ControllerUtils::checkArray(array($gas_st), $gas_stations);
		
					  if ($intersect === FALSE) {
						  $gas_stations = array_merge($gas_stations, array($gas_st));
				  	  }
					}
				}
		}
	
		if (($gas_stations == NULL || sizeof($gas_stations)  == 0)) {

			$tpl_engine->clear_all_assign();
			$tpl_engine->assign("errors", array ("station_id" => "Belum ada SPBU yang terdaftar!"));

		} else {
			$hasStation = "true";
			$tpl_engine->assign("gas_stations", $gas_stations);
			
		}
	}
	
	if ($hasInventory == "true" && $hasStation == "true") {
	   $dist_loc_list = $dp_mgr->findAllPlanDistLoc();
		if (($dist_loc_list == NULL || sizeof($dist_loc_list)  == 0)) {
			$dist_loc_list = $dist_mgr->findAll();
		}

		if ($so_list != NULL && sizeof($so_list) > 0) {
			$dist_loc_list = array();
	        foreach ($so_list as $key=>$value) {
				// find inv type
				$gas_st = $st_mgr->findByPrimaryKey($value->getStationId());
				if ($gas_st) {
					$dist_loca = $dist_mgr->findByCode($gas_st->getLocationCode());
				
	               $intersect = ControllerUtils::checkArray(array($dist_loca), $dist_loc_list);
		
					if ($intersect === FALSE) {
						$dist_loc_list = array_merge($dist_loc_list, array($dist_loca));
					}
				}
				
			}
		}
		$tpl_engine->assign("dist_loc_list", $dist_loc_list);
		$pageNumber = @ $_REQUEST['salesOrderPage'];
		$totalSalesOrder = (int) $so_mgr->countAll();
		if (isset($sales_order_number) && !empty($sales_order_number)) {
			$totalSalesOrder = (int) $so_mgr->countAllBySalesOrderNumber($sales_order_number);
		}
		if (empty ($pageNumber)) {
			$pageNumber = 1;
		}
		$itemsPerPage = 10;
		$PaginateIt = new PaginateIt();
		$PaginateIt->SetItemsPerPage($itemsPerPage);
		$PaginateIt->SetItemCount($totalSalesOrder);
		$PaginateIt->SetQueryStringVar('salesOrderPage');
		
		$pageIndex = ((int) $pageNumber * $itemsPerPage - $itemsPerPage);
		if ($pageIndex > $totalSalesOrder) {
			$pageIndex = 0;
		}
		$sales_order_list = array();
	     if (isset($sales_order_number) && !empty($sales_order_number)) {
			$sales_order_list =  $so_mgr->findBySalesOrderNumber($pageIndex, $itemsPerPage, $sales_order_number);
		 } else {
		     $sales_order_list = $so_mgr->findAll($pageIndex, $itemsPerPage, NULL); 	
		 }
	    if ($sales_order_list != NULL && sizeof($sales_order_list) > 0) {
	    	$tpl_engine->assign("sales_order_list", $sales_order_list);
		   $tpl_engine->assign("paginatedSalesOrderList", $PaginateIt->GetPageLinks());
	    }

		$deliveryPlanPageNumber = @ $_REQUEST['deliveryPlanPage'];
		
	    $totalDeliveryPlan = (int) $dp_mgr->countAll();
		if (empty ($deliveryPlanPageNumber)) {
			$deliveryPlanPageNumber = 1;
		}
		$dl_itemsPerPage = 10;
		$dl_PaginateIt = new PaginateIt();
		$dl_PaginateIt->SetItemsPerPage($dl_itemsPerPage);
		$dl_PaginateIt->SetItemCount($totalDeliveryPlan);
		$dl_PaginateIt->SetQueryStringVar('deliveryPlanPage');
		
		$dl_pageIndex = ((int) $deliveryPlanPageNumber * $dl_itemsPerPage - $dl_itemsPerPage);
		if ($dl_pageIndex > $totalDeliveryPlan) {
			$dl_pageIndex = 0;
		}
		
		$delivery_plan_list = $dp_mgr->findAll($dl_pageIndex, $dl_itemsPerPage, NULL);
		$tpl_engine->assign("delivery_plan_list", $delivery_plan_list);
		$tpl_engine->assign("paginatedDeliveryPlanList", $dl_PaginateIt->GetPageLinks());
		
	}
}

function viewSalesOrder() {
	try {
		$sales_order_id = $_REQUEST["sales_order_id"];
		
		$tpl_engine = TemplateEngine::getEngine();

		
		$so_mgr = new SalesOrderManager();
		if (isset($sales_order_id) && !empty($sales_order_id)) {
			$vo = $so_mgr->findByPrimaryKey($sales_order_id);
			$tpl_engine->assign("salesOrder", $vo);
		} 
        _findAllData($tpl_engine);
        
		$tpl_engine->display('delivery_plan.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function edit() {
	try {
		$delivery_plan_id = $_REQUEST["delivery_plan_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$dp_mgr = new DeliveryPlanManager();
		$vo = $dp_mgr->findByPrimaryKey($delivery_plan_id);
		$tpl_engine->assign("deliveryPlan", $vo);
			
		_findAllData($tpl_engine);

		$tpl_engine->display('delivery_plan.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function prepare() {
	$tpl_engine = TemplateEngine::getEngine();

	_findAllData($tpl_engine);

	$tpl_engine->display('delivery_plan.tpl');

}

function create() {

	try {
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$vo = new DeliveryPlan();


			$dday = $_POST["Delivery_Date_Day"];
			if (strlen($dday) == 1) {
				$dday = '0'.$dday;
			}

			$delivery_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Delivery_Date_Month"], (int) $dday, (int) $_POST["Delivery_Date_Year"]));

			$vo->setDeliveryDate($delivery_date);
			$vo->setStationId($_POST["station_id"]);
			$vo->setDeliveryShiftNumber($_POST["delivery_shift_number"]);
			$vo->setInvType($_POST["inv_type"]);
			$vo->setQuantity($_POST["quantity"]);
			$vo->setDeliveryMessage($_POST["delivery_message"]);
			$vo->setSalesOrderNumber($_POST["sales_order_number"]);
            $vo->setPlanStatus("PLN");
			$dp_mgr = new DeliveryPlanManager();
			$dp_mgr->create($vo);
			
			$so_mgr = new SalesOrderManager();
			$sales_order = $so_mgr->findBySalesOrderNumberAndStation($_POST["sales_order_number"], $_POST["station_id"]);
			
			$so_mgr->updateStatus($sales_order->getSalesOrderId(), "PLN");

		} else {
			$tpl_engine->assign("errors", $errors);
		}
		_findAllData($tpl_engine);
		$tpl_engine->display('delivery_plan.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function update() {
	try {
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$vo = new DeliveryPlan();


			$dday = $_POST["Delivery_Date_Day"];
			if (strlen($dday) == 1) {
				$dday = '0'.$dday;
			}

			$delivery_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Delivery_Date_Month"], (int) $dday, (int) $_POST["Delivery_Date_Year"]));

			$vo->setDeliveryDate($delivery_date);
			$vo->setStationId($_POST["station_id"]);
			$vo->setDeliveryShiftNumber($_POST["delivery_shift_number"]);
			$vo->setInvType($_POST["inv_type"]);
			$vo->setQuantity($_POST["quantity"]);
			$vo->setDeliveryMessage($_POST["delivery_message"]);
			$vo->setSalesOrderNumber($_POST["sales_order_number"]);
			$vo->setDeliveryPlanId($_POST["delivery_plan_id"]);

			$dp_mgr = new DeliveryPlanManager();
			$dp_mgr->update($vo);

		} else {
			$tpl_engine->assign("errors", $errors);
		}
		_findAllData($tpl_engine);
		$tpl_engine->display('delivery_plan.tpl');

	} catch (Exception $e) {
		die($e);
	}
}



function validate() {
	$result = array ();


	if (empty ($_POST["station_id"])) {
		$result = array ("station_id" => "No. SPBU tidak dikenal");
	}

	if (empty ($_POST["Delivery_Date_Day"]) || empty ($_POST["Delivery_Date_Month"]) || empty ($_POST["Delivery_Date_Year"])) {
		$result = array ("delivery_date" => "Harap isi tanggal pengiriman");
	}
	if (empty ($_POST["delivery_shift_number"])) {
		$result = array ("delivery_shift_number" => "Silahkan pilih No. Shift");
	}
	if (empty ($_POST["inv_type"])) {
		$result = array ("inv_type" => "Tipe Inventory harus diisi");
	}
	if (empty ($_POST["quantity"])) {
		$result = array ("quantity" => "Jumlah order harus diisi");
	}
	if (empty ($_POST["sales_order_number"])) {
		$result = array ("sales_order_number" => "No. sales order harus diisi");
	}
	if (!empty($_REQUEST["delivery_message"]) && strlen($_REQUEST["delivery_message"]) > 255) {
		$result = array("delivery_message" => "Keterangan pengiriman max. 255 karakter");
	}
	return $result;
}

?>
