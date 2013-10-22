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
class DistributionLocation {


	private $location_code = NULL;
	private $location_name = NULL;
	private $supply_point = NULL;
	private $sales_area_manager = NULL;
	private $location_id = NULL;
	private $depot_code = NULL;
	public function __construct() {

	}
	public final function setLocationId($location_id) {
		$this->location_id = (int) $location_id;

	}
	public final function getLocationId() {
		return (int) $this->location_id;
	}
	public final function getLocationCode() {
		return (string) $this->location_code;
	}
	public final function setLocationCode($location_code) {
		$this->location_code = (string) $location_code;
	}

	public final function getLocationName() {
		return (string) $this->location_name;
	}
	public final function setLocationName($location_name) {
		$this->location_name = (string) $location_name;
	}
	public final function getSupplyPoint() {
		return (string) $this->supply_point;
	}
	public final function setSupplyPoint($supply_point) {
		$this->supply_point = (string) $supply_point;
	}

	public final function getSalesAreaManager() {
		return (string) $this->sales_area_manager;
	}
	public final function setSalesAreaManager($sales_area_manager) {
		$this->sales_area_manager = (string) $sales_area_manager;
	}
	
    public final function getDepotCode() {
		return (string) $this->depot_code;
	}
	public final function setDepotCode($depot_code) {
		$this->depot_code = (string) $depot_code;
	}
}
?>