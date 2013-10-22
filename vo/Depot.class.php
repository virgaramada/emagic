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
class Depot {

	private $depot_id = NULL;
	private $depot_code = NULL;
	private $depot_name = '';
    private $depot_address =NULL;


	public function __construct() {
	}
	public final function getDepotId() {
		return (int) $this->depot_id;
	}
	public final function setDepotId($depot_id) {
		$this->depot_id = (int) $depot_id;
	}
   public final function getDepotCode() {
		return (string) $this->depot_code;
	}
	public final function setDepotCode($depot_code) {
		$this->depot_code = (string) $depot_code;
	}
    public final function getDepotName() {
		return (string) $this->depot_name;
	}
	public final function setDepotName($depot_name) {
		$this->depot_name = (string) $depot_name;
	}
    public final function getDepotAddress() {
		return (string) $this->deport_address;
	}
	public final function setDepotAddress($deport_address) {
		$this->deport_address = (string) $deport_address;
	}
}
?>