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
require_once 'classes/DepotManager.class.php';
require_once 'vo/Depot.class.php';
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
   if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::POWER_USER) {
		$tpl_engine = TemplateEngine::getEngine();
	    //$tpl_engine->caching = IS_CACHING;
	    //$tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk menambah/merubah depot"));
		$tpl_engine->display('login.tpl');

	} else if (empty ($_SESSION['user_role'])) {

	    $tpl_engine = TemplateEngine::getEngine();
	   // $tpl_engine->caching = IS_CACHING;
	   // $tpl_engine->debugging = IS_DEBUG;
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

function edit() {
	try {
		$depotId = $_REQUEST["depot_id"];
		$tpl_engine = TemplateEngine::getEngine();
	    //$tpl_engine->caching = IS_CACHING;
	   // $tpl_engine->debugging = IS_DEBUG;

		$dep_mgr = new DepotManager();
		$vo = $dep_mgr->findByPrimaryKey($depotId);
		$tpl_engine->assign("depot", $vo);

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}

function prepare($tpl_engine=NULL) {

	if (!isset($tpl_engine)) {
	    $tpl_engine = TemplateEngine::getEngine();
	    //$tpl_engine->caching = IS_CACHING;
	    //$tpl_engine->debugging = IS_DEBUG;
	}
	
	$result = findAll($tpl_engine);
	$tpl_engine->assign("depot_list", $result);
	$tpl_engine->display('depot.tpl');

}
function create() {
	try {
		$tpl_engine = TemplateEngine::getEngine();
	    //$tpl_engine->caching = IS_CACHING;
	    //$tpl_engine->debugging = IS_DEBUG;
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new Depot();
			$_vo->setDepotCode($_POST["depot_code"]);
			$_vo->setDepotName($_POST["depot_name"]);
			$_vo->setDepotAddress($_POST["depot_address"]);

			$dep_mgr = new DepotManager();
			$req_dep_code = $_POST["depot_code"];
			$depot_exist = $dep_mgr->findByCode($req_dep_code);
			if (!empty ($depot_exist)) {
				$errors = array ("depot_code_exist" => "Kode depot '".$req_dep_code ."' sudah ada. Silahkan pilih yang lain");
				$tpl_engine->assign("errors", $errors);
			} else {
				$dep_mgr->create($_vo);
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
		$depot_id = $_POST["depot_id"];
	    $tpl_engine = TemplateEngine::getEngine();
	    //$tpl_engine->caching = IS_CACHING;
	    //$tpl_engine->debugging = IS_DEBUG;
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new Depot();
			$_vo->setDepotCode($_POST["depot_code"]);
			$_vo->setDepotName($_POST["depot_name"]);
			$_vo->setDepotAddress($_POST["depot_address"]);
			$_vo->setDepotId($depot_id);

			$dep_mgr = new DepotManager();
			$dep_mgr->update($_vo);
			
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
		$depot_id = $_REQUEST["depot_id"];
		$tpl_engine = TemplateEngine::getEngine();
	    //$tpl_engine->caching = IS_CACHING;
	    //$tpl_engine->debugging = IS_DEBUG;

		$dep_mgr = new DepotManager();
		$dep_mgr->delete($depot_id);

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}
function deleteAll() {
	try {

	    $tpl_engine = TemplateEngine::getEngine();
	    //$tpl_engine->caching = IS_CACHING;
	    //$tpl_engine->debugging = IS_DEBUG;

		$dep_mgr = new DepotManager();
		$dep_mgr->deleteAll();

		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}
function findAll($tpl_engine = NULL) {
	$pageNumber = @$_REQUEST['page'];
	$dep_mgr = new DepotManager();
	$totalData = (int) $dep_mgr->countAll();
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
	$result = $dep_mgr->findAll($pageIndex, $itemsPerPage);
	if (isset ($tpl_engine)) {
		$tpl_engine->assign("paginatedDepotList", $PaginateIt->GetPageLinks());
	}
	
	
	return $result;

}
function validate() {
	$result = array ();
	
    if (empty ($_POST["depot_code"])) {
		$result = array ("depot_code" => "Silahkan isi kode Depot");
	}
	else if (empty ($_POST["depot_name"])) {
		$result = array ("depot_name" => "Silahkan isi nama Depot");
	}
    else if (empty ($_POST["depot_address"])) {
		$result = array ("depot_address" => "Silahkan isi Alamat Depot");
	}

	return $result;
}


?>