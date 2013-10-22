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
class SalesOrder {

	private $sales_order_id = NULL;
	private $inv_type = NULL;
	private $quantity = 0.00;
	private $bank_transfer_date = NULL;
	private $delivery_date = NULL;
	private $delivery_shift_number = NULL;
	private $bank_name = NULL;
	private $bank_acc_name=NULL;
	private $bank_acc_number=NULL;
	private $sales_order_number = NULL;
	private $station_id = NULL;
	private $order_message = NULL;
	private $order_status = NULL;
	private $order_date = NULL;
	private $receive_date = NULL;
	
	public function __construct() {
	}

	public final function setSalesOrderId($sales_order_id) {
		$this->sales_order_id = (int) $sales_order_id;

	}
	public final function getSalesOrderId() {
		return (int) $this->sales_order_id;
	}

	public final function setInvType($inv_type) {
		$this->inv_type = (string) $inv_type;

	}
	public final function getInvType() {
		return (string) $this->inv_type;
	}

	public final function setQuantity($quantity) {
		$this->quantity = (double) $quantity;

	}
	public final function getQuantity() {
		return (double) $this->quantity;
	}

	public final function setBankTransferDate($bank_transfer_date) {
		$this->bank_transfer_date = (string) $bank_transfer_date;

	}
	public final function getBankTransferDate() {
		return (string) $this->bank_transfer_date;
	}

	public final function setDeliveryDate($delivery_date) {
		$this->delivery_date = (string) $delivery_date;

	}
	public final function getDeliveryDate() {
		return (string) $this->delivery_date;
	}

	public final function setDeliveryShiftNumber($delivery_shift_number) {
		$this->delivery_shift_number = (string) $delivery_shift_number;

	}
	public final function getDeliveryShiftNumber() {
		return (string) $this->delivery_shift_number;
	}

	public final function setBankName($bank_name) {
		$this->bank_name = (string) $bank_name;

	}
	public final function getBankName() {
		return (string) $this->bank_name;
	}

	public final function setBankAccNumber($bank_acc_number) {
		$this->bank_acc_number = (string) $bank_acc_number;

	}
	public final function getBankAccNumber() {
		return (string) $this->bank_acc_number;
	}

	
    public final function setBankAccName($bank_acc_name) {
		$this->bank_acc_name = (string) $bank_acc_name;

	}
	public final function getBankAccName() {
		return (string) $this->bank_acc_name;
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

	public final function setOrderMessage($order_message) {
		$this->order_message = (string) $order_message;

	}
	public final function getOrderMessage() {
		return (string) $this->order_message;
	}
	
    public final function setOrderStatus($order_status) {
		$this->order_status = (string) $order_status;

	}
	public final function getOrderStatus() {
		return (string) $this->order_status;
	}
	
   public final function setOrderDate($order_date) {
		$this->order_date = (string) $order_date;

	}
	public final function getOrderDate() {
		return (string) $this->order_date;
	}
    public final function setReceiveDate($receive_date) {
		$this->receive_date = (string) $receive_date;

	}
	public final function getReceiveDate() {
		return (string) $this->receive_date;
	}
}
?>