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
require_once 'vo/Depot.class.php';
require_once 'LogManager.class.php';

class DepotManager {
	
    public function create(Depot $input) {
		$q = "INSERT INTO INV_MGT_DEPOT (DEPOT_CODE, DEPOT_NAME, DEPOT_ADDRESS) VALUES (?1, ?2, ?3)";
		$insert_id = 0;
		try {

			$q_pr = array ("?1", "?2", "?3");
			$input_var = array ("'".$input->getDepotCode()."'",
			                   "'".$input->getDepotName()."'", 
			                   "'".$input->getDepotAddress()."'");
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
	
	public function findByPrimaryKey($depot_id) {
		$result = NULL;
		try {
			$q = "SELECT ID, DEPOT_CODE, DEPOT_NAME, DEPOT_ADDRESS FROM INV_MGT_DEPOT WHERE ID = ?1";
			$q = str_replace("?1", $depot_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new Depot();
				$result->setDepotId($row['ID']);
				$result->setDepotCode($row['DEPOT_CODE']);
				$result->setDepotName($row['DEPOT_NAME']);
				$result->setDepotAddress($row['DEPOT_ADDRESS']);
				
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find depot by its id : ".$e);
		}
		return $result;
	}
	
    public function findByCode($depot_code) {
		$result = NULL;
		try {
			$q = "SELECT ID, DEPOT_CODE, DEPOT_NAME, DEPOT_ADDRESS FROM INV_MGT_DEPOT WHERE DEPOT_CODE = ?1";
			$q = str_replace("?1", $depot_code, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new Depot();
				$result->setDepotId($row['ID']);
				$result->setDepotCode($row['DEPOT_CODE']);
				$result->setDepotName($row['DEPOT_NAME']);
				$result->setDepotAddress($row['DEPOT_ADDRESS']);
				
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find depot by its id : ".$e);
		}
		return $result;
	}
	
    public function findAll($pageIndex=NULL, $linePerPage=NULL) {
		$results = NULL;
		try {
			$results = array();
			$q = "SELECT ID, DEPOT_CODE, DEPOT_NAME, DEPOT_ADDRESS FROM INV_MGT_DEPOT ";
			
			$q = $q ." ORDER BY ID DESC";

			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new Depot();
				$vo->setDepotId($row['ID']);
				$vo->setDepotCode($row['DEPOT_CODE']);
				$vo->setDepotName($row['DEPOT_NAME']);
				$vo->setDepotAddress($row['DEPOT_ADDRESS']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All depot : ".$e);
		}
		return $results;
	}

	public function countAll() {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_DEPOT";

			
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
			die("Can't count All depot : ".$e);
		}
		return $result;
	}
	public function update(Depot $input) {
		$q = "UPDATE INV_MGT_DEPOT SET DEPOT_CODE = ?1, DEPOT_NAME = ?2, DEPOT_ADDRESS = ?3 WHERE ID = ?4";

		try {
			if (!$input->getId()) {
				die("Invalid depot Id.");
			}

			$q_pr = array ("?1", "?2", "?3", "?4");
			$input_var = array ("'".$input->getDepotCode()."'",
			                    "'".$input->getDepotName()."'", 
			                    "'".$input->getDepotAddress()."'",
			                    $input->getDepotId());
			                    
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
	public function delete($depot_id) {
		$q = "DELETE FROM INV_MGT_DEPOT WHERE ID = ?1";

		try {
			if (empty($depot_id)) {
				die("Invalid depot Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($depot_id);
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
		$q = "DELETE FROM INV_MGT_DEPOT";

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