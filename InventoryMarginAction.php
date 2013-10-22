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
require_once 'classes/InventoryMarginManager.class.php';
require_once 'vo/InventoryMargin.class.php';
//require_once 'libs/smarty-2.6.18/Smarty.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'vo/InventoryType.class.php';

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
	if (empty($_SESSION["station_id"])) {
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("station_id" => "SPBU tidak dikenal!"));
		$tpl_engine->display('login.tpl');
	}
	else if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != 'SUP' && $_SESSION['user_role'] != 'ADM' && $_SESSION['user_role'] != 'OWN') {
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk menambah/merubah margin"));
		$tpl_engine->display('login.tpl');

	} else if (empty ($_SESSION['user_role'])) {

		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
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

function findAllInventoryType() {
	$inv_mgr = new InventoryTypeManager();
	$result = $inv_mgr->findAll(NULL, NULL, $_SESSION["station_id"]);
	return $result;
}
function edit() {
	try {
		$inv_id = $_REQUEST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$inv_mgr = new InventoryMarginManager();
		$vo = $inv_mgr->findByPrimaryKey($inv_id);
		$tpl_engine->assign("inventoryMargin", $vo);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_margin_list", $result);
		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('inventory_margin.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function prepare() {

	$tpl_engine = TemplateEngine::getEngine();
	//$tpl_engine->caching = IS_CACHING;
	//$tpl_engine->debugging = IS_DEBUG;

	$result = findAll($tpl_engine);
	$tpl_engine->assign("inv_margin_list", $result);
	$inv_types = findAllInventoryType();
	$tpl_engine->assign("inv_types", $inv_types);
	$tpl_engine->display('inventory_margin.tpl');

}
function create() {
	try {
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new InventoryMargin();
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setMarginValue($_POST["margin_value"]);
			$_vo->setStationId($_SESSION["station_id"]);
			
			$sday = $_POST["Start_Date_Day"];
			$eday = $_POST["End_Date_Day"];
			
			if (strlen($sday) == 1) {
				$sday = '0'.$sday;
			}
		    if (strlen($eday) == 1) {
				$eday = '0'.$eday;
			}

			$start_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Start_Date_Month"], 
			                  (int) $sday, (int) $_POST["Start_Date_Year"]));
			                  
            $end_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["End_Date_Month"], 
			                  (int) $eday, (int) $_POST["End_Date_Year"]));
			                  
			$_vo->setStartDate($start_date);
			$_vo->setEndDate($end_date);
			

			$inv_mgr = new InventoryMarginManager();
			$inv_margin_exist = $inv_mgr->findByInventoryTypeAndDate($_POST["inventory_type"], $start_date, $end_date, $_SESSION["station_id"]);
			if (!empty ($inv_margin_exist)) {
				$errors = array ("margin_value" => "Hanya diperbolehkan satu margin tiap inventory.");
				$tpl_engine->assign("errors", $errors);
			} else {
				$inv_mgr->create($_vo);
			}

		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_margin_list", $result);
		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('inventory_margin.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function update() {
	try {
		$inv_id = $_POST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new InventoryMargin();
			$_vo->setInvType($_REQUEST["inventory_type"]);
			$_vo->setMarginValue($_REQUEST["margin_value"]);
			
			$sday = $_POST["Start_Date_Day"];
			$eday = $_POST["End_Date_Day"];
			
			if (strlen($sday) == 1) {
				$sday = '0'.$sday;
			}
		    if (strlen($eday) == 1) {
				$eday = '0'.$eday;
			}

			$start_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Start_Date_Month"], 
			                  (int) $sday, (int) $_POST["Start_Date_Year"]));
			                  
            $end_date = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["End_Date_Month"], 
			                  (int) $eday, (int) $_POST["End_Date_Year"]));
			                  
			$_vo->setStartDate($start_date);
			$_vo->setEndDate($end_date);
			
			$_vo->setInvId($inv_id);

			$inv_mgr = new InventoryMarginManager();
			$inv_mgr->update($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_margin_list", $result);
		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('inventory_margin.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function delete() {
	try {
		$inv_id = $_REQUEST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$inv_mgr = new InventoryMarginManager();
		$inv_mgr->delete($inv_id);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_margin_list", $result);
		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('inventory_margin.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function deleteAll() {
	try {

		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$inv_mgr = new InventoryMarginManager();
		$inv_mgr->deleteAll($_SESSION["station_id"]);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("inv_margin_list", $result);
		$inv_types = findAllInventoryType();
		$tpl_engine->assign("inv_types", $inv_types);
		$tpl_engine->display('inventory_margin.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function findAll($tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];
	$inv_mgr = new InventoryMarginManager();
	$totalData = (int) $inv_mgr->countAll($_SESSION["station_id"]);
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
	$result = $inv_mgr->findAll($pageIndex, $itemsPerPage, $_SESSION["station_id"]);
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("paginatedMarginList", $PaginateIt->GetPageLinks());
	}
	return $result;

}
function validate() {
	$result = array ();
	if (empty ($_POST["inventory_type"])) {
		$result = array ("inventory_type" => "Silahkan isi jenis bahan bakar dengan benar");

	}
	if (empty ($_POST["margin_value"]) || !is_numeric($_POST["margin_value"])) {
		$result = array ("margin_value" => "Silahkan isi jumlah margin dengan benar");
	} else if (strlen($_POST["margin_value"]) > 10) {
		$result = array ("margin_value" => "Jumlah margin max 10 digit ");
	}

	return $result;
}
?>