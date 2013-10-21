<?php
/*
 GISMO - Gas station Inventory System Management with ORM
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
require_once 'classes/UserRoleEnum.class.php';

$method_type = @ $_REQUEST['method'];
$dateFormatted = date("d/m/Y-H:i:s");

if (empty ($method_type)) {

	if (!empty ($_SESSION['user_role']) && !empty ($_SESSION['user_fn'])) {
		$tpl_engine = TemplateEngine::getEngine();

		$rs = new UserRole();
		$rs->setFirstName($_SESSION['user_fn']);
		$rs->setLastName($_SESSION['user_ln']);
		$rs->setUserRole($_SESSION['user_role']);
		$rs->setStationId($_SESSION['station_id']);
		$tpl_engine->assign("user_login", $rs);

		$urlRedirect = "LoginAction.php";
		switch ($rs->getUserRole()) {
			case UserRoleEnum::GAS_STATION_ADMINISTRATOR :
				$urlRedirect = "UserManagementAction.php?".strip_tags(SID);
				break;
			case UserRoleEnum::GAS_STATION_OWNER :
				$urlRedirect = "UserManagementAction.php?".strip_tags(SID);
				break;
			case UserRoleEnum::GAS_STATION_USER :
				$urlRedirect = "InventorySupplyAction.php?".strip_tags(SID);
				break;
			case UserRoleEnum::GAS_STATION_OPERATOR :
				$urlRedirect = "InventorySupplyAction.php?".strip_tags(SID);
				break;
			case UserRoleEnum::PERTAMINA :
				$urlRedirect = "StationMonitorAction.php?".strip_tags(SID);
				break;
			case UserRoleEnum::POWER_USER :
				$urlRedirect = "StationManagementAction.php?".strip_tags(SID);
				break;
			case UserRoleEnum::SUPERUSER :
				$urlRedirect = "StationManagementAction.php?".strip_tags(SID);
				break;
			case UserRoleEnum::DEPOT :
				$urlRedirect = "DeliveryPlanAction.php?".strip_tags(SID);
				break;
			case UserRoleEnum::BPH_MIGAS :
				$urlRedirect = "DepotMonitorAction.php?".strip_tags(SID);
				break;
			default :
				$urlRedirect = "LoginAction.php";
		}
	    if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "/StationActivationAction.php") ) {
					$urlRedirect =$_SERVER['HTTP_REFERER'];
		}

		LogManager :: LOG("User '".$_SESSION['user_id']. "' logged-in on ".$dateFormatted);
		header("Location: ".$urlRedirect);

	} else {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->display('login.tpl');
	}

} else {
	if ($method_type == 'logout') {
		logout();
	} else {
		$errors = validate();
		if (empty ($errors)) {
			$tpl_engine = TemplateEngine::getEngine();

			$user_mgr = new UserManager();
			$rs = $user_mgr->userLogin($_POST["user_name"], $_POST["user_password"]);

			if (empty ($rs)) {
				$errors = array ("user_name" => "ID user berikut kata sandi tidak dikenal.");
				$tpl_engine->assign("errors", $errors);
				$tpl_engine->display('login.tpl');
			} else {
				session_start();
				$_SESSION['user_role'] = $rs->getUserRole();
				$_SESSION['user_id'] = $rs->getUsername();
				$_SESSION['user_fn'] = $rs->getFirstName();
				$_SESSION['user_ln'] = $rs->getLastName();
				$_SESSION['station_id'] = $rs->getStationId();
				
				$tpl_engine->assign("user_login", $rs);
				$urlRedirect = "LoginAction.php";

				switch ($rs->getUserRole()) {
					case UserRoleEnum::GAS_STATION_ADMINISTRATOR :
						$urlRedirect = "UserManagementAction.php?".strip_tags(SID);
						break;
					case UserRoleEnum::GAS_STATION_OWNER :
						$urlRedirect = "UserManagementAction.php?".strip_tags(SID);
						break;
					case UserRoleEnum::GAS_STATION_USER :
						$urlRedirect = "InventorySupplyAction.php?".strip_tags(SID);
						break;
					case UserRoleEnum::GAS_STATION_OPERATOR :
						$urlRedirect = "InventorySupplyAction.php?".strip_tags(SID);
						break;
					case UserRoleEnum::PERTAMINA :
						$urlRedirect = "StationMonitorAction.php?".strip_tags(SID);
						break;
					case UserRoleEnum::POWER_USER :
						$urlRedirect = "StationManagementAction.php?".strip_tags(SID);
						break;
					case UserRoleEnum::SUPERUSER :
						$urlRedirect = "StationManagementAction.php?".strip_tags(SID);
						break;	
					case UserRoleEnum::DEPOT :
						$urlRedirect = "DeliveryPlanAction.php?".strip_tags(SID);
						break;
					case UserRoleEnum::BPH_MIGAS :
						$urlRedirect = "DepotMonitorAction.php?".strip_tags(SID);
						break;

					default :
						$urlRedirect = "LoginAction.php";
				}
			     if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "/StationActivationAction.php") ) {
					$urlRedirect =$_SERVER['HTTP_REFERER'];
		         }
				LogManager :: LOG("User '".$_SESSION['user_id']. "' logged-in on ".$dateFormatted);
				header("Location: ".$urlRedirect);
			}

		} else {
			$tpl_engine = TemplateEngine::getEngine();
			$tpl_engine->assign("errors", $errors);
			$tpl_engine->display('login.tpl');
		}
	}
}
function logout() {
	$tpl_engine = TemplateEngine::getEngine();

	if (isset ($_REQUEST['PHPSESSID'])) {
		session_id($_REQUEST['PHPSESSID']);
		if (isset($_SESSION['user_id'])) {	
		 LogManager :: LOG("User '".$_SESSION['user_id']. "' logged out on ".date("d/m/Y-H:i:s"));
		}
		
	}
	session_start();
	session_unset();
	session_destroy();
	deleteLogFiles();

	$tpl_engine->display('login.tpl');
}
function validate() {
	$result = array ();
	if (empty ($_POST["user_name"])) {
		$result = array ("user_name" => "Silahkan isi ID user dengan benar");

	}
	if (empty ($_POST["user_password"])) {
		$result = array ("user_password" => "Silahkan isi kata sandi dengan benar");
	}

	return $result;
}

function deleteLogFiles() {
	foreach (glob("logs/sikopis_*.log") as $fn) {
		if (file_exists($fn)) {
			LogManager::gzipFile($fn,9, false);
			unlink($fn);
		}
	}
}

?>
