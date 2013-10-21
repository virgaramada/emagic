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
require_once 'classes/UserManager.class.php';
require_once 'vo/UserRole.class.php';

require_once 'classes/TemplateEngine.class.php';
require_once 'classes/LogManager.class.php';

require_once 'classes/PaginateIt.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'utils/Validate.php';


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
	if (empty($_SESSION["station_id"])) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("station_id" => "SPBU tidak dikenal!"));
		$tpl_engine->display('login.tpl');
	}
	else if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_OWNER && $_SESSION['user_role'] != UserRoleEnum::GAS_STATION_ADMINISTRATOR) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk merubah/menambah user"));
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
		if ($method_type == 'edit') {
			edit();
		}
		if ($method_type == 'deleteAll') {
			deleteAll();
		}
	    if ($method_type == 'activateAccount') {
			activateAccount();
		}
	    if ($method_type == 'passivateAccount') {
			passivateAccount();
		}
		
	}
}

function edit() {
	try {
		$user_id = $_REQUEST["user_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$user_mgr = new UserManager();
		$vo = $user_mgr->findByPrimaryKey($user_id);
		if ( $vo != NULL) {
			$tpl_engine->assign("user", $vo);
		}
		$result = findAll($tpl_engine);
		$tpl_engine->assign("user_list", $result);
		$tpl_engine->display('user_mgt.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function prepare() {

	$tpl_engine = TemplateEngine::getEngine();

	$result = findAll($tpl_engine);
	
	
	$tpl_engine->assign("user_list", $result);
	$tpl_engine->display('user_mgt.tpl');

}

function create() {

	try {
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$_vo = new UserRole();
			$_vo->setUsername($_POST["user_name"]);
			$_vo->setUserPassword($_POST["user_password"]);
			$_vo->setUserRole($_POST["user_role"]);
			$_vo->setFirstName($_POST["first_name"]);
			$_vo->setLastName($_POST["last_name"]);
			$_vo->setEmailAddress($_POST["email_address"]);
			$_vo->setStationId($_SESSION["station_id"]);
			$_vo->setAccountActivated("true");

			$user_mgr = new UserManager();
			$user_exist = $user_mgr->findByUserName($_POST["user_name"],NULL, NULL);
			if (!empty ($user_exist)) {
				$errors = array ("user_name" => "Login user '".$_POST["user_name"]."' sudah terpakai. Silahkan pilih login yang lain.");
				$tpl_engine->assign("errors", $errors);
			} else {
				$user_mgr->create($_vo);
			}

		} else {
			$tpl_engine->assign("errors", $errors);
		}
		$result = findAll($tpl_engine);
		$tpl_engine->assign("user_list", $result);
		$tpl_engine->display('user_mgt.tpl');
	} catch (Exception $e) {
		die($e);
	}
}
function update() {
	try {
		$user_id = $_POST["user_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate(true);
		if (empty ($errors)) {
			$_vo = new UserRole();
			$_vo->setUsername($_POST["user_name"]);
			
			$_vo->setUserRole($_POST["user_role"]);
			$_vo->setFirstName($_POST["first_name"]);
			$_vo->setLastName($_POST["last_name"]);
			$_vo->setUserId($user_id);
			$_vo->setEmailAddress($_POST["email_address"]);

			$user_mgr = new UserManager();
			$user_mgr->update($_vo);
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$result = findAll($tpl_engine);
		$tpl_engine->assign("user_list", $result);
		$tpl_engine->display('user_mgt.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function activateAccount() {
	try {
		$user_id = $_REQUEST["user_id"];
		$tpl_engine = TemplateEngine::getEngine();

		if (empty ($user_id)) {
			$errors = array ("user_id" => "Silahkan isi User id dengan benar");
		}
		if (empty ($errors)) {
			

			$user_mgr = new UserManager();
			$user_mgr->activateAccount($user_id, $_SESSION["station_id"]);
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$result = findAll($tpl_engine);
		$tpl_engine->assign("user_list", $result);
		$tpl_engine->display('user_mgt.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function passivateAccount() {
    try {
		$user_id = $_REQUEST["user_id"];
		$tpl_engine = TemplateEngine::getEngine();

		if (empty ($user_id)) {
			$errors = array ("user_id" => "Silahkan isi User id dengan benar");
		}
		if (empty ($errors)) {
			

			$user_mgr = new UserManager();
			$user_mgr->passivateAccount($user_id, $_SESSION["station_id"]);
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$result = findAll($tpl_engine);
		$tpl_engine->assign("user_list", $result);
		$tpl_engine->display('user_mgt.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function delete() {
	try {
		$user_id = $_REQUEST["user_id"];
		$tpl_engine = TemplateEngine::getEngine();


		$user_mgr = new UserManager();
		$user_mgr->delete($user_id);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("user_list", $result);
		$tpl_engine->display('user_mgt.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function deleteAll() {
	try {
		$tpl_engine = TemplateEngine::getEngine();


		$user_mgr = new UserManager();
		$user_mgr->deleteAll($_SESSION["station_id"]);

		$result = findAll($tpl_engine);
		$tpl_engine->assign("user_list", $result);
		$tpl_engine->display('user_mgt.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function findAll($tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];
	$user_mgr = new UserManager();
	$totalData = (int) $user_mgr->countAllNoSuperuserAndOwner($_SESSION["station_id"]);

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
	$result = $user_mgr->findAllNoSuperuserAndOwner($pageIndex, $itemsPerPage, $_SESSION["station_id"]);
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("roles", UserRoleEnum::names());
		$tpl_engine->assign("active_roles", UserRoleEnum::allNames());
		$tpl_engine->assign("paginatedUserList", $PaginateIt->GetPageLinks());
	}
	return $result;
}
function validate($is_update=false) {
	$result = array ();
	if (empty ($_POST["user_role"])) {
		$result = array ("user_role" => "Silahkan isi Tipe user dengan benar");
	} else if (strlen($_POST["user_role"]) > 20) {
		$result = array ("user_role" => "Jenis User tidak boleh lebih dari 20 karakter");
	}
	if (empty ($_POST["user_name"])) {
		$result = array ("user_name" => "Silahkan isi Login yang dipakai dengan benar");

	} else if (strlen($_POST["user_name"]) > 20) {
		$result = array ("user_name" => "Login yang dipakai tidak boleh lebih dari 20 karakter");
	}
	if (!$is_update) {
		if (empty ($_POST["user_password"])) {
			$result = array ("user_password" => "Silahkan isi kata sandi dengan benar");

		} else if (strlen($_POST["user_password"]) < 6 || strlen($_POST["user_password"]) > 20) {
			$result = array ("user_password" => "Kata sandi harus terdiri dari 6 - 20 karakter");
		}
		if (empty ($_POST["user_password2"])) {
			$result = array ("user_password2" => "Silahkan isi verifikasi kata sandi dengan benar");

		} else if ($_POST["user_password2"] != $_POST["user_password"]) {
			$result = array ("user_password2" => "Verifikasi kata sandi tidak valid");
		}
	}

	if (empty ($_POST["first_name"])) {
		$result = array ("first_name" => "Silahkan isi nama depan dengan benar");

	} else if (strlen($_POST["first_name"]) > 30) {
		$result = array ("first_name" => "Nama depan tidak boleh lebih dari 30 karakter");
	}

	if (!empty ($_POST["last_name"]) && strlen($_POST["last_name"]) > 30) {
		$result = array ("last_name" => "Nama belakang tidak boleh lebih dari 30 karakter");
	}
	if (empty ($_POST["email_address"])) {
		$result = array ("email_address" => "Silahkan isi e-mail dengan benar");

	} else if (!Validate::email($_POST["email_address"])) {
		$result = array ("email_address" => "E-mail tidak valid");
	}
	return $result;
}
?>