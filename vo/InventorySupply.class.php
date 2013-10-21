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
class InventorySupply {

	private $inv_id = NULL;

	private $inv_type = '';

	private $supply_value = NULL;

	private $supply_date = NULL;

	private $delivery_order_number = NULL;

	private $plate_number = '';
	private $niap_number = '';
	private $station_id = NULL;
	public function __construct() {

	}

	public final function getInvId() {
		return (int) $this->inv_id;
	}
	public final function setInvId($inv_id) {
		$this->inv_id = (int) $inv_id;
	}

	public final function getInvType() {
		return (string) $this->inv_type;
	}
	public final function setInvType($inv_type) {
		$this->inv_type = (string) $inv_type;
	}
	public final function getSupplyValue() {
		return (double) $this->supply_value;
	}
	public final function setSupplyValue($supply_value) {
		$this->supply_value = (double) $supply_value;
	}

	public final function getSupplyDate() {
		return (string) $this->supply_date;
	}
	public final function setSupplyDate($supply_date) {
		$this->supply_date = (string) $supply_date;
	}

	public final function getDeliveryOrderNumber() {
		return (string) $this->delivery_order_number;
	}
	public final function setDeliveryOrderNumber($delivery_order_number) {
		$this->delivery_order_number = (string) $delivery_order_number;
	}

	public final function getPlateNumber() {
		return (string) $this->plate_number;
	}
	public final function setPlateNumber($plate_number) {
		$this->plate_number = (string) $plate_number;
	}
	public final function getNiapNumber() {
		return (string) $this->niap_number;
	}
	public final function setNiapNumber($niap_number) {
		$this->niap_number = (string) $niap_number;
	}

	public final function setStationId($station_id) {
		$this->station_id = (string) $station_id;
	}
	public final function getStationId() {
		return (string) $this->station_id;
	}
	public final function toString() {
		$buffer = 'InventorySupply[inv_id='.$this->inv_id.', inv_type='.$this->inv_type
		.', supply_value='.$this->supply_value.', supply_date='
		.', plate_number='.$this->plate_number
		.', niap_number='.$this->niap_number
		.$this->supply_date.', delivery_order_number='.$this->delivery_order_number.']';
		return $buffer;
	}
}
?>