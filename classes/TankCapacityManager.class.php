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
require_once 'vo/TankCapacity.class.php';
require_once 'LogManager.class.php';

class TankCapacityManager {
	public function create(TankCapacity $input) {
		$q = "INSERT INTO INV_MGT_TANK_CAPACITY (INV_TYPE, TANK_CAPACITY, STATION_ID, TANK_NUMBER) VALUES (?1, ?2, ?3, ?4)";
		$insert_id = 0;
		try {

			$q_pr = array ("?1", "?2", "?3", "?4");
			$input_var = array ("'".$input->getInvType()."'", $input->getTankCapacity(), "'".$input->getStationId()."'", "'".$input->getTankNumber()."'");
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
			$q = "SELECT ID, INV_TYPE, TANK_CAPACITY, STATION_ID, TANK_NUMBER FROM INV_MGT_TANK_CAPACITY WHERE ID = ?1";
			$q = str_replace("?1", $inv_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new TankCapacity();
				$result->setId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setTankCapacity((double) $row['TANK_CAPACITY']);
				$result->setStationId($row['STATION_ID']);
				$result->setTankNumber($row['TANK_NUMBER']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find tank capacity by its id : ".$e);
		}
		return $result;
	}
	public function findByInventoryType($inv_type, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT ID, INV_TYPE, TANK_CAPACITY, STATION_ID, TANK_NUMBER FROM INV_MGT_TANK_CAPACITY WHERE INV_TYPE = ?1 ";
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
				$result = new TankCapacity();
				$result->setId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setTankCapacity((double) $row['TANK_CAPACITY']);
				$result->setStationId($row['STATION_ID']);
				$result->setTankNumber($row['TANK_NUMBER']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find tank capacity by inv type : ".$e);
		}
		return $result;
	}
	public function findAll($pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array();
			$q = "SELECT ID, INV_TYPE, TANK_CAPACITY, STATION_ID, TANK_NUMBER FROM INV_MGT_TANK_CAPACITY ";
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
				$vo = new TankCapacity();
				$vo->setId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setTankCapacity((double) $row['TANK_CAPACITY']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setTankNumber($row['TANK_NUMBER']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All tank capacity : ".$e);
		}
		return $results;
	}

	public function countAll($station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_TANK_CAPACITY";

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
			die("Can't count All tank capacity : ".$e);
		}
		return $result;
	}
	public function update(TankCapacity $input) {
		$q = "UPDATE INV_MGT_TANK_CAPACITY SET INV_TYPE = ?1, TANK_CAPACITY = ?2, TANK_NUMBER = ?3 WHERE ID = ?4";

		try {
			if (!$input->getId()) {
				die("Invalid tank capacity Id.");
			}

			$q_pr = array ("?1", "?2", "?3", "?4");
			$input_var = array ("'".$input->getInvType()."'", $input->getTankCapacity(), "'".$input->getTankNumber()."'", $input->getId());
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
		$q = "DELETE FROM INV_MGT_TANK_CAPACITY WHERE ID = ?1";

		try {
			if (empty($inv_id)) {
				die("Invalid tank capacity Id.");
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
		$q = "DELETE FROM INV_MGT_TANK_CAPACITY";

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