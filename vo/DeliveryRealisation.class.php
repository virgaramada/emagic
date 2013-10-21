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
class DeliveryRealisation {
	
    private $delivery_realisation_id = NULL;
	private $sales_order_number = NULL;
	private $station_id = NULL;
	private $inv_type = NULL;
	private $delivery_date = NULL;
	private $delivery_shift_number = NULL;
	private $delivery_time = NULL;
	private $driver_name = NULL;
	private $plate_number = NULL;
	private $quantity = 0.00;
	private $delivery_message = NULL;
	
	public function __construct() {
	}

    public final function setDeliveryRealisationId($delivery_realisation_id) {
		$this->delivery_realisation_id = (int) $delivery_realisation_id;

	}
	public final function getDeliveryRealisationId() {
		return (int) $this->delivery_realisation_id;
	}
	
	
    public final function getQuantity() {
		return (double) $this->quantity;
	}
    public final function setQuantity($quantity) {
		$this->quantity = (double) $quantity;
	}
	
	
	public final function setInvType($inv_type) {
		$this->inv_type = (string) $inv_type;

	}
	public final function getInvType() {
		return (string) $this->inv_type;
	}

    public final function setDriverName($driver_name) {
		$this->driver_name = (string) $driver_name;

	}
	public final function getDriverName() {
		return (string) $this->driver_name;
	}
    public final function setPlateNumber($plate_number) {
		$this->plate_number = (string) $plate_number;

	}
	public final function getPlateNumber() {
		return (string) $this->plate_number;
	}

	public final function setDeliveryDate($delivery_date) {
		$this->delivery_date = (string) $delivery_date;

	}
	public final function getDeliveryDate() {
		return (string) $this->delivery_date;
	}

    public final function setDeliveryTime($delivery_time) {
		$this->delivery_time = (string) $delivery_time;

	}
	public final function getDeliveryTime() {
		return (string) $this->delivery_time;
	}
	
	public final function setDeliveryShiftNumber($delivery_shift_number) {
		$this->delivery_shift_number = (string) $delivery_shift_number;

	}
	public final function getDeliveryShiftNumber() {
		return (string) $this->delivery_shift_number;
	}


	public final function setSalesOrderNumber($sales_order_number) {
		$this->sales_order_number = (string) $sales_order_number;

	}
	public final function getSalesOrderNumber() {
		return (string) $this->sales_order_number;
	}

	public final function setStationId($station_id) {
		$this->station_id = (string) $station_id;

	}
	public final function getStationId() {
		return (string) $this->station_id;
	}
    public final function setDeliveryMessage($delivery_message) {
		$this->delivery_message = (string) $delivery_message;

	}
	public final function getDeliveryMessage() {
		return (string) $this->delivery_message;
	}

	
}
?>