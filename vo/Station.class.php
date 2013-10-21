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

class Station {
private $unique_id = NULL;
	private $station_id = NULL;
	private $station_address = NULL;
	private $location_code=NULL;
	private $supply_point_distance = 0.00;
	private $max_tolerance = 0.00;
	private $station_status=NULL;

    public final function getUniqueId() {
		return (int) $this->unique_id;
	}
	public final function setUniqueId($unique_id) {
		$this->unique_id = (int) $unique_id;
	}
	
	public final function getLocationCode() {
		return (string) $this->location_code;
	}
	public final function setLocationCode($location_code) {
		$this->location_code = (string) $location_code;
	}
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
	
	public final function setSupplyPointDistance($supply_point_distance) {
		$this->supply_point_distance = (double) $supply_point_distance;
	}
	public final function getSupplyPointDistance() {
		return (double) $this->supply_point_distance;
	}
	
    public final function setMaxTolerance($max_tolerance) {
		$this->max_tolerance = (double) $max_tolerance;
	}
	public final function getMaxTolerance() {
		return (double) $this->max_tolerance;
	}

    public final function setStationStatus($station_status) {
		$this->station_status = (string) $station_status;

	}
	public final function getStationStatus() {
		return (string) $this->station_status;
	}
}
?>