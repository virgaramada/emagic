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
require_once 'classes/DistributionLocationManager.class.php';
require_once 'vo/UserRole.class.php';
require_once 'classes/StationManager.class.php';
require_once 'vo/Station.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/PaginateIt.class.php';
require_once 'utils/Validate.php';

//define("IS_DEBUG", false);
//define("IS_CACHING", false);

/**
if (empty ($_REQUEST['PHPSESSID'])) {
	$tpl_engine = TemplateEngine::getEngine();
	$tpl_engine->caching = IS_CACHING;
	$tpl_engine->debugging = IS_DEBUG;
	$tpl_engine->assign("errors", array ("session_expired" => "Anda harus login terlebih dahulu"));
	$tpl_engine->display('login.tpl');

} else {
	session_id($_REQUEST['PHPSESSID']);
	session_start();
	validateSession();
}

function validateSession() {
	  
	  if (empty ($_SESSION['user_role'])) {

		$tpl_engine = TemplateEngine::getEngine();
	    $tpl_engine->caching = IS_CACHING;
	    $tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');

	}else if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::POWER_USER) {
		$tpl_engine = TemplateEngine::getEngine();
	    $tpl_engine->caching = IS_CACHING;
	    $tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk aktivasi account"));
		$tpl_engine->display('login.tpl');

	}
	else {
		activate();
	}
}
*/
activate();


function activate() {
    $tpl_engine = TemplateEngine::getEngine();
	//$tpl_engine->caching = IS_CACHING;
	//$tpl_engine->debugging = IS_DEBUG;
	
	$station_id = $_REQUEST['station_id'];
	$user_id = $_REQUEST['user_id'];
    if (empty($station_id)) {
		$tpl_engine->assign("errors", array ("station_id" => "Silahkan isi No SPBU"));
	}
	
	$st_mgr = new StationManager();
	$user_mgt = new UserManager();
	$dist_mgr = new DistributionLocationManager();
	
	$gas_station = $st_mgr->findByPrimaryKey($station_id);
	if (empty($gas_station)) {
		$tpl_engine->assign("errors", array ("station_id" => "No SPBU (" .$station_id. ") tidak dikenal"));
	}
	if (!empty($user_id)) {
		$user = $user_mgt->findByPrimaryKey($user_id);
		if (empty($user)) {
			$tpl_engine->assign("errors", array ("user_id" => "User id tidak dikenal"));
		} else {
			$user_mgt->activateAccount($user_id, $station_id);
			$st_mgr->activateStation($station_id);
			$userAccount = $user_mgt->findByPrimaryKey($user_id);
			$dist_loc = $dist_mgr->findByCode($gas_station->getLocationCode());
			
			$tpl_engine->assign("messages", array ("account_activated" => "SPBU " .$station_id." telah diaktifkan."));
			$tpl_engine->assign("gas_station", $gas_station);
			$tpl_engine->assign("dist_loc", $dist_loc);
			$tpl_engine->assign("userAccount", $userAccount);
			// send email
				$to      = $user_mgt->getPowerUserEmail();
				$subject = 'Permohonan registrasi SPBU disetujui';
				$message = $tpl_engine->fetch('station_activation_email.tpl');
				$headers = 'From: nathani.primasejahtera@nathaniprimasejahtera.com' . "\r\n" .
                           'Reply-To: nathani.primasejahtera@nathaniprimasejahtera.com' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);
			
		}
	} else { // activate all users within the gas station
		   $user_list = $user_mgt->findAll(NULL, NULL, $station_id);
	       foreach ($user_list as $key => $value) {
				
				if (!empty($value)) {
					$user_mgt->activateAccount($value->getUserId(), $station_id);
				}
			}
	}

	$tpl_engine->display('station_activated.tpl');

}


?>
