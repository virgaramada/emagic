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
require_once 'vo/Customer.class.php';
require_once 'LogManager.class.php';

class InventoryCustomerManager {
	public function create(Customer $input) {
		$q = "INSERT INTO INV_MGT_CUSTOMER (CUSTOMER_TYPE, CUSTOMER_DESC, CATEGORY) VALUES (?1, ?2, ?3)";
		$insert_id = 0;
		try {
			if (empty($input)) {
				die("Invalid Customer parameter");
			}
			$q_pr = array ("?1", "?2", "?3", "?4");
			$input_var = array ("'".$input->getCustomerType()."'", "'".$input->getCustomerDesc()."'",
                                "'".$input->getCategory()."'");
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
	public function findByPrimaryKey($cust_id) {
		$result = NULL;
		try {
			if (empty($cust_id)) {
				die("Invalid Customer id");
			}
			$q = "SELECT ID, CUSTOMER_TYPE, CUSTOMER_DESC, CATEGORY FROM INV_MGT_CUSTOMER WHERE ID = ?1";
			$q = str_replace("?1", $cust_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new Customer();
				$result->setCustId($row['ID']);
				$result->setCustomerType($row['CUSTOMER_TYPE']);
				$result->setCustomerDesc($row['CUSTOMER_DESC']);
				$result->setCategory($row['CATEGORY']);
				
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Customer by its id : ".$e);
		}
		return $result;
	}
	public function findByCustomerType($customer_type) {
		$results = NULL;
		try {
			if (empty($customer_type)) {
				die("Invalid Customer type");
			}
			$results = array();
			$q = "SELECT ID, CUSTOMER_TYPE, CUSTOMER_DESC, CATEGORY FROM INV_MGT_CUSTOMER WHERE CUSTOMER_TYPE = ?1 ";
		   
			$q = str_replace("?1", "'".$customer_type."'", $q);
			
			$q = $q. " ORDER BY ID DESC";
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new Customer();
				$vo->setCustId($row['ID']);
				$vo->setCustomerType($row['CUSTOMER_TYPE']);
				$vo->setCustomerDesc($row['CUSTOMER_DESC']);
				$vo->setCategory($row['CATEGORY']);
				
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Customer its type : ".$e);
		}
		return $results;
	}
	public function findByCustomerDesc($customer_desc) {
		$results = NULL;
		try {
			if (empty($customer_desc)) {
				die("Invalid Customer description");
			}
			$results = array();
			$q = "SELECT ID, CUSTOMER_TYPE, CUSTOMER_DESC, CATEGORY FROM INV_MGT_CUSTOMER WHERE CUSTOMER_DESC = ?1 ";
		 
			
			$q_pr = array ("?1");
			$input_var = array ("'".$customer_desc."'");
			$q = str_replace($q_pr, $input_var, $q);
			
			
			$q = $q ." ORDER BY ID DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new Customer();
				$vo->setCustId($row['ID']);
				$vo->setCustomerType($row['CUSTOMER_TYPE']);
				$vo->setCustomerDesc($row['CUSTOMER_DESC']);
				$vo->setCategory($row['CATEGORY']);
				
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Customer its type : ".$e);
		}
		return $results;
	}
	public function findAll($pageIndex=NULL, $linePerPage=NULL) {
		$results = NULL;
		try {
			$results = array();
			$q = "SELECT ID, CUSTOMER_TYPE, CUSTOMER_DESC, CATEGORY FROM INV_MGT_CUSTOMER WHERE 1=1";
			
			$q = $q . " ORDER BY ID DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
				
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new Customer();
				$vo->setCustId($row['ID']);
				$vo->setCustomerType($row['CUSTOMER_TYPE']);
				$vo->setCustomerDesc($row['CUSTOMER_DESC']);
				$vo->setCategory($row['CATEGORY']);

				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All customers : ".$e);
		}
		return $results;
	}
	public function countAll() {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_CUSTOMER";

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
			die("Can't find All customers : ".$e);
		}
		return $result;
	}
	public function update(Customer $input) {
		$q = "UPDATE INV_MGT_CUSTOMER SET CUSTOMER_TYPE = ?1, CUSTOMER_DESC = ?2, CATEGORY = ?3 WHERE ID = ?4";

		try {
			if (empty($input) || !$input->getCustId()) {
				die("Invalid Customer Id.");
			}

			$q_pr = array ("?1", "?2", "?3", "?4");
			$input_var = array ("'".$input->getCustomerType()."'",
                                 "'".$input->getCustomerDesc()."'", 
                                 "'".$input->getCategory()."'", 
			$input->getCustId());
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
	public function delete($cust_id) {
		$q = "DELETE FROM INV_MGT_CUSTOMER WHERE ID = ?1";

		try {
			if (empty($cust_id)) {
				die("Invalid Customer Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($cust_id);
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}

	public function deleteAll() {
		$q = "DELETE FROM INV_MGT_CUSTOMER";

		try {
		   
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