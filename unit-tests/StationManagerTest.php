<?php
include 'classes/StationManager.class.php';
require_once 'vo/Station.class.php';

$mgr = new StationManager();

$mgr->delete("34.12345");
$mgr->delete("31.67890");

// create station
$vo = new Station();
$vo->setStationId("34.12345");
$vo->setStationAddress("JL Sudirman");
$vo->setLocationCode("JKT");
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
$id2 = $mgr->create($vo2);


$st2 = $mgr->findByPrimaryKey("31.67890");
if ($st2 instanceof Station) {
	echo ("test StationManager.create and StationManager.findByPrimaryKey success<br/>");
} else {
	die ("test StationManager.create and StationManager.findByPrimaryKey failed!\n");
}
echo("Station id: ". $st2->getStationId()."<br/>" );

?>