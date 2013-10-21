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
require_once 'classes/DistributionLocationManager.class.php';
require_once 'vo/DistributionLocation.class.php';
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
   if (empty ($_SESSION['user_role'])) {

		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');

	}
	else if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::POWER_USER) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk mengatur wilayah penyaluran"));
		$tpl_engine->display('login.tpl');

	}   else {

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
		$dist_loc_id = $_REQUEST["dist_loc_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$dist_mgr = new DistributionLocationManager();
		$vo = $dist_mgr->findByPrimaryKey($dist_loc_id);
		$tpl_engine->assign("distributionLocation", $vo);

		$dist_locations = _findAll($dist_mgr, $tpl_engine);
		$tpl_engine->assign("dist_locations", $dist_locations);
		$tpl_engine->display('distribution_location.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function prepare() {

	
	$tpl_engine = TemplateEngine::getEngine();

	$dist_mgr = new DistributionLocationManager();
	$dist_locations = _findAll($dist_mgr, $tpl_engine);
	$tpl_engine->assign("dist_locations", $dist_locations);
	$tpl_engine->display('distribution_location.tpl');
}

function create() {

	try {
		$tpl_engine = TemplateEngine::getEngine();
	    $dist_mgr = new DistributionLocationManager();
		$errors = validate();
		if (empty ($errors)) {
			
			
			$_vo = new DistributionLocation();
			$_vo->setLocationCode($_POST["location_code"]);
			$_vo->setLocationName($_POST["location_name"]);
			$_vo->setSupplyPoint($_POST["supply_point"]);
			$_vo->setSalesAreaManager($_POST["sales_area_manager"]);
			
			$code_exist = $dist_mgr->findByCode($_POST["location_code"]);
			if (!empty ($code_exist)) {
				$errors = array ("location_code" => "Kode wilayah sudah ada dalam database. Silahkan pilih yang lain");
				$tpl_engine->assign("errors", $errors);
			} else {
				$dist_mgr->create($_vo);
			}

		} else {
			$tpl_engine->assign("errors", $errors);
		}
		$dist_locations = _findAll($dist_mgr, $tpl_engine);
	    $tpl_engine->assign("dist_locations", $dist_locations);
		$tpl_engine->display('distribution_location.tpl');
	} catch (Exception $e) {
		die($e);
	}
}
function update() {
	try {
		
		$tpl_engine = TemplateEngine::getEngine();

	    $dist_mgr = new DistributionLocationManager();
	    
		$errors = validate();
		if (empty ($errors)) {
			
			$_vo = new DistributionLocation();
			$_vo->setLocationCode($_POST["location_code"]);
			$_vo->setLocationName($_POST["location_name"]);
			$_vo->setSupplyPoint($_POST["supply_point"]);
			$_vo->setSalesAreaManager($_POST["sales_area_manager"]);
            $_vo->setLocationId($_POST["dist_loc_id"]);
			
            $dist_mgr->update($_vo);
			
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$dist_locations = _findAll($dist_mgr, $tpl_engine);
	    $tpl_engine->assign("dist_locations", $dist_locations);
		$tpl_engine->display('distribution_location.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function delete() {
	try {
		$dist_loc_id = $_REQUEST["dist_loc_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$dist_mgr = new DistributionLocationManager();
		$dist_mgr->delete($dist_loc_id);

		$dist_locations = _findAll($dist_mgr, $tpl_engine);
	    $tpl_engine->assign("dist_locations", $dist_locations);
		$tpl_engine->display('distribution_location.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function deleteAll() {
	try {

		$tpl_engine = TemplateEngine::getEngine();

		$dist_mgr = new DistributionLocationManager();
		$dist_mgr->deleteAll();

		$dist_locations = _findAll($dist_mgr, $tpl_engine);
	    $tpl_engine->assign("dist_locations", $dist_locations);
		$tpl_engine->display('distribution_location.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function _findAll(DistributionLocationManager $dist_mgr, $tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];

	$totalData = (int) $dist_mgr->countAll();
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
	$result = $dist_mgr->findAll($pageIndex, $itemsPerPage);
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("paginatedDistributionLocationList", $PaginateIt->GetPageLinks());
	}
	return $result;
}
function validate() {
	$result = array ();
	if (empty ($_POST["location_code"])) {
		$result = array ("location_code" => "Silahkan isi Kode wilayah");
	}

	if (empty ($_POST["location_name"])) {
		$result = array ("location_name" => "Silahkan isi Nama wilayah");

	}
    if (empty ($_POST["supply_point"])) {
		$result = array ("supply_point" => "Silahkan isi Supply point");

	}
    if (empty ($_POST["sales_area_manager"])) {
		$result = array ("sales_area_manager" => "Silahkan isi Salea Area Manager");

	}
	return $result;
}
?>