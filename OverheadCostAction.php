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
require_once 'classes/OverheadCostManager.class.php';
require_once 'vo/OverheadCost.class.php';
//require_once 'libs/smarty-2.6.18/Smarty.class.php';
require_once 'classes/TemplateEngine.class.php';

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
	// LogManager :: LOG($_SESSION['user_role']);
	if (empty($_SESSION["station_id"])) {
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("station_id" => "SPBU tidak dikenal!"));
		$tpl_engine->display('login.tpl');
	} 
	else if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] == 'NO') {
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk menambah/merubah overhead cost"));
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
		$ovh_id = $_REQUEST["ovh_id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$ovh_mgr = new OverheadCostManager();
		$vo = $ovh_mgr->findByPrimaryKey($ovh_id);
		$tpl_engine->assign("overheadCost", $vo);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("overhead_cost_list", $result);
		$tpl_engine->display('ovh_cost.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function prepare() {
	$tpl_engine = TemplateEngine::getEngine();
	//$tpl_engine->caching = IS_CACHING;
	//$tpl_engine->debugging = IS_DEBUG;

	$result = findAll($tpl_engine);
	$tpl_engine->assign("overhead_cost_list", $result);
	$tpl_engine->display('ovh_cost.tpl');

}

function create() {

	try {
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new OverheadCost();
			$_vo->setOvhCode($_POST["ovh_code"]);
			$_vo->setOvhDesc($_POST["ovh_desc"]);
			$_vo->setOvhValue((double) $_POST["ovh_value"]);
			$_vo->setStationId($_SESSION["station_id"]);
			$ovh_day = $_POST["Date_Day"];
			if (strlen($ovh_day) == 1) {
				$ovh_day = '0'.$ovh_day;
			}
			$date_formatted = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Date_Month"], (int) $ovh_day, (int) $_POST["Date_Year"]));
			$_vo->setOvhDate($date_formatted);

			$ovh_mgr = new OverheadCostManager();

			$is_cust_exist = $ovh_mgr->findByOverheadCode($_POST["ovh_code"], $_SESSION["station_id"]);
			if (!empty ($is_cust_exist)) {
				$tpl_engine->assign("errors", array ("ovh_code" => "Kode biaya sudah ada dalam database, silahkan pilih yang lain"));
			} else {
				$ovh_mgr->create($_vo);
			}

		} else {
			$tpl_engine->assign("errors", $errors);
		}
		$result = findAll($tpl_engine);
		$tpl_engine->assign("overhead_cost_list", $result);
		$tpl_engine->display('ovh_cost.tpl');
	} catch (Exception $e) {
		die($e);
	}
}
function update() {
	try {
		$ovh_id = $_POST["ovh_id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$errors = validate();
		if (empty ($errors)) {
			$_vo = new OverheadCost();
			$_vo->setOvhCode($_POST["ovh_code"]);
			$_vo->setOvhDesc($_POST["ovh_desc"]);
			$_vo->setOvhValue((double) $_POST["ovh_value"]);
			$_vo->setOvhId($ovh_id);
			$ovh_day = $_POST["Date_Day"];
			if (strlen($ovh_day) == 1) {
				$ovh_day = '0'.$ovh_day;
			}
			$date_formatted = date("Y-m-d", mktime(0, 0, 0, (int) $_POST["Date_Month"], (int) $ovh_day, (int) $_POST["Date_Year"]));
			$_vo->setOvhDate($date_formatted);

			$ovh_mgr = new OverheadCostManager();
			$ovh_mgr->update($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$result = findAll($tpl_engine);
		$tpl_engine->assign("overhead_cost_list", $result);
		$tpl_engine->display('ovh_cost.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function delete() {
	try {
		$ovh_id = $_REQUEST["ovh_id"];
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$ovh_mgr = new OverheadCostManager();
		$ovh_mgr->delete($ovh_id);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("overhead_cost_list", $result);
		$tpl_engine->display('ovh_cost.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function deleteAll() {
	try {

		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;

		$ovh_mgr = new OverheadCostManager();
		$ovh_mgr->deleteAll($_SESSION["station_id"]);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("overhead_cost_list", $result);
		$tpl_engine->display('ovh_cost.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function findAll($tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];
	$ovh_mgr = new OverheadCostManager();
	$totalData = (int) $ovh_mgr->countAll($_SESSION["station_id"]);
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
	$result = $ovh_mgr->findAll(NULL, NULL, $pageIndex, $itemsPerPage, $_SESSION["station_id"]);
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("paginatedOvhCostList", $PaginateIt->GetPageLinks());
		$tpl_engine->assign("total_ovh", $ovh_mgr->findTotalOverheadCost(NULL, NULL, $_SESSION["station_id"]));
	}
	return $result;
}
function validate() {
	$result = array ();
	if (empty ($_POST["ovh_code"])) {
		$result = array ("ovh_code" => "Silahkan isi kode biaya dengan benar");
	}
	if (strlen($_POST["ovh_code"]) > 20) {
		$result = array ("ovh_code" => "Kode biaya max 20 karakter");
	}
	if (empty ($_POST["ovh_desc"])) {
		$result = array ("ovh_desc" => "Silahkan isi deskripsi biaya dengan benar");
	}
	if (strlen($_POST["ovh_desc"]) > 50) {
		$result = array ("ovh_desc" => "Deskripsi biaya max 50 karakter");
	}
	if (empty ($_POST["ovh_value"]) || is_nan($_POST["ovh_value"])) {
		$result = array ("ovh_value" => "Silahkan isi jumlah biaya dengan benar");
	} else if ((int)$_POST["ovh_value"] < 0) {
		$result = array ("ovh_value" => "Jumlah biaya tidak boleh kurang dari nol");
	}
	if (empty ($_POST["Date_Month"])) {
		$result = array ("Date_Month" => "Silahkan pilih bulan dengan benar");
	}
	if (empty ($_POST["Date_Year"])) {
		$result = array ("Date_Year" => "Silahkan pilih tahun dengan benar");
	}
	if (empty ($_POST["Date_Day"])) {
		$result = array ("Date_Day" => "Silahkan pilih tanggal dengan benar");
	}

	return $result;
}
?>