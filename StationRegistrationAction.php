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
require_once 'vo/Station.class.php';
require_once 'classes/DistributionLocationManager.class.php';
require_once 'vo/DistributionLocation.class.php';


require_once 'classes/TemplateEngine.class.php';
require_once 'classes/ControllerUtils.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/UserRoleEnum.class.php';
//require_once 'classes/PaginateIt.class.php';
require_once 'classes/Constants.class.php';
require_once 'utils/Validate.php';


if (!empty ($_REQUEST['PHPSESSID'])) {
	session_id($_REQUEST['PHPSESSID']);
	session_start();
	
}
execute();

function execute() {
	$method_type = @ $_REQUEST["method"];

		if (empty ($method_type)) {
			prepare();
		}

		if ($method_type == 'create') {
			create();
		}

}

function prepare() {

	$tpl_engine = TemplateEngine::getEngine();


	$dist_locations =  ControllerUtils::findAllDistLocation();
	$tpl_engine->assign("dist_locations", $dist_locations);
	
	$tpl_engine->display('station_registration.tpl');

}

function create() {

	try {
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate();
		if (empty ($errors)) {
			$errors = array();
			
			$user_name_req = $_POST['user_name'];
			$user_password_req = $_POST['user_password'];
			$station_id_req = $_POST["station_id"];
			$location_code_req = $_POST["location_code"];
				
			$usr_mgr = new UserManager();
			$st_mgr =  new StationManager();
			$dist_mgr = new DistributionLocationManager();
				
			$dist_loc = $dist_mgr->findByCode($location_code_req);
			$user_exist = $usr_mgr->findByUserName($user_name_req, NULL, NULL);
			$gas_station = $st_mgr->findByPrimaryKey($station_id_req);
				
			if (!empty ($gas_station)) {
				$tpl_engine->clear_all_assign();
				$errors = array ("station_id" => "No SPBU '".$station_id_req."' sudah terpakai. Silahkan pilih yang lain.");
			}
			else if (!empty ($user_exist)) {
				$tpl_engine->clear_all_assign();
				$errors = array_merge($errors, array ("user_name" => "Login user '".$user_name_req."' sudah terpakai. Silahkan pilih login yang lain."));

			} else if (empty($dist_loc)) {
				$errors = array_merge($errors, array ("dist_loc" => "Wilayah penyaluran '".$location_code_req."' tidak dikenal."));
			}

			if ($errors != NULL && sizeof($errors) > 0) {
				$tpl_engine->assign("errors", $errors);
				$dist_locations =  ControllerUtils::findAllDistLocation();
				$tpl_engine->assign("dist_locations", $dist_locations);

			    $tpl_engine->display('station_registration.tpl');
			} else {

				
				// create gas station
				$station = new Station();
				$station->setLocationCode($location_code_req);
				$station->setStationAddress($_POST['station_address']);
				$station->setStationId($station_id_req);
				$station->setStationStatus("UNREGISTERED");

				$_vo = new UserRole();
				$_vo->setUsername($user_name_req);
				$_vo->setUserPassword($user_password_req);
				$_vo->setUserRole(UserRoleEnum::GAS_STATION_OWNER);
				$_vo->setFirstName($_POST["first_name"]);
				$_vo->setLastName($_POST["last_name"]);

				$_vo->setEmailAddress($_POST["email_address"]);
				$_vo->setStationId($station_id_req);
				$_vo->setAccountActivated("false");
					
				$usr_mgr->create($_vo);
				$st_mgr->create($station);

				$tpl_engine->assign("gas_station", $station);

				$userAccount = $usr_mgr->findByUserName($user_name_req, $user_password_req, $station_id_req);
				
			if (empty ($userAccount)) {
				$tpl_engine->clear_all_assign();
				$errors = array_merge($errors, array ("user_account" => "Akun untuk '".$user_name_req."' tidak dapat dibuat. Silahkan coba lagi."));
                $tpl_engine->assign("errors", $errors);
			    $dist_locations =  ControllerUtils::findAllDistLocation();
			    $tpl_engine->assign("dist_locations", $dist_locations);
			    $tpl_engine->display('station_registration.tpl');
			}
			
			    $tpl_engine->assign("user_name", $user_name_req);
			    $tpl_engine->assign("user_password", $user_password_req);
				$tpl_engine->assign("userAccount", $userAccount);
				$tpl_engine->assign("create_date", date("j M, Y H:i:s", mktime()));
				$tpl_engine->assign("dist_loc", $dist_loc);

				// send email
				$to      = $usr_mgr->getPowerUserEmail();
				$subject = 'Permohonan pendaftaran SPBU';
				$message = $tpl_engine->fetch('station_registration_email.tpl');
				$headers = 'From: nathani.primasejahtera@nathaniprimasejahtera.com' . "\r\n" .
                           'Reply-To: nathani.primasejahtera@nathaniprimasejahtera.com' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);

				$user_to      = $_POST["email_address"];
				$user_subject = 'Permohonan pendaftaran SPBU';
				$user_message = $tpl_engine->fetch('station_registration_request_email.tpl');
				$user_headers = 'From: nathani.primasejahtera@nathaniprimasejahtera.com' . "\r\n" .
                           'Reply-To: nathani.primasejahtera@nathaniprimasejahtera.com' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();
				mail($user_to, $user_subject, $user_message, $user_headers);

				$tpl_engine->display('station_registration_success.tpl');
			}

		} else {
			$tpl_engine->assign("errors", $errors);
			$dist_locations =  ControllerUtils::findAllDistLocation();
			$tpl_engine->assign("dist_locations", $dist_locations);
			$tpl_engine->display('station_registration.tpl');
				
		}

	} catch (Exception $e) {
		die($e);
	}
}

function validate() {
	$result = array ();
	if (empty ($_POST["station_id"])) {
		$result = array ("station_id" => "Silahkan isi No SPBU dengan benar");
	} else if (strlen($_POST["station_id"]) > 50) {
		$result = array ("station_id" => "No SPBU tidak boleh lebih dari 50 karakter");
	}
	if (empty ($_POST["location_code"])) {
		$result = array ("location_code" => "Silahkan pilih kode wilayah penyaluran");
	}
	if (empty ($_POST["station_address"])) {
		$result = array ("station_address" => "Silahkan isi alamat SPBU");
	}
	
	if (empty ($_POST["user_name"])) {
		$result = array ("user_name" => "Silahkan isi Login yang dipakai dengan benar");

	} else if (strlen($_POST["user_name"]) > 20) {
		$result = array ("user_name" => "Login yang dipakai tidak boleh lebih dari 20 karakter");
	}

	if (empty ($_POST["user_password"])) {
		$result = array ("user_password" => "Silahkan isi kata sandi dengan benar");

	} else if (strlen($_POST["user_password"]) < 6 || strlen($_POST["user_password"]) > 20) {
		$result = array ("user_password" => "Kata sandi harus terdiri dari 6 - 20 karakter");
	}

	if (empty ($_POST["first_name"])) {
		$result = array ("first_name" => "Silahkan isi nama depan dengan benar");

	} else if (!empty ($_POST["first_name"]) && strlen($_POST["first_name"]) > 30) {
		$result = array ("first_name" => "Nama depan tidak boleh lebih dari 30 karakter");
	}
	if (empty ($_POST["last_name"])) {
		$result = array ("last_name" => "Silahkan isi nama belakang dengan benar");

	}
	else if (!empty ($_POST["last_name"]) && strlen($_POST["last_name"]) > 30) {
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
