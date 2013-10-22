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
class OverheadCost {

	private $ovh_id = NULL;
	private $ovh_code = NULL;
	private $ovh_desc = NULL;
	private $ovh_value = 0.00;
	private $ovh_date = NULL;
	private $station_id = NULL;
	public function __construct() {
	}
	public final function getOvhId() {
		return (int) $this->ovh_id;
	}
	public final function setOvhId($ovh_id) {
		$this->ovh_id = (int) $ovh_id;
	}
	public final function setOvhCode($ovh_code) {
		$this->ovh_code = (string) $ovh_code;
	}
	public final function getOvhCode() {
		return (string) $this->ovh_code;
	}

	public final function setOvhDesc($ovh_desc) {
		$this->ovh_desc = (string) $ovh_desc;
	}
	public final function getOvhDesc() {
		return (string) $this->ovh_desc;
	}

	public final function getOvhValue() {
		return (double) $this->ovh_value;
	}
	public final function setOvhValue($ovh_value) {
		$this->ovh_value = (double) $ovh_value;
	}
	public final function getOvhDate() {
		return (string) $this->ovh_date;
	}
	public final function setOvhDate($ovh_date) {
		$this->ovh_date = (string) $ovh_date;
	}
	public final function setStationId($station_id) {
		$this->station_id = (string) $station_id;
	}
	public final function getStationId() {
		return (string) $this->station_id;
	}
	public final function toString() {
		$buffer = 'OverheadCost[ovh_id='.$this->ovh_id
		.', ovh_code='.$this->ovh_code
		.', ovh_value='.$this->ovh_value
		.', ovh_date='.$this->ovh_date
		.', ovh_desc='.$this->ovh_desc.']';
		return $buffer;
	}
}
?>