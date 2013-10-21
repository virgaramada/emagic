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
require_once 'classes/RealStockManager.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'classes/ControllerUtils.class.php';
require_once 'vo/RealStock.class.php';

require_once 'classes/TemplateEngine.class.php';
require_once 'classes/LogManager.class.php';

require_once 'classes/PaginateIt.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'utils/Validate.php';



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
     else if (empty ($_SESSION['user_role'])) {

		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');

	} else if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_OWNER && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_ADMINISTRATOR && 
                       $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_OPERATOR) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk merubah/menambah real stock"));
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
		$real_stock_id = $_REQUEST["real_stock_id"];
		$tpl_engine = TemplateEngine::getEngine();


		$rs_mgr = new RealStockManager();
		$vo = $rs_mgr->findByPrimaryKey($real_stock_id);
		$tpl_engine->assign("realStock", $vo);	

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}

function prepare($tpl_engine=NULL) {
 	
	if (!isset($tpl_engine)) {
		$tpl_engine = TemplateEngine::getEngine();
		
	} 
	$real_stock_list = _findAll($tpl_engine);
	$tpl_engine->assign("real_stock_list", $real_stock_list);
		
	$inv_types = ControllerUtils::findAllInventoryType();
	$tpl_engine->assign("inv_types", $inv_types);
	$tpl_engine->display('real_stock.tpl');
}

function create() {

	try {
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$_vo = new RealStock();
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setQuantity($_POST["quantity"]);
			$start_day = $_POST["Start_Date_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			
			$start_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Start_Date_Month"], (int) $start_day, (int) $_POST["Start_Date_Year"]));
			$_vo->setStartDate($start_date);
			
			$end_day = $_POST["End_Date_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			
			$end_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["End_Date_Month"], (int) $end_day, (int) $_POST["End_Date_Year"]));
			$_vo->setEndDate($end_date);
			
			$_vo->setStationId($_SESSION["station_id"]);

			$rs_mgr = new RealStockManager();
			$rs_mgr->create($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}
		prepare($tpl_engine);
		
	} catch (Exception $e) {
		die($e);
	}
}
function update() {
	try {
		$real_stock_id = $_POST["real_stock_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$_vo = new RealStock();
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setQuantity($_POST["quantity"]);
			$start_day = $_POST["Start_Date_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			
			$start_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Start_Date_Month"], (int) $start_day, (int) $_POST["Start_Date_Year"]));
			$_vo->setStartDate($start_date);
			
			$end_day = $_POST["End_Date_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			
			$end_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["End_Date_Month"], (int) $end_day, (int) $_POST["End_Date_Year"]));
			$_vo->setEndDate($end_date);
			
			$_vo->setStationId($_SESSION["station_id"]);
			$_vo->setRealStockId($real_stock_id);

			$rs_mgr = new RealStockManager();
			$rs_mgr->update($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}
function delete() {
	try {
		$real_stock_id = $_REQUEST["real_stock_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$rs_mgr = new RealStockManager();
		$rs_mgr->delete($real_stock_id);

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}
function deleteAll() {
	try {
		$tpl_engine = TemplateEngine::getEngine();

		$rs_mgr = new RealStockManager();
		$rs_mgr->deleteAll($_SESSION["station_id"]);

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}

function _findAll($tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];
	$rs_mgr = new RealStockManager();
	$totalData = (int) $rs_mgr->countAll($_SESSION["station_id"]);

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
	$result = $rs_mgr->findAll($pageIndex, $itemsPerPage, $_SESSION["station_id"]);
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("paginatedRealStockList", $PaginateIt->GetPageLinks());
	}
	
	
	return $result;
}
function validate() {
	
	$result = array ();
	if (empty ($_POST["inventory_type"])) {
		$result = array ("inventory_type" => "Silahkan pilih jenis bahan bakar");
	}
	if (empty ($_POST["quantity"]) || !is_numeric($_POST["quantity"])) {
		$result = array ("quantity" => "Silahkan isi kuantitas dengan benar");

	} else if (strlen($_POST["quantity"]) > 10) {
		$result = array ("quantity" => "Kuantitas max 10 digit");
	} else if ((int)$_POST["quantity"] <= 0) {
		$result = array ("quantity" => "Kuantitas tidak boleh kurang/sama dengan nol");
	} 

	if (empty ($_POST["Start_Date_Month"])) {
		$result = array ("Start_Date_Month" => "Silahkan pilih bulan mulai berlaku");
	}
	if (empty ($_POST["Start_Date_Year"])) {
		$result = array ("Start_Date_Year" => "Silahkan pilih tahun mulai berlaku");
	}
	if (empty ($_POST["Start_Date_Day"])) {
		$result = array ("Start_Date_Day" => "Silahkan pilih tanggal mulai berlaku");
	}
    if (empty ($_POST["End_Date_Month"])) {
		$result = array ("End_Date_Month" => "Silahkan pilih bulan mulai berlaku");
	}
	if (empty ($_POST["End_Date_Year"])) {
		$result = array ("End_Date_Year" => "Silahkan pilih tahun mulai berlaku");
	}
	if (empty ($_POST["End_Date_Day"])) {
		$result = array ("End_Date_Day" => "Silahkan pilih tanggal mulai berlaku");
	}
	
	return $result;
}

?>