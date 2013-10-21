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
require_once 'DBManager.class.php';
require_once 'vo/SalesOrder.class.php';
require_once 'LogManager.class.php';
class SalesOrderManager {


	public function create(SalesOrder $input) {
		$q = "INSERT INTO INV_MGT_SALES_ORDER (INV_TYPE, QUANTITY, BANK_TRANSFER_DATE, DELIVERY_DATE, DELIVERY_SHIFT_NUMBER, BANK_NAME, BANK_ACCOUNT_NUMBER, SALES_ORDER_NUMBER, STATION_ID, ORDER_MESSAGE, ORDER_STATUS, ORDER_DATE) "
		. " VALUES (?1, ?2, ?3, ?4, ?5, ?6, ?7, ?8, ?9, ?A, ?B, ?C)";
		$insert_id = 0;
		try {
			if (empty($input) ) {
				die("Invalid SalesOrder parameter.");
			}
			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6", "?7", "?8", "?9", "?A", "?B", "?C");
			$input_var = array ("'".$input->getInvType()."'",
			                        $input->getQuantity(),
			                    "'".$input->getBankTransferDate()."'",
			                    "'".$input->getDeliveryDate()."'",
			                    "'".$input->getDeliveryShiftNumber()."'",
			                    "'".$input->getBankName()."'",
			                    "'".$input->getBankAccNumber()."'",
			                    "'".$input->getSalesOrderNumber()."'",
			                    "'".$input->getStationId()."'",
			                    "'".$input->getOrderMessage()."'",
			                    "'".$input->getOrderStatus()."'",
			                    "'".$input->getOrderDate()."'");
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$insert_id = mysql_insert_id();
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while inserting data into database : ".$e);
		}
		return $insert_id;
	}

	public function findByPrimaryKey($sales_order_id) {
		$result = NULL;
		try {
			if (empty($sales_order_id)) {
				die("Invalid Sales Order Id.");
			}
			$q = "SELECT ID, INV_TYPE, QUANTITY, BANK_TRANSFER_DATE, DELIVERY_DATE, DELIVERY_SHIFT_NUMBER, BANK_NAME, BANK_ACCOUNT_NUMBER, SALES_ORDER_NUMBER, STATION_ID, ORDER_MESSAGE, ORDER_STATUS, ORDER_DATE, RECEIVE_DATE FROM INV_MGT_SALES_ORDER WHERE ID = ?1";
			$q = str_replace("?1", $sales_order_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new SalesOrder();
				$result->setSalesOrderId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setQuantity((double) $row['QUANTITY']);

				$transfer_date = date("d/m/Y H:i:s", strtotime($row['BANK_TRANSFER_DATE']));
				$result->setBankTransferDate($transfer_date);

				$delivery_date = date("d/m/Y", strtotime($row['DELIVERY_DATE']));
				$order_date = date("d/m/Y H:i:s", strtotime($row['ORDER_DATE']));
				
			    if($row['RECEIVE_DATE']) {
					$receive_date = date("d/m/Y H:i:s", strtotime($row['RECEIVE_DATE']));
				    $result->setReceiveDate($receive_date);
				}
				
				
				
				$result->setDeliveryDate($delivery_date);
				$result->setDeliveryShiftNumber($row['DELIVERY_SHIFT_NUMBER']);
				$result->setBankName($row['BANK_NAME']);
				$result->setBankAccNumber($row['BANK_ACCOUNT_NUMBER']);
				$result->setSalesOrderNumber($row['SALES_ORDER_NUMBER']);
				$result->setStationId($row['STATION_ID']);
				$result->setOrderMessage($row['ORDER_MESSAGE']);
				$result->setOrderStatus($row['ORDER_STATUS']);
				$result->setOrderDate($order_date);
				
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Sales Order by its id : ".$e);
		}
		return $result;
	}

	public function findBySalesOrderNumberAndStation($sales_order_number, $station_id) {
		$result = NULL;
		try {
			if (empty($sales_order_number)) {
				die("Invalid Sales Order number.");
			}
			if (empty($station_id)) {
				die("Invalid Gas Station.");
			}
			$q = "SELECT ID, INV_TYPE, QUANTITY, BANK_TRANSFER_DATE, DELIVERY_DATE, DELIVERY_SHIFT_NUMBER, BANK_NAME, BANK_ACCOUNT_NUMBER, SALES_ORDER_NUMBER, STATION_ID, ORDER_MESSAGE, ORDER_STATUS, ORDER_DATE, RECEIVE_DATE FROM INV_MGT_SALES_ORDER WHERE SALES_ORDER_NUMBER = ?1 AND STATION_ID = ?2";
			$q_pr = array ("?1", "?2");
				
			$input_var = array ("'".$sales_order_number."'",
			                    "'".$station_id."'");
				
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$vo = new SalesOrder();
				$vo->setSalesOrderId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);

				$transfer_date = date("d/m/Y H:i:s", strtotime($row['BANK_TRANSFER_DATE']));
				$vo->setBankTransferDate($transfer_date);

				$delivery_date = date("d/m/Y", strtotime($row['DELIVERY_DATE']));
				
				$order_date = date("d/m/Y H:i:s", strtotime($row['ORDER_DATE']));
				if($row['RECEIVE_DATE']) {
					$receive_date = date("d/m/Y H:i:s", strtotime($row['RECEIVE_DATE']));
				    $vo->setReceiveDate($receive_date);
				}
				
				
				$vo->setDeliveryDate($delivery_date);
				$vo->setDeliveryShiftNumber($row['DELIVERY_SHIFT_NUMBER']);
				$vo->setBankName($row['BANK_NAME']);
				$vo->setBankAccNumber($row['BANK_ACCOUNT_NUMBER']);
				$vo->setSalesOrderNumber($row['SALES_ORDER_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOrderMessage($row['ORDER_MESSAGE']);
				$vo->setOrderStatus($row['ORDER_STATUS']);
				$vo->setOrderDate($order_date);

				$result = $vo;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Sales Order by its id : ".$e);
		}
		return $result;
	}

	public function findAll($pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array();
			$q = "SELECT ID, INV_TYPE, QUANTITY, BANK_TRANSFER_DATE, DELIVERY_DATE, DELIVERY_SHIFT_NUMBER, BANK_NAME, BANK_ACCOUNT_NUMBER, SALES_ORDER_NUMBER, STATION_ID, ORDER_MESSAGE, ORDER_STATUS, ORDER_DATE, RECEIVE_DATE FROM INV_MGT_SALES_ORDER ";
			if (!empty ($station_id)) {
				$q = $q." WHERE STATION_ID = '".$station_id."'";
			}
			$q = $q." ORDER BY DELIVERY_DATE";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new SalesOrder();
				$vo->setSalesOrderId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);

				$transfer_date = date("d/m/Y H:i:s", strtotime($row['BANK_TRANSFER_DATE']));
				$vo->setBankTransferDate($transfer_date);

				$delivery_date = date("d/m/Y", strtotime($row['DELIVERY_DATE']));
				
				$order_date = date("d/m/Y H:i:s", strtotime($row['ORDER_DATE']));
				
			    if($row['RECEIVE_DATE']) {
					$receive_date = date("d/m/Y H:i:s", strtotime($row['RECEIVE_DATE']));
				    $vo->setReceiveDate($receive_date);
				}
				
				
				$vo->setDeliveryDate($delivery_date);
				$vo->setDeliveryShiftNumber($row['DELIVERY_SHIFT_NUMBER']);
				$vo->setBankName($row['BANK_NAME']);
				$vo->setBankAccNumber($row['BANK_ACCOUNT_NUMBER']);
				$vo->setSalesOrderNumber($row['SALES_ORDER_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOrderMessage($row['ORDER_MESSAGE']);
				$vo->setOrderStatus($row['ORDER_STATUS']);
                $vo->setOrderDate($order_date);

				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Stations : ".$e);
		}
		return $results;
	}

	public function findBySalesOrderNumber($pageIndex=NULL, $linePerPage=NULL, $sales_order_number) {
		$results = NULL;
		try {
			if (empty($sales_order_number)) {
				die("Invalid Sales Order number.");
			}
			$results = array();
			$q = "SELECT ID, INV_TYPE, QUANTITY, BANK_TRANSFER_DATE, DELIVERY_DATE, DELIVERY_SHIFT_NUMBER, BANK_NAME, BANK_ACCOUNT_NUMBER, SALES_ORDER_NUMBER, STATION_ID, ORDER_MESSAGE, ORDER_STATUS, ORDER_DATE, RECEIVE_DATE FROM INV_MGT_SALES_ORDER ";
				
			$q = $q." WHERE SALES_ORDER_NUMBER = '".$sales_order_number."'";
				
			$q = $q." ORDER BY DELIVERY_DATE";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new SalesOrder();
				$vo->setSalesOrderId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);

				$transfer_date = date("d/m/Y H:i:s", strtotime($row['BANK_TRANSFER_DATE']));
				$vo->setBankTransferDate($transfer_date);

				$delivery_date = date("d/m/Y", strtotime($row['DELIVERY_DATE']));
				
				$order_date = date("d/m/Y H:i:s", strtotime($row['ORDER_DATE']));
				
			    if($row['RECEIVE_DATE']) {
					$receive_date = date("d/m/Y H:i:s", strtotime($row['RECEIVE_DATE']));
				    $vo->setReceiveDate($receive_date);
				}
				
				
				$vo->setDeliveryDate($delivery_date);
				$vo->setDeliveryShiftNumber($row['DELIVERY_SHIFT_NUMBER']);
				$vo->setBankName($row['BANK_NAME']);
				$vo->setBankAccNumber($row['BANK_ACCOUNT_NUMBER']);
				$vo->setSalesOrderNumber($row['SALES_ORDER_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOrderMessage($row['ORDER_MESSAGE']);
				$vo->setOrderStatus($row['ORDER_STATUS']);
				$vo->setOrderDate($order_date);


				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Stations by sales order number : ".$e);
		}
		return $results;
	}

	public function findByStatus($pageIndex=NULL, $linePerPage=NULL, $order_status, $station_id=NULL) {
		$results = NULL;

			
		try {
			$results = array();
				
			if (empty ($order_status)) {
				die("Invalid Sales Order status.");
			}
				
			$q = "SELECT ID, INV_TYPE, QUANTITY, BANK_TRANSFER_DATE, DELIVERY_DATE, DELIVERY_SHIFT_NUMBER, BANK_NAME, BANK_ACCOUNT_NUMBER, SALES_ORDER_NUMBER, STATION_ID, ORDER_MESSAGE, ORDER_STATUS, ORDER_DATE, RECEIVE_DATE FROM INV_MGT_SALES_ORDER WHERE 1=1";
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			if (!empty ($order_status)) {
				$q = $q." AND ORDER_STATUS = '".$station_id."'";
			}

			$q = $q." ORDER BY DELIVERY_DATE";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new SalesOrder();
				$vo->setSalesOrderId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);

				$transfer_date = date("d/m/Y H:i:s", strtotime($row['BANK_TRANSFER_DATE']));
				$vo->setBankTransferDate($transfer_date);

				$delivery_date = date("d/m/Y", strtotime($row['DELIVERY_DATE']));
				
				$order_date = date("d/m/Y H:i:s", strtotime($row['ORDER_DATE']));
			    if($row['RECEIVE_DATE']) {
				   $receive_date = date("d/m/Y H:i:s", strtotime($row['RECEIVE_DATE']));
				   $vo->setReceiveDate($receive_date);
				}
				
				
				$vo->setDeliveryDate($delivery_date);
				$vo->setDeliveryShiftNumber($row['DELIVERY_SHIFT_NUMBER']);
				$vo->setBankName($row['BANK_NAME']);
				$vo->setBankAccNumber($row['BANK_ACCOUNT_NUMBER']);
				$vo->setSalesOrderNumber($row['SALES_ORDER_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOrderMessage($row['ORDER_MESSAGE']);
				$vo->setOrderStatus($row['ORDER_STATUS']);
				
                $vo->setOrderDate($order_date);

				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Stations : ".$e);
		}
		return $results;
	}


	public function update($input) {


		try {
			if (!$input->getSalesOrderId()) {
				die("Invalid Sales Order Id.");
			}
				
			$q = "UPDATE INV_MGT_SALES_ORDER SET INV_TYPE = ?1, QUANTITY = ?2, BANK_TRANSFER_DATE = ?3, DELIVERY_DATE = ?4, DELIVERY_SHIFT_NUMBER = ?5, BANK_NAME = ?6, BANK_ACCOUNT_NUMBER = ?7, SALES_ORDER_NUMBER = ?8, "
			." ORDER_MESSAGE = ?9, ORDER_STATUS = ?A  WHERE ID = ?B";
			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6", "?7", "?8", "?9", "?A", "?B");

			$input_var = array ("'".$input->getInvType()."'",
			$input->getQuantity(),
			                    "'".$input->getBankTransferDate()."'",
			                    "'".$input->getDeliveryDate()."'",
			                    "'".$input->getDeliveryShiftNumber()."'",
			                    "'".$input->getBankName()."'",
			                    "'".$input->getBankAccNumber()."'",
			                    "'".$input->getSalesOrderNumber()."'",
			                    "'".$input->getOrderMessage()."'",
			                    "'".$input->getOrderStatus()."'",
			$input->getSalesOrderId());
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while updating data in database : ".$e);
		}
	}

	public function updateStatus($sales_order_id, $order_status) {


		try {
			if (empty ($sales_order_id)) {
				die("Invalid Sales Order Id.");
			}
			if (empty ($order_status)) {
				die("Invalid Sales Order status.");
			}
				
			$q = "UPDATE INV_MGT_SALES_ORDER SET ORDER_STATUS = ?1 WHERE ID = ?2";
			$q_pr = array ("?1", "?2");

			$input_var = array ("'".$order_status."'", $sales_order_id);
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while updating data in database : ".$e);
		}
	}
	
	public function confirmReceive($sales_order_number, $station_id) {


		try {
			if (empty ($sales_order_number)) {
				die("Invalid Sales Order Number.");
			}
			if (empty ($station_id)) {
				die("Invalid Station Id.");
			}

			$receive_date = date("Y-m-d H:i:s", mktime());
			$q = "UPDATE INV_MGT_SALES_ORDER SET RECEIVE_DATE = '".$receive_date."' WHERE SALES_ORDER_NUMBER = ?1 AND STATION_ID = ?2";
			$q_pr = array ("?1", "?2");

			$input_var = array ("'".$sales_order_number."'", "'".$station_id."'");
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while updating data in database : ".$e);
		}
	}

	public function delete($sales_order_id) {
		$q = "DELETE FROM INV_MGT_SALES_ORDER WHERE ID = ?1";

		try {
			if (empty($sales_order_id)) {
				die("Invalid Sales Order Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($sales_order_id);
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}
	public function countAll($station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_SALES_ORDER";
			if (!empty ($station_id)) {
				$q = $q." WHERE STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_row($rs);
			if ($row) {
				$result = $row[0];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All sales orders : ".$e);
		}
		return $result;
	}
	public function countAllBySalesOrderNumber($sales_order_number) {
		$result = NULL;
		try {
			if (empty($sales_order_number)) {
				die("Invalid Sales Order number.");
			}
			$q = "SELECT COUNT(ID) FROM INV_MGT_SALES_ORDER";
				
			$q = $q." WHERE SALES_ORDER_NUMBER = '".$sales_order_number."'";
				
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_row($rs);
			if ($row) {
				$result = $row[0];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All sales orders : ".$e);
		}
		return $result;
	}

	public function deleteAll($station_id=NULL) {
		$q = "DELETE FROM INV_MGT_SALES_ORDER";

		try {
			if (!empty ($station_id)) {
				$q = $q." WHERE STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}
}
?>