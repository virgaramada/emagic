<?php
require_once 'classes/InventoryOutputManager.class.php';
require_once 'vo/InventoryOutput.class.php';
require_once 'classes/StationManager.class.php';
$st_mgr = new StationManager();
$inv_mgr = new InventoryOutputManager();

$st = $st_mgr->findByPrimaryKey("34.12345");
$st2 = $st_mgr->findByPrimaryKey("31.67890");

$_vo = new InventoryOutput();
$_vo->setInvType("PRM");
$_vo->setOutputValue("2000");
$_vo->setOutputTime("10:50");
$_vo->setOutputDate(date("Y-m-d", mktime(0, 0, 0, 1, 15, 2010)));
$_vo->setCustomerType("PLG");
$_vo->setUnitPrice("4500");
$_vo->setCategory("SALES");
$_vo->setBeginStandMeter("10000");
$_vo->setEndStandMeter("12000");
$_vo->setVehicleType("MBL");
$_vo->setTeraValue("10");
$_vo->setPumpId("A");
$_vo->setNoselId("2");
$_vo->setStationId($st->getStationId());

$inv_mgr->create($_vo);
$out = $inv_mgr->findAll("BBM", NULL, NULL, $st->getStationId());

if (is_array($out) && !empty($out) ) {
	echo ("test InventoryOutputManager.create and InventoryOutputManager.findAll success<br/>");
} else {
	die ("test InventoryOutputManager.create and InventoryOutputManager.findAll failed!\n");
}
	
$_vo->setStationId($st2->getStationId());

$inv_mgr->create($_vo);
$out2 = $inv_mgr->findAll("BBM", NULL, NULL, $st2->getStationId());

if (is_array($out2) && !empty($out2) ) {
	echo ("test InventoryOutputManager.create and InventoryOutputManager.findAll success<br/>");
} else {
	die ("test InventoryOutputManager.create and InventoryOutputManager.findAll failed!\n");
}
?>