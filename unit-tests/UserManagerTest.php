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
include 'classes/UserManager.class.php';
require_once 'vo/UserRole.class.php';
include 'classes/StationManager.class.php';
require_once 'vo/Station.class.php';

$mgr = new StationManager();
$user_mgr = new UserManager();

$mgr->delete("34.12345");
$user_mgr->deleteAll("34.12345");

$mgr->delete("31.67890");
$user_mgr->deleteAll("31.67890");

// create station
$vo = new Station();
$vo->setStationId("34.12345");
$vo->setStationAddress("JL Sudirman");
$vo->setLocationCode("JKT");
$vo->setStationStatus("ACTIVE");
$vo->setSupplyPointDistance(100);
$vo->setMaxTolerance(30);
$id = $mgr->create($vo);

$st = $mgr->findByPrimaryKey("34.12345");
if ($st instanceof Station) {
	echo ("test StationManager.create and StationManager.findByPrimaryKey success<br/>");
} else {
	die ("test StationManager.create and StationManager.findByPrimaryKey failed!\n");
}
echo("Station id: ". $st->getStationId()."<br/>" );

// create station 2
$vo2 = new Station();
$vo2->setStationId("31.67890");
$vo2->setStationAddress("JL Tebet Raya");
$vo2->setLocationCode("JKT");
$vo2->setStationStatus("ACTIVE");
$vo2->setSupplyPointDistance(100);
$vo2->setMaxTolerance(30);
$id2 = $mgr->create($vo2);

// create user
$_vo = new UserRole();
$_vo->setUserName("admin");
$_vo->setUserPassword("admin");
$_vo->setUserRole("ADM");
$_vo->setFirstName("Virga");
$_vo->setLastName("Ramada");
$_vo->setStationId($id);
$_vo->setEmailAddress("vigong@free.fr");
$_vo->setAccountActivated("true");
$user_id = $user_mgr->create($_vo);

$rs = $user_mgr->findByPrimaryKey($user_id);
if (!empty ($rs)) {
	echo ("test UserManager.findByPrimaryKey success<br/>");
} else {
	die ("test UserManager.findByPrimaryKey failed!\n");
}

$rs = $user_mgr->findByUserName("admin", "admin", $id);
if (!empty($rs)) {
	echo ("test UserManager.findByUserName success<br/>");
} else {
	die ("test UserManager.findByUserName failed!\n");
}
echo ("User  : username=". $rs->getUsername().", stationId=".$rs->getStationId()."<br/>");


$rs = $user_mgr->findByUserRole("ADM", $id);
if (!empty($rs)) {
    echo ("test UserManager.findByUserRole success<br/>");
} else {
    die ("test UserManager.findByUserRole failed!\n");
}

// update user
$_vo->setUserName("spbu1admin");
$_vo->setUserId($user_id);
$user_mgr->update($_vo);

$rs = $user_mgr->findByUserName("spbu1admin", NULL, $id);
if (!$rs) {
	die ("test UserManager.update failed!\n");
} else {
	echo ("test UserManager.update success<br/>");
}
$us = $user_mgr->userLogin("spbu1admin", "admin", $id);

if ($us instanceof UserRole) {
	echo ("test UserManager.userLogin success<br/>");
} else {
	die ("test UserManager.userLogin failed!\n");
}
echo ("User  : username=". $us->getUsername().", stationId=".$us->getStationId()."<br/>");

// change passwd
$user_mgr->changePassword($user_id, "spbu1admin", "admin", "spbu1admin", $id);
$us = $user_mgr->userLogin("spbu1admin", "admin", $id);

if (empty($us)) {
	echo ("test UserManager.changePassword success<br/>");
} else {
	die ("test UserManager.changePassword failed!\n");
}

// create user 2
$_vo = new UserRole();
$_vo->setUserName("spbu2admin");
$_vo->setUserPassword("spbu2admin");
$_vo->setUserRole("ADM");
$_vo->setFirstName("Tukul");
$_vo->setLastName("Arwana");
$_vo->setStationId($id2);
$_vo->setEmailAddress("vigong@free.fr");
$_vo->setAccountActivated("true");
$user_id = $user_mgr->create($_vo);

?>



