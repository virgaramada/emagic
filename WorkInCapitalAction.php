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
require_once 'classes/WorkInCapitalManager.class.php';
require_once 'vo/WorkInCapital.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/LogManager.class.php';

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
		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk merubah modal kerja awal"));
		$tpl_engine->display('login.tpl');

	} else if (empty ($_SESSION['user_role'])) {

		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
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
		$id = $_REQUEST["id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$mgr = new WorkInCapitalManager();
		$vo = $mgr->findByPrimaryKey($id);
		$tpl_engine->assign("workInCapital", $vo);
		prepare($tpl_engine);

	} catch (Exception $e) {
		die($e);
	}
}
function prepare($tpl_engine = NULL) {
	if ($tpl_engine == NULL) {
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
	}

	$result = findAll();
	$tpl_engine->assign("wic_list", $result);
	$tpl_engine->display('work_in_capital.tpl');

}
function create() {
	try {
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new WorkInCapital();
			$_vo->setCode($_POST["c_code"]);
			$_vo->setValue($_POST["c_value"]);
			$_vo->setDesc($_POST["c_desc"]);
			$_vo->setStationId($_SESSION["station_id"]);

			$mgr = new WorkInCapitalManager();
			$wic_exist = $mgr->findByCode($_REQUEST["c_code"], $_SESSION["station_id"]);
			if (!empty ($wic_exist)) {
				$errors = array ("c_code" => "Modal kerja sudah ada dalam database.");
				$tpl_engine->assign("errors", $errors);
			} else {
				$mgr->create($_vo);
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
		$id = $_POST["id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new WorkInCapital();
			$_vo->setCode($_POST["c_code"]);
			$_vo->setValue($_POST["c_value"]);
			$_vo->setDesc($_POST["c_desc"]);
			$_vo->setId($id);

			$mgr = new WorkInCapitalManager();
			$mgr->update($_vo);
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
		$id = $_REQUEST["id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$mgr = new WorkInCapitalManager();
		$mgr->delete($id);
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

		$mgr = new WorkInCapitalManager();
		$mgr->deleteAll($_SESSION["station_id"]);

		prepare($tpl_engine);
	} catch (Exception $e) {
		die($e);
	}
}
function findAll() {
	$mgr = new WorkInCapitalManager();
	$result = $mgr->findAll($_SESSION["station_id"]);
	return $result;

}
function validate() {
	$result = array ();
	if (empty ($_REQUEST["c_code"])) {
		$result = array ("c_code" => "Silahkan isi kode modal kerja dengan benar");

	}
	if (empty ($_REQUEST["c_value"]) || !is_numeric($_REQUEST["c_value"])) {
		$result = array ("c_value" => "Silahkan isi jumlah modal kerja dengan benar");
	} else if ((int)$_REQUEST["c_value"] <= 0) {
		$result = array ("c_value" => "Jumlah modal kerja tidak boleh kurang dari/sama dengan nol");
	}

	return $result;
}
?>