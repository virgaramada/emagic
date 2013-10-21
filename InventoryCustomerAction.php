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
require_once 'classes/InventoryCustomerManager.class.php';
require_once 'vo/Customer.class.php';


require_once 'classes/TemplateEngine.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'classes/Constants.class.php';
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
	 /*if (empty($_SESSION["station_id"])) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("station_id" => "SPBU tidak dikenal!"));
		$tpl_engine->display('login.tpl');
	} 
	 else */ if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_OWNER) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk merubah tipe konsumen"));
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
function edit() {
	try {
		$cust_id = $_REQUEST["cust_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new InventoryCustomerManager();
		$vo = $inv_mgr->findByPrimaryKey($cust_id);
		$tpl_engine->assign("inventoryCustomer", $vo);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_customer_list", $result);
		$tpl_engine->display('inventory_customer.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function prepare() {
	$tpl_engine = TemplateEngine::getEngine();


	$result = findAll($tpl_engine);
	$tpl_engine->assign("inv_customer_list", $result);
	$tpl_engine->display('inventory_customer.tpl');

}

function create() {

	try {
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$_vo = new Customer();
			$_vo->setCustomerType($_POST["customer_type"]);
			$_vo->setCustomerDesc($_POST["customer_desc"]);
			$_vo->setCategory($_POST["category"]);
			
			$inv_mgr = new InventoryCustomerManager();

			$is_cust_exist = $inv_mgr->findByCustomerDesc($_POST["customer_desc"]);
			
			if (!empty ($is_cust_exist)) {
				$tpl_engine->assign("errors", array ("customer_desc" => "Tipe Konsumen sudah ada, silahkan pilih yang lain"));
			} else {
				$inv_mgr->create($_vo);
			}

		} else {
			$tpl_engine->assign("errors", $errors);
		}
		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_customer_list", $result);
		$tpl_engine->display('inventory_customer.tpl');
	} catch (Exception $e) {
		die($e);
	}
}
function update() {
	try {
		$cust_id = $_POST["cust_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$_vo = new Customer();
			$_vo->setCustomerType($_POST["customer_type"]);
			$_vo->setCustomerDesc($_POST["customer_desc"]);
			$_vo->setCategory($_POST["category"]);
			$_vo->setCustId($cust_id);

			$inv_mgr = new InventoryCustomerManager();
			$inv_mgr->update($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_customer_list", $result);
		$tpl_engine->display('inventory_customer.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function delete() {
	try {
		$cust_id = $_REQUEST["cust_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new InventoryCustomerManager();
		$inv_mgr->delete($cust_id);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_customer_list", $result);
		$tpl_engine->display('inventory_customer.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function deleteAll() {
	try {

		$tpl_engine = TemplateEngine::getEngine();


		$inv_mgr = new InventoryCustomerManager();
		$inv_mgr->deleteAll();

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_customer_list", $result);
		$tpl_engine->display('inventory_customer.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function findAll($tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];
	$inv_mgr = new InventoryCustomerManager();
	$totalData = (int) $inv_mgr->countAll();
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
	$result = $inv_mgr->findAll($pageIndex, $itemsPerPage);
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("paginatedCustomerList", $PaginateIt->GetPageLinks());
	}
	return $result;
}
function validate() {
	$result = array ();
	if (empty ($_POST["customer_type"])) {
		$result = array ("customer_type" => "Silahkan isi kode konsumen dengan benar");
	}
	if (empty ($_POST["customer_desc"])) {
		$result = array ("customer_desc" => "Silahkan isi keterangan konsumen dengan benar");
	}
	if (empty ($_POST["category"])) {
		$result = array ("category" => "Silahkan isi kategori dengan benar");
	}

	return $result;
}
?>