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
require_once 'vo/WorkInCapital.class.php';
require_once 'LogManager.class.php';

class WorkInCapitalManager {

	public function create(WorkInCapital $input) {
		$q = "INSERT INTO WORK_IN_CAPITAL (C_VALUE, C_DESC, C_CODE, STATION_ID) VALUES (?1, ?2, ?3, ?4)";
		$insert_id = 0;
		try {
			if (empty($input)) {
				die("Invalid WorkInCapital parameter.");
			}
			$q_pr = array ("?1", "?2", "?3", "?4");
			$input_var = array ($input->getValue(),
                                "'".$input->getDesc()."'",
                                "'".$input->getCode()."'",
                                "'".$input->getStationId()."'");
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
	public function findByPrimaryKey($id) {
		$result = NULL;
		try {
			if (empty($id)) {
				die("Invalid WorkInCapital id.");
			}
			$q = "SELECT ID, C_VALUE, C_DESC, C_CODE, STATION_ID FROM WORK_IN_CAPITAL WHERE ID = ?1";
			$q = str_replace("?1", $id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);

			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new WorkInCapital();
				$result->setId($row['ID']);
				$result->setValue((double) $row['C_VALUE']);
				$result->setDesc($row['C_DESC']);
				$result->setCode($row['C_CODE']);
				$result->setStationId($row['STATION_ID']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find WorkInCapital by its id : ".$e);
		}
		return $result;
	}
	public function findAll($station_id=NULL) {
		$results = NULL;
		try {
			$results = array();
			$q = "SELECT ID, C_CODE, C_VALUE, C_DESC, STATION_ID FROM WORK_IN_CAPITAL ";
			if (!empty ($station_id)) {
				$q = $q." WHERE STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY ID DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new WorkInCapital();
				$vo->setId($row['ID']);
				$vo->setCode($row['C_CODE']);
				$vo->setDesc($row['C_DESC']);
				$vo->setValue((double) $row['C_VALUE']);
				$vo->setStationId($row['STATION_ID']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All WorkInCapital : ".$e);
		}
		return $results;
	}

	public function findByCode($c_code = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT ID, C_VALUE, C_DESC, C_CODE, STATION_ID FROM WORK_IN_CAPITAL WHERE C_CODE = ?1";
			$q = str_replace("?1", "'".$c_code."'", $q);
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);

			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new WorkInCapital();
				$result->setId($row['ID']);
				$result->setValue((double) $row['C_VALUE']);
				$result->setDesc($row['C_DESC']);
				$result->setCode($row['C_CODE']);
				$result->setStationId($row['STATION_ID']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find WorkInCapital by its id : ".$e);
		}
		return $result;
	}

	public function update(WorkInCapital $input) {
		$q = "UPDATE WORK_IN_CAPITAL SET C_CODE = ?1, C_DESC = ?2, C_VALUE = ?3 WHERE ID = ?4";

		try {
			if (!$input->getId()) {
				die("Invalid WorkInCapital Id.");
			}
			$q_pr = array ("?1", "?2", "?3", "?4");
			$input_var = array ("'".$input->getCode()."'",
                                "'".$input->getDesc()."'",
			$input->getValue(),
			$input->getId());
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

	public function delete($id) {
		$q = "DELETE FROM WORK_IN_CAPITAL WHERE ID = ?1";

		try {
			if (empty($id)) {
				die("Invalid WorkInCapital Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($id);
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
		$q = "DELETE FROM WORK_IN_CAPITAL";

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