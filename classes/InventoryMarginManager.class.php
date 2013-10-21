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
require_once 'vo/InventoryMargin.class.php';
require_once 'LogManager.class.php';

class InventoryMarginManager {

	public function create(InventoryMargin $input) {
		$q = "INSERT INTO INV_MGT_MARGIN (INV_TYPE, MARGIN_VALUE, START_DATE, END_DATE, STATION_ID) VALUES (?1, ?2, ?3, ?4, ?5)";
		$insert_id = 0;
		try {

			$q_pr = array ("?1", "?2", "?3", "?4", "?5");
			$input_var = array ("'".$input->getInvType()."'", 
			                        $input->getMarginValue(),
			                    "'".$input->getStartDate()."'",
			                    "'".$input->getEndDate()."'",         
			                    "'".$input->getStationId()."'");
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
	public function findByPrimaryKey($inv_id) {
		$result = NULL;
		try {
			$q = "SELECT ID, INV_TYPE, MARGIN_VALUE, START_DATE, END_DATE, STATION_ID FROM INV_MGT_MARGIN WHERE ID = ?1";
			$q = str_replace("?1", $inv_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new InventoryMargin();
				$result->setInvId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setMarginValue((double) $row['MARGIN_VALUE']);
				$result->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$result->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));				
				$result->setStationId($row['STATION_ID']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory margin by its id : ".$e);
		}
		return $result;
	}
	/**
	 * @deprecated use findByInventoryTypeAndDate
	 * @param string $inv_type
	 * @param string $station_id
	 */
	public function findByInventoryType($inv_type, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT ID, INV_TYPE, MARGIN_VALUE, START_DATE, END_DATE, STATION_ID FROM INV_MGT_MARGIN WHERE INV_TYPE = ?1 ";
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q. " ORDER BY ID DESC";
			$q = str_replace("?1", "'".$inv_type."'", $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);

			if ($row) {
				$result = new InventoryMargin();
				$result->setInvId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setMarginValue((double) $row['MARGIN_VALUE']);
				$result->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$result->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$result->setStationId($row['STATION_ID']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory margin by its id : ".$e);
		}
		return $result;
	}
	/**
	 * Finds margin by inventory type and date
	 * @param string $inv_type
	 * @param string $start_date start date in sql date format (yyyy-MM-dd HH:mm:ss)
	 * @param string $end_date end date in sql date format (yyyy-MM-dd HH:mm:ss)
	 * @param string $station_id
	 */
    public function findByInventoryTypeAndDate($inv_type, $start_date= NULL, $end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT ID, INV_TYPE, MARGIN_VALUE, START_DATE, END_DATE, STATION_ID FROM INV_MGT_MARGIN WHERE INV_TYPE = ?1 ";
			
			$q = str_replace("?1", "'".$inv_type."'", $q);
			
		    if (!empty ($start_date)) {
				$q = $q." AND START_DATE >= ?2";
				$q_pr = array ("?2");
				$input_var = array ("'".$start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($end_date)) {
				$q = $q." AND END_DATE <= ?3 ";
				$q_pr = array ("?3");
				$input_var = array ("'".$end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q. " ORDER BY ID DESC";
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);

			if ($row) {
				$result = new InventoryMargin();
				$result->setInvId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setMarginValue((double) $row['MARGIN_VALUE']);
				$result->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$result->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$result->setStationId($row['STATION_ID']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory margin by its id : ".$e);
		}
		return $result;
	}
	
	public function findAll($pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array();
			$q = "SELECT ID, INV_TYPE, MARGIN_VALUE, START_DATE, END_DATE, STATION_ID FROM INV_MGT_MARGIN ";
			if (!empty ($station_id)) {
				$q = $q." WHERE STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY ID DESC";

			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryMargin();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setMarginValue((double) $row['MARGIN_VALUE']);
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$vo->setStationId($row['STATION_ID']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Inventories : ".$e);
		}
		return $results;
	}

	public function countAll($station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_MARGIN";

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
			die("Can't find All Inventories : ".$e);
		}
		return $result;
	}
	public function update(InventoryMargin $input) {
		$q = "UPDATE INV_MGT_MARGIN SET INV_TYPE = ?1, MARGIN_VALUE = ?2, START_DATE = ?3, END_DATE = ?4, WHERE ID = ?5";

		try {
			if (!$input->getInvId()) {
				die("Invalid Inventory Id.");
			}

			$q_pr = array ("?1", "?2", "?3", "?4", "?5");
			$input_var = array ("'".$input->getInvType()."'",
			                        $input->getMarginValue(), 
			                        "'".$input->getStartDate()."'",
			                        "'".$input->getEndDate()."'",
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
		$q = "DELETE FROM INV_MGT_MARGIN WHERE ID = ?1";

		try {
			if (empty($inv_id)) {
				die("Invalid Inventory Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($inv_id);
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}

	public function deleteAll($station_id=NULL) {
		$q = "DELETE FROM INV_MGT_MARGIN";

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