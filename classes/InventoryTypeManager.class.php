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
require_once 'vo/InventoryType.class.php';
require_once 'DBManager.class.php';
require_once 'LogManager.class.php';

class InventoryTypeManager {

	public function create(InventoryType $input) {
		$q = "INSERT INTO INV_MGT_TYPE (INV_TYPE, INV_DESC, PRODUCT_TYPE) "
		." VALUES (?1, ?2, ?3)";
		$insert_id = 0;
		try {

			$q_pr = array ("?1", "?2", "?3");
			$input_var = array ("'".$input->getInvType()."'",
			                    "'".$input->getInvDesc()."'",
			                    "'".$input->getProductType()."'"
			                    );
			                    $q = str_replace($q_pr, $input_var, $q);
			                    LogManager :: LOG(__METHOD__."() : ". $q);
			                    $conn = DBManager :: get_connection();

			                    mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			                    $insert_id = mysql_insert_id();
			                    mysql_query("COMMIT");
			                    mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while inserting data into database ".$e);
		}
		return $insert_id;
	}

	public function findByPrimaryKey($inv_id) {
		$result = NULL;
		try {
			$q = "SELECT ID, INV_TYPE, INV_DESC, PRODUCT_TYPE FROM INV_MGT_TYPE WHERE ID = ?1";
			$q = str_replace("?1", $inv_id, $q);

			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new InventoryType();
				$result->setInvId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setInvDesc($row['INV_DESC']);
				$result->setProductType($row['PRODUCT_TYPE']);

			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory type by its id : ".$e);
		}
		return $result;
	}

	public function findByInventoryType($inventory_type) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, INV_DESC, PRODUCT_TYPE FROM INV_MGT_TYPE WHERE INV_TYPE = ?1 ";

		   
			$q_pr = array ("?1");
			$input_var = array ("'".$inventory_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			$q = $q . " ORDER BY ID DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$result = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$vo = new InventoryType();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setInvDesc($row['INV_DESC']);
				$vo->setProductType($row['PRODUCT_TYPE']);

				$results[$count] = $vo;
				$count ++;
			}
			mysql_free_result($result);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by delivery number and date : ".$e);
		}
		return $results;
	}
	public function findAll($pageIndex=NULL, $linePerPage=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, INV_DESC, PRODUCT_TYPE FROM INV_MGT_TYPE WHERE 1=1";
		    

			$q = $q. " ORDER BY ID DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$result = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$vo = new InventoryType();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setInvDesc($row['INV_DESC']);
				$vo->setProductType($row['PRODUCT_TYPE']);

				$results[$count] = $vo;
				$count ++;
			}
			mysql_free_result($result);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Inventories : ".$e);
		}
		return $results;
	}

	public function countAll() {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_TYPE";

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
			die("Can't find All Inventories : ".$e);
		}
		return $result;
	}
	public function findByProductType($product_type = NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, INV_DESC, PRODUCT_TYPE FROM INV_MGT_TYPE WHERE 1=1";
			
			
			if (!empty ($product_type)) {
				$q = "SELECT ID, INV_TYPE, INV_DESC, PRODUCT_TYPE FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1 ";
				$q_pr = array ("?1");
				$input_var = array ("'".$product_type."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
		    
			$q = $q . " ORDER BY ID DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$result = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$vo = new InventoryType();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setInvDesc($row['INV_DESC']);
				$vo->setProductType($row['PRODUCT_TYPE']);

				$results[$count] = $vo;
				$count ++;
			}
			mysql_free_result($result);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Inventories by product type : ".$e);
		}
		return $results;
	}
	public function update(InventoryType $input) {
		$q = "UPDATE INV_MGT_TYPE SET INV_TYPE = ?1, INV_DESC = ?2, PRODUCT_TYPE = ?3 WHERE ID = ?4";

		try {
			if (!$input->getInvId()) {
				die("Invalid Inventory Id.");
			}

			$q_pr = array ("?1", "?2", "?3", "?4");
			$input_var = array ("'".$input->getInvType()."'",
			"'".$input->getInvDesc()."'", 
			"'".$input->getProductType()."'",
			$input->getInvId());
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

	public function delete($inv_id) {
		$m = "DELETE FROM INV_MGT_MARGIN WHERE INV_TYPE in (SELECT INV_TYPE FROM INV_MGT_TYPE WHERE ID = ?1)";
		$p = "DELETE FROM INV_MGT_PRICE WHERE INV_TYPE in (SELECT INV_TYPE FROM INV_MGT_TYPE WHERE ID = ?1)";
		$s = "DELETE FROM INV_MGT_SUPPLY WHERE INV_TYPE in (SELECT INV_TYPE FROM INV_MGT_TYPE WHERE ID = ?1)";
		$o = "DELETE FROM INV_MGT_OUTPUT WHERE INV_TYPE in (SELECT INV_TYPE FROM INV_MGT_TYPE WHERE ID = ?1)";
		$so = "DELETE FROM INV_MGT_SALES_ORDER WHERE INV_TYPE in (SELECT INV_TYPE FROM INV_MGT_TYPE WHERE ID = ?1)";
		$q = "DELETE FROM INV_MGT_TYPE WHERE ID = ?1";

		try {
			if (empty ($inv_id)) {
				die("Invalid Inventory Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($inv_id);
			$m = str_replace($q_pr, $input_var, $m);
			$p = str_replace($q_pr, $input_var, $p);
			$s = str_replace($q_pr, $input_var, $s);
			$o = str_replace($q_pr, $input_var, $o);
			$so = str_replace($q_pr, $input_var, $so);
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			mysql_query($m) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($p) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($s) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($o) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($so) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}
	public function deleteAll() {
		$m = "DELETE FROM INV_MGT_MARGIN WHERE INV_TYPE IN "
		     ."("
		     ."SELECT INV_TYPE FROM INV_MGT_TYPE";
	    
		$m = $m . ")";
	    

		$p = "DELETE FROM INV_MGT_PRICE WHERE INV_TYPE IN "
		    ."("
		    ."SELECT INV_TYPE FROM INV_MGT_TYPE";
	    
		$p = $p . ")";

	    
		$s = "DELETE FROM INV_MGT_SUPPLY WHERE INV_TYPE IN "
		    ."("
		    ."SELECT INV_TYPE FROM INV_MGT_TYPE";
	    
		$s = $s .")";
	    
		$o = "DELETE FROM INV_MGT_OUTPUT WHERE INV_TYPE IN "
		    . "("
		    ."SELECT INV_TYPE FROM INV_MGT_TYPE";
	    
		$o = $o. ")";
		
	    
		$so = "DELETE FROM INV_MGT_SALES_ORDER WHERE INV_TYPE IN "
		      . "("
		      . "SELECT INV_TYPE FROM INV_MGT_TYPE";
	    
		$so = $so .")";
	    
		$q = "DELETE FROM INV_MGT_TYPE";
		
	    
		try {
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			mysql_query($m) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($p) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($s) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($o) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($so) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}
}
?>