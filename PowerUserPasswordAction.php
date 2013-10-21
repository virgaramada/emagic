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
require_once 'classes/StationManager.class.php';

require_once 'classes/TemplateEngine.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/UserRoleEnum.class.php';


$dateFormatted = date("d/m/Y-H:i:s");

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

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk merubah kata sandi"));
		$tpl_engine->display('login.tpl');

	} 
	else {
		if (empty ($method_type)) {
			prepare();
		}
		else if ($method_type == 'change') {
			change();
		}

	}
}

function prepare() {

	try {
		$user_id = $_REQUEST["user_id"];
		
		$tpl_engine = TemplateEngine::getEngine();


		$user_mgr = new UserManager();
		$vo = $user_mgr->findByPrimaryKey($user_id);
		if ($vo == NULL) {
			
			$tpl_engine = TemplateEngine::getEngine();

			$tpl_engine->clear_all_assign();
			$tpl_engine->assign("errors", array ("user_id" => "User tidak dikenal!"));
			$tpl_engine->display('login.tpl');

		} else {
			$tpl_engine->assign("user", $vo);
			$tpl_engine->display('change_password.tpl');
		}

	} catch (Exception $e) {
		die($e);
	}

}

function change() {

	try {
		$user_id = $_POST["user_id"];
		$user_name = $_POST["user_name"];
		
		$tpl_engine = TemplateEngine::getEngine();

	    	    
		$errors = validate();
		// TODO add captcha
		
		$user_mgr = new UserManager();
		if (empty ($errors)) {
			
			$user_mgr->changePassword($user_id, $user_name, $_POST["old_passwd"], $_POST["new_passwd"], NULL);

			// log it
			LogManager :: LOG("User '".$_SESSION['user_id']. "' has changed the password of user " .$user_name. " on ".$dateFormatted);

			$messages = array ("change_password" => "Kata sandi untuk user ".$user_name." telah berhasil diubah");
			$tpl_engine->assign("messages", $messages);
			$tpl_engine->display('change_password_success.tpl');

		} else {
				
			$vo = $user_mgr->findByPrimaryKey($user_id);
			if ($vo == NULL) {
				
				$tpl_engine = TemplateEngine::getEngine();

				$tpl_engine->clear_all_assign();
				$tpl_engine->assign("errors", array ("user_id" => "User tidak dikenal!"));
				$tpl_engine->display('login.tpl');

			} else {
				$tpl_engine->assign("user", $vo);
				$tpl_engine->assign("errors", $errors);
				$tpl_engine->display('change_password.tpl');
			}

				
		}
	} catch (Exception $e) {
		die($e);
	}
}

function validate() {
	$result = array ();

	if (empty ($_POST["old_passwd"])) {
		$result = array ("old_passwd" => "Silahkan isi kata sandi yang lama dengan benar");

	}
    
	if (empty ($_POST["new_passwd"])) {
		$result = array ("new_passwd" => "Silahkan isi kata sandi yang baru dengan benar");

	} else if (strlen($_POST["new_passwd"]) < 6 || strlen($_POST["new_passwd"]) > 20) {
		$result = array ("new_passwd" => "Kata sandi harus terdiri dari 6 - 20 karakter");
	}

	else if ($_POST["old_passwd"] == $_POST["new_passwd"]) {
		$result = array ("new_passwd" => "Kata sandi yang baru tidak boleh sama dengan yang lama");
	}

	return $result;
}
?>