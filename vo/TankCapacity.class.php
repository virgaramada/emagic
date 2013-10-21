<?php
class TankCapacity{
	private $cap_id = NULL;
	private $inv_type = '';
	private $tank_capacity = 0.00;
	private $station_id = NULL;

	public function __construct() {
	}

	public final function getId() {
		return (int) $this->cap_id;
	}
	public final function setId($cap_id) {
		$this->cap_id = (int) $cap_id;
	}
	public final function getInvType() {
		return (string) $this->inv_type;
	}
	public final function setInvType($inv_type) {
		$this->inv_type = (string) $inv_type;
	}

	public final function getTankCapacity() {
		return (double) $this->tank_capacity;
	}
	public final function setTankCapacity($tank_capacity) {
		$this->tank_capacity = (double) $tank_capacity;
	}

	public final function setStationId($station_id) {
		$this->station_id = (string) $station_id;
	}
	public final function getStationId() {
		return (string) $this->station_id;
	}
}
?>