<?php
require_once 'classes/DBManager.class.php';
require_once 'classes/UserManager.class.php';
require_once 'vo/UserRole.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/DistributionLocationManager.class.php';
require_once 'vo/DistributionLocation.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'classes/Constants.class.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>E-magic - Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<style type="text/css">
@import url( ../css/styles.css );
</style>
</head>
<body>
<div>Selamat Datang di Instalasi aplikasi E-magic.</div>
<br />

<div>1. Membuat struktur database dan index... 
<?php
$conn = DBManager :: get_connection();

if (!$conn) {
	die("Can not connect to MySQL. Please Install, and Run it before running this Installation.");
} else {
	/**
	$filename = '../sql/create-all.sql';

	if (!file_exists($filename)) {
		die("Can not find SQL Script file $filename");
	} else {
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		$queries = split(";", $contents);

		for ($ii = 0; $ii < sizeof($queries); $ii++) {
			if (!empty($queries[$ii])) {
				
				mysql_query($queries[$ii]) or die("SQL query failed : ".mysql_error()."<br/>");
			}
		}

		mysql_close($conn);
		echo("<span class=\"green_alert\">OK</span>");
	}
*/
}

?></div>

<br />

<!--  <div>2. Membuat wilayah penyaluran... --> 
<?php

if ($conn) {
	$dlm = new DistributionLocationManager();

	// loc 1
	$vi = new DistributionLocation();
	$vi->setLocationCode("JKT");
	$vi->setLocationName("DKI Jakarta");
	$vi->setSupplyPoint("Plumpang");
	$vi->setSalesAreaManager("Santanu");
	$dlm_id = $dlm->create($vi);

	// loc 2
	$vi2 = new DistributionLocation();
	$vi2->setLocationCode("BGR");
	$vi2->setLocationName("Bogor");
	$vi2->setSupplyPoint("Bogor");
	$vi2->setSalesAreaManager("Santanu");
	$dlm_id2 = $dlm->create($vi2);

	// loc 3
	$vi3 = new DistributionLocation();
	$vi3->setLocationCode("DPK");
	$vi3->setLocationName("Depok");
	$vi3->setSupplyPoint("Depok");
	$vi3->setSalesAreaManager("Santanu");
	$dlm_id3 = $dlm->create($vi3);

	$vi4 = new DistributionLocation();
	$vi4->setLocationCode("TGR");
	$vi4->setLocationName("Tangerang");
	$vi4->setSupplyPoint("Tangerang");
	$vi4->setSalesAreaManager("Santanu");
	$dlm_id4 = $dlm->create($vi4);

	$vi5 = new DistributionLocation();
	$vi5->setLocationCode("BKS");
	$vi5->setLocationName("Bekasi");
	$vi5->setSupplyPoint("Bekasi");
	$vi5->setSalesAreaManager("Santanu");
	$dlm_id5 = $dlm->create($vi5);


	echo("<span class=\"green_alert\">OK</span>");
} 

?>
<!--  </div> -->
<br />
<div>3. Membuat user 'Pertamina'... 
<?php
if ($conn) {
	$user_mgr = new UserManager();

	// create user for PERTAMINA
	$vo = new UserRole();
	$vo->setUserName("pertamina");
	$vo->setUserPassword("pertamina");
	$vo->setUserRole(UserRoleEnum::PERTAMINA);
	$vo->setFirstName("Pertamina");
	$vo->setLastName("UPMS III");
	$vo->setEmailAddress("pertamina@pertamina.com");

	$user_id = $user_mgr->create($vo);
	
}
?></div>

<div>4. Membuat user 'BPH Migas'... 
<?php
if ($conn) {
	$user_mgr = new UserManager();

	// create user for BPH Migas
	$vo = new UserRole();
	$vo->setUserName("bphmigas");
	$vo->setUserPassword("bphmigas");
	$vo->setUserRole(UserRoleEnum::BPH_MIGAS);
	$vo->setFirstName("BPH");
	$vo->setLastName("Migas");
	$vo->setEmailAddress("bphmigas@bphmigas.go.id");

	$user_id = $user_mgr->create($vo);

	echo("<span class=\"green_alert\">OK</span>");
}
?></div>

<div>5. Membuat user 'Depot'... 
<?php
if ($conn) {
	$user_mgr = new UserManager();

	// create user for Depot
	$vo = new UserRole();
	$vo->setUserName("depotplumpang");
	$vo->setUserPassword("depotplumpang");
	$vo->setUserRole(UserRoleEnum::DEPOT);
	$vo->setFirstName("Depot");
	$vo->setLastName("Plumpang");
	$vo->setEmailAddress("depotplumpang@pertamina.com");

	$user_id = $user_mgr->create($vo);

	echo("<span class=\"green_alert\">OK</span>");
}
?></div>
<div>6. Membuat user 'Superuser'... 
<?php
if ($conn) {
	$user_mgr = new UserManager();
	
	// create superuser account
	$vo2 = new UserRole();
	$vo2->setUserName("superuser");
	$vo2->setUserPassword("m4st3ry0d4");
	$vo2->setUserRole(UserRoleEnum::SUPERUSER);
	$vo2->setFirstName("Super");
	$vo2->setLastName("User");
	$vo2->setEmailAddress("vigong@free.fr");

	$user_id2 = $user_mgr->create($vo2);

	echo("<span class=\"green_alert\">OK</span>");
}
?></div>

<div>7. Membuat user 'Power User'... 
<?php
if ($conn) {
	$user_mgr = new UserManager();
	
	// create superuser account
	$vo2 = new UserRole();
	$vo2->setUserName("nathani");
	$vo2->setUserPassword("nathani");
	$vo2->setUserRole(UserRoleEnum::POWER_USER);
	$vo2->setFirstName("Nathani");
	$vo2->setLastName("Prima Sejahtera");
	$vo2->setEmailAddress("virgarb@yahoo.com");

	$user_id2 = $user_mgr->create($vo2);

	echo("<span class=\"green_alert\">OK</span>");
}
?></div>
<br />
<div>8. Selesai</div>
<br />
</body>
</html>
