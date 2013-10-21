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
require_once 'classes/InventoryTypeManager.class.php';
require_once 'vo/InventoryType.class.php';

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
	
	 /**if (empty($_SESSION["station_id"])) {
		$tpl_engine = TemplateEngine::getEngine();
		$tpl_engine->assign("errors", array ("station_id" => "SPBU tidak dikenal!"));
		$tpl_engine->display('login.tpl');
	} 
	else*/ if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_OWNER) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk merubah inventory"));
		$tpl_engine->display('login.tpl');

	} else if (empty ($_SESSION['user_role'])) {

		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
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
		$inv_id = $_REQUEST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new InventoryTypeManager();
		$vo = $inv_mgr->findByPrimaryKey($inv_id);
		$tpl_engine->assign("inventoryType", $vo);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_type_list", $result);
		$tpl_engine->display('inventory_type.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function prepare() {

	$tpl_engine = TemplateEngine::getEngine();

	$result = findAll($tpl_engine);
	$tpl_engine->assign("inv_type_list", $result);
	$tpl_engine->display('inventory_type.tpl');
}

function create() {

	try {
		$tpl_engine = TemplateEngine::getEngine();
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new InventoryType();
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setInvDesc($_POST["inventory_desc"]);
			$_vo->setProductType($_POST["product_type"]);
			
			
			$inv_mgr = new InventoryTypeManager();
			$inv_mgr->create($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}
		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_type_list", $result);
		$tpl_engine->display('inventory_type.tpl');
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
			$_vo = new InventoryType();
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setInvDesc($_POST["inventory_desc"]);
			$_vo->setProductType($_POST["product_type"]);
			$_vo->setInvId($inv_id);

			$inv_mgr = new InventoryTypeManager();
			$inv_mgr->update($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_type_list", $result);
		$tpl_engine->display('inventory_type.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function delete() {
	try {
		$inv_id = $_REQUEST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new InventoryTypeManager();
		$inv_mgr->delete($inv_id);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_type_list", $result);
		$tpl_engine->display('inventory_type.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function deleteAll() {
	try {
		$tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new InventoryTypeManager();
		$inv_mgr->deleteAll();

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_type_list", $result);
		$tpl_engine->display('inventory_type.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function findAll($tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];
	$inv_mgr = new InventoryTypeManager();
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
		$tpl_engine->assign("paginatedInvType", $PaginateIt->GetPageLinks());
	}
	return $result;
}
function validate() {
	$result = array ();
	
	if (empty ($_POST["inventory_type"])) {
		$result = array ("inventory_type" => "Silahkan isi kode inventory dengan benar");
	} else if (strlen($_POST["inventory_type"]) > 50) {
		$result = array ("inventory_type" => "Kode inventory max 50 karakter");
	} else {

		$inv_mgr = new InventoryTypeManager();
	    $listOfInventories =  $inv_mgr->findByInventoryType($_POST["inventory_type"]);
	   if (!empty ($listOfInventories)) {
		$result = array ("inventory_type" => "Kode inventory sudah ada dalam database. Silahkan coba yang lain");
	   }
	}
	 
	if (empty ($_POST["product_type"])) {
		$result = array ("product_type" => "Silahkan pilih jenis produk");
	} else if (strlen($_POST["product_type"]) > 10) {
		$result = array ("product_type" => "Jenis produk max 10 karakter");
	}
	

	return $result;
}
?>