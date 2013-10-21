<?php
require_once 'classes/StationManager.class.php';
require_once 'vo/InventoryType.class.php';
require_once 'vo/Station.class.php';
require_once 'classes/InventoryTypeManager.class.php';

$st_mgr = new StationManager();
$inv_mgr = new InventoryTypeManager();

$st = $st_mgr->findByPrimaryKey("34.12345");

if ($st instanceof Station) {
	echo ("test StationManager.findByPrimaryKey success<br/>");
} else {
	die ("test StationManager.findByPrimaryKey failed!\n");
}

$st2 = $st_mgr->findByPrimaryKey("31.67890");

if ($st2 instanceof Station) {
	echo ("test StationManager.findByPrimaryKey success<br/>");
} else {
	die ("test StationManager.findByPrimaryKey failed!\n");
}

$_vo = new InventoryType();
$_vo->setInvType("PRM");
$_vo->setInvDesc("Premium");
$_vo->setProductType("BBM");
$_vo->setStationId($st->getStationId());
	

$inv_mgr->create($_vo);

$inv_type = $inv_mgr->findByInventoryType("PRM", $st->getStationId());
if (is_array($inv_type) && !empty($inv_type)) {
	echo ("test InventoryTypeManager.create and InventoryTypeManager.findByInventoryType success<br/>");
} else {
	die ("test InventoryTypeManager.create and InventoryTypeManager.findByInventoryType failed!\n");
}

$_vo = new InventoryType();
$_vo->setInvType("PRM");
$_vo->setInvDesc("Premium");
$_vo->setProductType("BBM");
$_vo->setStationId($st2->getStationId());

$inv_mgr->create($_vo);

$inv_type2 = $inv_mgr->findByInventoryType("PRM", $st2->getStationId());
if (is_array($inv_type2) && !empty($inv_type2)) {
	echo ("test InventoryTypeManager.create and InventoryTypeManager.findByInventoryType success<br/>");
} else {
	die ("test InventoryTypeManager.create and InventoryTypeManager.findByInventoryType failed!\n");
}

?>