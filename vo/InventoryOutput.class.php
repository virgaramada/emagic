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
class InventoryOutput {

	private $inv_id = NULL;
	private $inv_type = '';
	private $customer_type = '';
	private $output_value = 0.00;
	private $output_date = NULL;
	private $output_time = NULL;
	private $unit_price = 0.00;
	private $category = '';
	private $own_use = NULL;
	private $begin_stand_meter = 0.00;
	private $end_stand_meter = 0.00;
	private $vehicle_type = '';
	private $tera_value = 0.00;
	private $pump_id = '';
	private $nosel_id = '';
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

	public final function getCustomerType() {
		return (string) $this->customer_type;
	}
	public final function setCustomerType($customer_type) {
		$this->customer_type = (string) $customer_type;
	}
	public final function getOutputValue() {
		return (double) $this->output_value;
	}
	public final function setOutputValue($output_value) {
		$this->output_value = (double) $output_value;
	}

	public final function getOutputDate() {
		return (string) $this->output_date;
	}
	public final function setOutputDate($output_date) {
		$this->output_date = (string) $output_date;
	}
	public final function getUnitPrice() {
		return (double) $this->unit_price;
	}
	public final function setUnitPrice($unit_price) {
		$this->unit_price = (double) $unit_price;
	}
	public final function getCategory() {
		return (string) $this->category;
	}
	public final function setCategory($category) {
		$this->category = (string) $category;
	}

	public final function getOwnUse() {
		return (string) $this->$own_use;
	}
	public final function setOwnUse($own_use) {
		$this->own_use = (string) $own_use;
	}

	public final function getBeginStandMeter() {
		return (double) $this->begin_stand_meter;
	}
	public final function setBeginStandMeter($begin_stand_meter) {
		$this->begin_stand_meter = (double) $begin_stand_meter;
	}

	public final function getEndStandMeter() {
		return (double) $this->end_stand_meter;
	}
	public final function setEndStandMeter($end_stand_meter) {
		$this->end_stand_meter = (double) $end_stand_meter;
	}

	public final function getVehicleType() {
		return (string) $this->vehicle_type;
	}
	public final function setVehicleType($vehicle_type) {
		$this->vehicle_type = (string) $vehicle_type;
	}

	public final function getTeraValue() {
		return (double) $this->tera_value;
	}
	public final function setTeraValue($tera_value) {
		$this->tera_value = (double) $tera_value;
	}

	public final function getPumpId() {
		return (string) $this->pump_id;
	}
	public final function setPumpId($pump_id) {
		$this->pump_id = (string) $pump_id;
	}

	public final function getNoselId() {
		return (string) $this->nosel_id;
	}
	public final function setNoselId($nosel_id) {
		$this->nosel_id = (string) $nosel_id;
	}
	public final function getOutputTime() {
		return (string) $this->output_time;
	}
	public final function setOutputTime($output_time) {
		$this->output_time = (string) $output_time;
	}
	public final function setStationId($station_id) {
		$this->station_id = (string) $station_id;
	}
	public final function getStationId() {
		return (string) $this->station_id;
	}
	public final function toString() {
		$buffer = 'InventoryOutput[inv_id='.$this->inv_id
		.', inv_type='.$this->inv_type
		.', output_value='.$this->output_value
		.', output_date='.$this->output_date
		.', customer_type='.$this->customer_type
		.', begin_stand_meter='.$this->begin_stand_meter
		.', end_stand_meter='.$this->end_stand_meter
		.', vehicle_type='.$this->vehicle_type
		.', tera_value='.$this->tera_value
		.', pump_id='.$this->pump_id
		.', nosel_id='.$this->nosel_id
		.', output_time='.$this->output_time
		.', own_use='.$this->own_use
		.', unit_price='.$this->unit_price.']';
		return $buffer;
	}
}
?>