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
class Customer {

	private $cust_id = NULL;
	private $customer_type = '';
	private $customer_desc = '';
    private $category = '';
   //private $station_id = NULL;     

	public function __construct() {
	}
	public final function getCustId() {
		return (int) $this->cust_id;
	}
	public final function setCustId($cust_id) {
		$this->cust_id = (int) $cust_id;
	}
	public final function getCustomerType() {
		return (string) $this->customer_type;
	}
	public final function setCustomerType($customer_type) {
		$this->customer_type = (string) $customer_type;
	}
	public final function getCustomerDesc() {
		return (string) $this->customer_desc;
	}
	public final function setCustomerDesc($customer_desc) {
		$this->customer_desc = (string) $customer_desc;
	}
    public final function getCategory() {
        return (string) $this->category;
    }
    public final function setCategory($category) {
        $this->category = (string) $category;
    }
    /**public final function setStationId($station_id) {
		$this->station_id = (string) $station_id;

	}
	public final function getStationId() {
		return (string) $this->station_id;
	}*/
    
    public final function toString() {
        $buffer = 'Customer[cust_id='.$this->cust_id.', customer_type='.$this->customer_type
                  .', category='.$this->category
                  .', customer_desc='.$this->customer_desc.']';
        return $buffer;
    }
}
?>