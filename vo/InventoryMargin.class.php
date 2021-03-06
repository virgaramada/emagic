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
class InventoryMargin {

    private $inv_id = NULL;
    private $inv_type = '';
    private $margin_value = 0.00;
    private $station_id = NULL;
    private $start_date = NULL;
	private $end_date = NULL;
	
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

    public final function getMarginValue() {
        return (double) $this->margin_value;
    }
    public final function setMarginValue($margin_value) {
        $this->margin_value = (double) $margin_value;
    }
    public final function setStationId($station_id) {
    	$this->station_id = (string) $station_id;
    }
    public final function getStationId() {
    	return (string) $this->station_id;
    }
   public final function getStartDate() {
		return (string) $this->start_date;
	}
	public final function setStartDate($start_date) {
		$this->start_date = (string) $start_date;
	}
	
    public final function getEndDate() {
		return (string) $this->end_date;
	}
	public final function setEndDate($end_date) {
		$this->end_date = (string) $end_date;
	}
    public final function toString() {
        $buffer = 'InventoryMargin[inv_id='.$this->inv_id.', inv_type='.$this->inv_type
                  .', margin_value='.$this->margin_value.']';
        return $buffer;
    }
}
?>