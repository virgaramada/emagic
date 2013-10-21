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
class StationMonitor {

	private $station_id = NULL;
	private $station_address = NULL;
	private $inv_supply_value = 0.00;
	private $inv_output_value = 0.00;
	private $inv_price = 0.00;
	private $inv_stock_value = 0.00;
	private $capacity = 0.00;
	private $empty_tank = 0.00;
	private $inv_stock_percentage = 0.00;
	private $flag = NULL;


	public final function setStationId($station_id) {
		$this->station_id = (string) $station_id;

	}
	public final function getStationId() {
		return (string) $this->station_id;
	}

	public final function setStationAddress($station_address) {
		$this->station_address = (string) $station_address;

	}
	public final function getStationAddress() {
		return (string) $this->station_address;
	}
	public final function setInvSupplyValue($inv_supply_value) {
		$this->inv_supply_value = (double) $inv_supply_value;

	}
	public final function getInvSupplyValue() {
		return (double) $this->inv_supply_value;
	}

	public final function setInvOutputValue($inv_output_value) {
		$this->inv_output_value = (double) $inv_output_value;

	}
	public final function getInvOutputValue() {
		return (double) $this->inv_output_value;
	}

	public final function setInvPrice($inv_price) {
		$this->inv_price = (double) $inv_price;

	}
	public final function getInvPrice() {
		return (double) $this->inv_price;
	}
	public final function setInvStockValue($inv_stock_value) {
		$this->inv_stock_value = (double) $inv_stock_value;

	}
	public final function getInvStockValue() {
		return (double) $this->inv_stock_value;
	}

	public final function setCapacity($capacity) {
		$this->capacity = (double) $capacity;

	}
	public final function getCapacity() {
		return (double) $this->capacity;
	}

	public final function setEmptyTank($empty_tank) {
		$this->empty_tank = (double) $empty_tank;

	}
	public final function getEmptyTank() {
		return (double) $this->empty_tank;
	}

	public final function setInvStockPercentage($inv_stock_percentage) {
		$this->inv_stock_percentage = (double) $inv_stock_percentage;

	}
	public final function getInvStockPercentage() {
		return (double) $this->inv_stock_percentage;
	}

	public final function setFlag($flag) {
		$this->flag = (string) $flag;

	}
	public final function getFlag() {
		return (string) $this->flag;
	}
}
?>