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


require_once 'classes/StationManager.class.php';
require_once 'classes/UserManager.class.php';
require_once 'vo/Station.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/ControllerUtils.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'classes/PaginateIt.class.php';
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
	 if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::POWER_USER) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk merubah data SPBU"));
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

		
		if ($method_type == 'update') {
			update();
		}

		if ($method_type == 'edit') {
			edit();
		}
	    if ($method_type == 'delete') {
			delete();
		}
	    if ($method_type == 'create') {
			create();
		}
	    if ($method_type == 'activateStation') {
			activateStation();
		}
	    if ($method_type == 'passivateStation') {
			passivateStation();
		}
	}
}

function edit() {
	try {
		$station_id = $_REQUEST["station_id"];
		$tpl_engine = TemplateEngine::getEngine();


	    $usr_mgr = new UserManager();
		$st_mgr = new StationManager();
		$vo = $st_mgr->findByPrimaryKey($station_id);
		$user_role = $usr_mgr->findByUserRole(UserRoleEnum::GAS_STATION_OWNER, $station_id);
		
		if ($user_role) {
			$tpl_engine->assign("user_role", $user_role);
			
		}
		$tpl_engine->assign("gas_station", $vo);
		
		$gas_station_list = _findAll($tpl_engine);
		$tpl_engine->assign("gas_station_list", $gas_station_list);
		$tpl_engine->display('station_management.tpl');	
		

	} catch (Exception $e) {
		die($e);
	}
}

function delete() {
	try {
		$station_id = $_REQUEST["station_id"];
		$tpl_engine = TemplateEngine::getEngine();

	    
		$st_mgr = new StationManager();
		$st_mgr->delete($station_id);
		
		$gas_station_list = _findAll($tpl_engine);
		$tpl_engine->assign("gas_station_list", $gas_station_list);
		if ($gas_station_list == NULL || sizeof($gas_station_list) == 0) {
				$tpl_engine->assign("errors", array ("station_id" => "Belum ada SPBU yang terdaftar!"));
		}
		$tpl_engine->display('station_management.tpl');	
		

	} catch (Exception $e) {
		die($e);
	}
}
function prepare() {

	$tpl_engine = TemplateEngine::getEngine();


	$gas_station_list = _findAll($tpl_engine);
	$tpl_engine->assign("gas_station_list", $gas_station_list);
	if ($gas_station_list == NULL || sizeof($gas_station_list) == 0) {
			$tpl_engine->assign("errors", array ("station_id" => "Belum ada SPBU yang terdaftar!"));
	}
	
	$tpl_engine->display('station_management.tpl');

}


function update() {
	try {
		$station_id = $_POST["station_id"];
		$original_station_id = $_POST["original_station_id"];
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate(true);
		if (empty ($errors)) {
			$st_mgr = new StationManager();
			$usr_mgr = new UserManager();
			
			if ($station_id != $original_station_id) {
			   $gas_station = $st_mgr->findByPrimaryKey($station_id);
				
			   if (!empty ($gas_station)) {
				   $errors = array ("station_id" => "No SPBU '".$station_id."' sudah terpakai. Silahkan pilih yang lain.");
			   }	
			}
		    
			
			
			$_vo = new Station();
			$_vo->setLocationCode($_POST["location_code"]);
			$_vo->setStationAddress($_POST['station_address']);
            $_vo->setStationId($station_id);
			$_vo->setSupplyPointDistance($_POST["supply_point_distance"]);
			$_vo->setMaxTolerance($_POST["max_tolerance"]);
			
			$st_mgr->update($_vo, $original_station_id);
		
			$user_role = $usr_mgr->findByUserRole(UserRoleEnum::GAS_STATION_OWNER, $station_id);
			
			
			if ($user_role) {
				$user_name_req = $user_role->getUsername();
				
				$user_role->setUsername($user_name_req);
				$user_role->setUserRole(UserRoleEnum::GAS_STATION_OWNER);
				$user_role->setFirstName($_POST["first_name"]);
				$user_role->setLastName($_POST["last_name"]);
				$user_role->setEmailAddress($_POST["email_address"]);

				$usr_mgr->update($user_role);
				$usr_mgr->activateAccount($user_role->getUserId(), $station_id);
			}
		
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$gas_station_list = _findAll($tpl_engine);
		$tpl_engine->assign("gas_station_list", $gas_station_list);
		$tpl_engine->display('station_management.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function activateStation() {
	try {
		$station_id = $_REQUEST["station_id"];
		$tpl_engine = TemplateEngine::getEngine();

		if (empty ($station_id)) {
			$errors = array ("station_id" => "Silahkan isi Station id dengan benar");
		}
		if (empty ($errors)) {
			$st_mgr = new StationManager();
			$usr_mgr = new UserManager();
			$st_mgr->activateStation($station_id);
			$user_list = $usr_mgr->findAll(NULL, NULL, $station_id);
			foreach ($user_list as $key => $value) {

				if (!empty($value)) {
					$usr_mgr->activateAccount($value->getUserId(), $station_id);
				}
			}
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$gas_station_list = _findAll($tpl_engine);
		$tpl_engine->assign("gas_station_list", $gas_station_list);
		$tpl_engine->display('station_management.tpl');

	} catch (Exception $e) {
		die($e);
	}
}
function passivateStation() {
    try {
		$station_id = $_REQUEST["station_id"];
		$tpl_engine = TemplateEngine::getEngine();

       if (empty ($station_id)) {
			$errors = array ("station_id" => "Silahkan isi Station id dengan benar");
		}
		if (empty ($errors)) {
			$st_mgr = new StationManager();
			$usr_mgr = new UserManager();
			$st_mgr->passivateStation($station_id);
			$user_list = $usr_mgr->findAll(NULL, NULL, $station_id);
			foreach ($user_list as $key => $value) {

				if (!empty($value)) {
					$usr_mgr->passivateAccount($value->getUserId(), $station_id);
				}
			}
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$gas_station_list = _findAll($tpl_engine);
		$tpl_engine->assign("gas_station_list", $gas_station_list);
		$tpl_engine->display('station_management.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function create() {
	try {
		$station_id = $_POST["station_id"];
		$user_name_req = $_POST['user_name'];
		$user_password_req = $_POST['user_password'];
			
		$location_code_req = $_POST["location_code"];
			
		$tpl_engine = TemplateEngine::getEngine();

		$errors = validate(false);
		if (empty ($errors)) {
			$st_mgr = new StationManager();
			$usr_mgr = new UserManager();
			$dist_mgr = new DistributionLocationManager();
			
		    $dist_loc = $dist_mgr->findByCode($location_code_req);
			$user_exist = $usr_mgr->findByUserName($user_name_req, NULL, NULL);
			$gas_station = $st_mgr->findByPrimaryKey($station_id);
				
			if (!empty ($gas_station)) {
				$errors = array ("station_id" => "No SPBU '".$station_id."' sudah terpakai. Silahkan pilih yang lain.");
			}
			else if (!empty ($user_exist)) {
				$errors = array_merge($errors, array ("user_name" => "Login user '".$user_name_req."' sudah terpakai. Silahkan pilih login yang lain."));

			} else if (empty($dist_loc)) {
				$errors = array_merge($errors, array ("dist_loc" => "Wilayah penyaluran '".$location_code_req."' tidak dikenal."));
			}
			if ($errors != NULL && sizeof($errors) > 0) {
				
				$tpl_engine->assign("errors", $errors);
				$gas_station_list = _findAll($tpl_engine);
		        $tpl_engine->assign("gas_station_list", $gas_station_list);
		        $tpl_engine->display('station_management.tpl');
		        
			} else {
				$_vo = new Station();
				$_vo->setLocationCode($_POST["location_code"]);
				$_vo->setStationAddress($_POST['station_address']);
				$_vo->setStationId($station_id);
				$_vo->setSupplyPointDistance($_POST["supply_point_distance"]);
				$_vo->setMaxTolerance($_POST["max_tolerance"]);
				$st_mgr->create($_vo);
				$st_mgr->activateStation($station_id);
				
					
				$user_role = new UserRole();
				$user_role->setUsername($user_name_req);
				$user_role->setUserPassword($user_password_req);
				$user_role->setUserRole(UserRoleEnum::GAS_STATION_OWNER);
				$user_role->setFirstName($_POST["first_name"]);
				$user_role->setLastName($_POST["last_name"]);

				$user_role->setEmailAddress($_POST["email_address"]);
				$user_role->setStationId($station_id);
				$user_role->setAccountActivated("true");
					
				$usr_mgr->create($user_role);
			}
		
		} else {
			$tpl_engine->assign("errors", $errors);
		}

		$gas_station_list = _findAll($tpl_engine);
		$tpl_engine->assign("gas_station_list", $gas_station_list);
		$tpl_engine->display('station_management.tpl');

	} catch (Exception $e) {
		die($e);
	}
}

function _findAll($tpl_engine = NULL) {
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
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("paginatedGasStationList", $PaginateIt->GetPageLinks());
	}
	$dist_locations =  ControllerUtils::findAllDistLocation();
	$tpl_engine->assign("dist_locations", $dist_locations);
	
	return $result;
}
function validate($is_update=false) {
	$result = array ();
    if (empty ($_POST["station_id"])) {
		$result = array ("station_id" => "Silahkan isi No SPBU dengan benar");
	}else if (strlen($_POST["station_id"]) > 50) {
		$result = array ("station_id" => "No SPBU tidak boleh lebih dari 50 karakter");
	}
	if (empty ($_POST["location_code"])) {
		$result = array ("location_code" => "Silahkan pilih kode wilayah penyaluran");
	}
	if (empty ($_POST["station_address"])) {
		$result = array ("station_address" => "Silahkan isi alamat SPBU");
	}
   if (empty ($_POST["supply_point_distance"])) {
		$result = array ("supply_point_distance" => "Silahkan isi jarak ke supply point");
	}
	else if (!is_numeric($_POST["supply_point_distance"])) {
		$result = array ("supply_point_distance" => "Jarak ke supply point tidak valid");
	}
    if (empty ($_POST["max_tolerance"])) {
		$result = array ("max_tolerance" => "Silahkan isi maksimum toleransi");
	}
	else if (!is_numeric($_POST["max_tolerance"])) {
		$result = array ("supply_point_distance" => "Maksimum toleransi tidak valid");
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

	}
	if (!$is_update) {
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
	}
	return $result;
}
?>