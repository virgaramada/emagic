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
require_once 'classes/TankCapacityManager.class.php';
require_once 'classes/StationManager.class.php';
require_once 'vo/TankCapacity.class.php';
require_once 'classes/ControllerUtils.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'vo/InventoryType.class.php';

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
   if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::POWER_USER) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk menambah/merubah kapasitas tanki"));
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
	    if ($method_type == 'selectStation') {
			selectStation();
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
	$result = $inv_mgr->findAll();
	return $result;
}
function edit() {
	try {
		$inv_id = $_REQUEST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();


		$inv_mgr = new TankCapacityManager();
		$vo = $inv_mgr->findByPrimaryKey($inv_id);
		$tpl_engine->assign("tankCapacity", $vo);

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}
function selectStation() {
	try {
		$station_id = $_REQUEST["station_id"];
		$tpl_engine = TemplateEngine::getEngine();
	
		$st_mgr = new StationManager();
		$gas_station = $st_mgr->findByPrimaryKey($station_id);
		$tpl_engine->assign("gas_station", $gas_station);

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}
function prepare($tpl_engine=NULL) {

	if (!isset($tpl_engine)) {
	    $tpl_engine = TemplateEngine::getEngine();

	}
	

	$result = findAll($tpl_engine);
	$tpl_engine->assign("tank_capacity_list", $result);
	$inv_types = findAllInventoryType();
	$tpl_engine->assign("inv_types", $inv_types);
	$tpl_engine->display('tank_capacity.tpl');

}
function create() {
	try {
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$_vo = new TankCapacity();
			$_vo->setInvType($_POST["inventory_type"]);
			$_vo->setTankCapacity($_POST["tank_capacity"]);
			$_vo->setStationId($_POST["station_id"]);

			$inv_mgr = new TankCapacityManager();
			$tank_cap_exist = $inv_mgr->findByInventoryType($_POST["inventory_type"], $_POST["station_id"]);
			if (!empty ($tank_cap_exist)) {
				$errors = array ("tank_capacity" => "Hanya diperbolehkan satu kapasitas tanki tiap inventory.");
				$tpl_engine->assign("errors", $errors);
			} else {
				$inv_mgr->create($_vo);
			}

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
		$inv_id = $_POST["inv_id"];
	    $tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$_vo = new TankCapacity();
			$_vo->setInvType($_REQUEST["inventory_type"]);
			$_vo->setTankCapacity($_REQUEST["tank_capacity"]);
			$_vo->setId($inv_id);

			$inv_mgr = new TankCapacityManager();
			$inv_mgr->update($_vo);
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
		$inv_id = $_REQUEST["inv_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new TankCapacityManager();
		$inv_mgr->delete($inv_id);

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}
function deleteAll() {
	try {

	    $tpl_engine = TemplateEngine::getEngine();

		$inv_mgr = new TankCapacityManager();
		$inv_mgr->deleteAll();

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}
function findAll($tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];
	$inv_mgr = new TankCapacityManager();
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
	$result = $inv_mgr->findAll($pageIndex, $itemsPerPage, NULL);
	if (isset ($tpl_engine)) {
		$tpl_engine->assign("paginatedTankCapacityList", $PaginateIt->GetPageLinks());
		_findAllStation($tpl_engine);
	}
	
	
	return $result;

}
function validate() {
	$result = array ();
	$tank_cap_mgr = new TankCapacityManager();
	if (empty ($_POST["inventory_type"])) {
		$result = array ("inventory_type" => "Silahkan isi jenis bahan bakar dengan benar");

	}
    if (empty ($_POST["station_id"])) {
		$result = array ("station_id" => "Silahkan isi No. SPBU");

	}
	else if (empty ($_POST["tank_capacity"]) || !is_numeric($_POST["tank_capacity"])) {
		$result = array ("tank_capacity" => "Silahkan isi kapasitas tanki dengan benar");
	} else if (strlen($_POST["tank_capacity"]) > 10) {
		$result = array ("tank_capacity" => "Kapasitas tanki max 10 digit ");
	}
	
	

	return $result;
}

function _findAllStation($tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];
	$st_mgr = new StationManager();
	$totalData = (int) $st_mgr->countAllIgnoreStatus();

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
	$result = $st_mgr->findAllIgnoreStatus($pageIndex, $itemsPerPage);
	$dist_locations =  ControllerUtils::findAllDistLocation();
	if (isset ($tpl_engine)) {
		$tpl_engine->assign("paginatedGasStationList", $PaginateIt->GetPageLinks());
		$tpl_engine->assign("dist_locations", $dist_locations);
		$tpl_engine->assign("gas_station_list", $result);
	}
	
	
}
?>