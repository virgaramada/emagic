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

require_once 'classes/SalesOrderManager.class.php';
require_once 'vo/SalesOrder.class.php';
require_once 'classes/ControllerUtils.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/PaginateIt.class.php';

//define("IS_DEBUG", false);
//define("IS_CACHING", false);

if (empty ($_REQUEST['PHPSESSID'])) {
	$tpl_engine = TemplateEngine::getEngine();
	//$tpl_engine->caching = IS_CACHING;
	//$tpl_engine->debugging = IS_DEBUG;
	$tpl_engine->assign("errors", array ("session_expired" => "Anda harus login terlebih dahulu"));
	$tpl_engine->display('login.tpl');

} else {
	session_id($_REQUEST['PHPSESSID']);
	session_start();
	validateSession();
}

function validateSession() {
	$method_type = @ $_REQUEST["method"];

	$station_id = $_REQUEST["station_id"];
	if (!empty($station_id)) {
		viewByStationId($station_id);
	} else {
		if (empty($_SESSION["station_id"])) {
			$tpl_engine = TemplateEngine::getEngine();
			//$tpl_engine->caching = IS_CACHING;
			//$tpl_engine->debugging = IS_DEBUG;
			$tpl_engine->assign("errors", array ("station_id" => "SPBU tidak dikenal!"));
			$tpl_engine->display('login.tpl');
		}
		else if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_ADMINISTRATOR && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_OWNER && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_OPERATOR) {
			$tpl_engine = TemplateEngine::getEngine();
			//$tpl_engine->caching = IS_CACHING;
			//$tpl_engine->debugging = IS_DEBUG;
			$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk membuat sales order"));
			$tpl_engine->display('login.tpl');

		} else if (empty ($_SESSION['user_role'])) {

			$tpl_engine = TemplateEngine::getEngine();
			//$tpl_engine->caching = IS_CACHING;
			//$tpl_engine->debugging = IS_DEBUG;
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
			/**
			 if ($method_type == 'delete') {
				delete();
				}
				*/
			if ($method_type == 'view') {
				view();
			}
			/**
			 if ($method_type == 'deleteAll') {
				deleteAll();
				}
				*/
			 

		}
	}

}
function view() {
	try {
		$sales_order_id = $_REQUEST["sales_order_id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$so_mgr = new SalesOrderManager();
		$vo = $so_mgr->findByPrimaryKey($sales_order_id);
		$tpl_engine->assign("salesOrder", $vo);

		$result = _findAll($tpl_engine);
		$tpl_engine->assign("sales_order_list", $result);
		$inv_types = ControllerUtils::findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);


		$tpl_engine->display('sales_order.tpl');

	} catch (Exception $e) {
		die($e);
	}
}


function viewByStationId($station_id) {
	try {

		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$inv_types = ControllerUtils::findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);

		$result = viewAll($tpl_engine, $station_id);
		$tpl_engine->assign("sales_order_list", $result);
		$tpl_engine->display('sales_order_view.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function viewAll($tpl_engine = NULL, $station_id) {
	$pageNumber = @ $_REQUEST['page'];
	$so_mgr = new SalesOrderManager();
	$totalData = (int) $so_mgr->countAll($station_id);
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
	$result = $so_mgr->findAll($pageIndex, $itemsPerPage, $station_id);
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("paginatedSalesOrderList", $PaginateIt->GetPageLinks());
	}
	return $result;
}
function prepare() {
	$tpl_engine = TemplateEngine::getEngine();
	//$tpl_engine->caching = IS_CACHING;
	//$tpl_engine->debugging = IS_DEBUG;


	$result = _findAll($tpl_engine);
	$tpl_engine->assign("sales_order_list", $result);



	$inv_types = ControllerUtils::findAllInventoryType();
	$tpl_engine->assign("inv_types", $inv_types);
	$tpl_engine->display('sales_order.tpl');

}

function create() {

	try {
		$so_mgr = new SalesOrderManager();
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$errors = validate();

		if (empty ($errors)) {
				
			$vo = new SalesOrder();
			$vo->setStationId($_SESSION["station_id"]);
			$vo->setBankAccNumber($_POST["bank_acc_number"]);
			$vo->setBankName($_POST["bank_name"]);

			$day = $_POST["Transfer_Date_Day"];
			if (strlen($day) == 1) {
				$day = '0'.$day;
			}

			$transfer_date = date("Y-m-d H:i:s", mktime((int) $_POST["Transfer_Time_Hour"], (int) $_POST["Transfer_Time_Minute"], 0, (int) $_POST["Transfer_Date_Month"], (int) $day, (int) $_POST["Transfer_Date_Year"]));

			$dday = $_POST["Delivery_Date_Day"];
			if (strlen($dday) == 1) {
				$dday = '0'.$dday;
			}

			$delivery_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Delivery_Date_Month"], (int) $dday, (int) $_POST["Delivery_Date_Year"]));

			$vo->setBankTransferDate($transfer_date);
			$vo->setDeliveryShiftNumber($_POST["delivery_shift_number"]);
			$vo->setOrderMessage($_POST["order_message"]);
			$vo->setDeliveryDate($delivery_date);
			$vo->setInvType($_POST["inv_type"]);
			$vo->setQuantity($_POST["quantity"]);
			$vo->setSalesOrderNumber($_POST["sales_order_number"]);
			$vo->setOrderStatus("REQ");
			
			$order_date = date("Y-m-d H:i:s");
            $vo->setOrderDate($order_date);
            
			$so_mgr->create($vo);

		} else {
			$tpl_engine->assign("errors", $errors);
		}
		$result = _findAll($tpl_engine);
		$tpl_engine->assign("sales_order_list", $result);
		$inv_types = ControllerUtils::findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('sales_order.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function update() {
	try {
		$sales_order_id = $_POST["sales_order_id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$errors = validate(true);
		if (empty ($errors)) {
			$so_mgr = new SalesOrderManager();

			$vo = new SalesOrder();
			$vo->setStationId($_SESSION["station_id"]);
			$vo->setBankAccNumber($_POST["bank_acc_number"]);
			$vo->setBankName($_POST["bank_name"]);

			$day = $_POST["Transfer_Date_Day"];
			if (strlen($day) == 1) {
				$day = '0'.$day;
			}
			$transfer_date = date("Y-m-d H:i:s", mktime((int) $_POST["Transfer_Time_Hour"], (int) $_POST["Transfer_Time_Minute"], 0, (int) $_POST["Transfer_Date_Month"], (int) $day, (int) $_POST["Transfer_Date_Year"]));

			$dday = $_POST["Delivery_Date_Day"];
			if (strlen($dday) == 1) {
				$dday = '0'.$dday;
			}
			$delivery_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Delivery_Date_Month"], (int) $dday, (int) $_POST["Delivery_Date_Year"]));

			$vo->setBankTransferDate($transfer_date);
			$vo->setDeliveryShiftNumber($_POST["delivery_shift_number"]);
			$vo->setOrderMessage($_REQUEST["order_message"]);
			$vo->setDeliveryDate($delivery_date);
			$vo->setInvType($_POST["inv_type"]);
			$vo->setQuantity($_POST["quantity"]);
			$vo->setSalesOrderNumber($_POST["sales_order_number"]);
			$vo->setSalesOrderId($sales_order_id);
			$vo->setOrderStatus("REQ");

			$so_mgr->update($vo);

		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$result = _findAll($tpl_engine);
		$tpl_engine->assign("sales_order_list", $result);

		$inv_types = ControllerUtils::findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('sales_order.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function delete() {
	try {
		$sales_order_id = $_REQUEST["sales_order_id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$so_mgr = new SalesOrderManager();
		$so_mgr->delete($sales_order_id);

		$result = _findAll($tpl_engine);
		$tpl_engine->assign("sales_order_list", $result);

		$inv_types = ControllerUtils::findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);

		$tpl_engine->display('sales_order.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function deleteAll() {
	try {

		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$so_mgr = new SalesOrderManager();
		$so_mgr->deleteAll($_SESSION["station_id"]);

		$result = _findAll($tpl_engine);
		$tpl_engine->assign("sales_order_list", $result);

		$inv_types = ControllerUtils::findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);

		$tpl_engine->display('sales_order.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function _findAll($tpl_engine) {
	$pageNumber = @ $_REQUEST['page'];
	$so_mgr = new SalesOrderManager();
	$totalData = (int) $so_mgr->countAll($_SESSION["station_id"]);
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
	$result = $so_mgr->findAll($pageIndex, $itemsPerPage, $_SESSION["station_id"]);
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("paginatedSalesOrderList", $PaginateIt->GetPageLinks());
	}
	return $result;
}
function validate($is_update=false) {
	$result = array ();


	if (empty ($_POST["bank_acc_number"])) {
		$result = array ("bank_acc_number" => "No. acc bank harus diisi");
	}
	if (empty ($_POST["bank_name"])) {
		$result = array ("bank_name" => "Nama Bank harus diisi");
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
	} else if (!$is_update) {
		$so_mgr = new SalesOrderManager();
		$dupl_so = $so_mgr->findBySalesOrderNumberAndStation($_POST["sales_order_number"], $_SESSION["station_id"]);

		if (!empty($dupl_so)) {
			$result = array("sales_order_dupl" => "Nomor SO sudah ada dalam database. Silahkan coba yang lain");
		}
	}
	if (!empty($_REQUEST["order_message"]) && strlen($_REQUEST["order_message"]) > 255) {
		$result = array("order_message" => "Internal message max 255 karakter");
	}

	return $result;
}

?>