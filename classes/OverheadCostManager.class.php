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
require_once 'vo/OverheadCost.class.php';
require_once 'LogManager.class.php';

class OverheadCostManager {

	public function create(OverheadCost $input) {
		$q = "INSERT INTO OVERHEAD_COST (OVH_CODE, OVH_DESC, OVH_VALUE, OVH_DATE, STATION_ID) VALUES (?1, ?2, ?3, ?4, ?5)";
		$insert_id = 0;
		try {
			if (empty($input) ) {
				die("Invalid OverheadCost parameter.");
			}
			$ovh_date = $input->getOvhDate();

			$q_pr = array ("?1", "?2", "?3", "?4", "?5");
			$input_var = array ("'".$input->getOvhCode()."'",
                                "'".$input->getOvhDesc()."'",
			$input->getOvhValue(),
                                "'".$ovh_date."'",
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
	public function findByPrimaryKey($ovh_id) {
		$result = NULL;
		try {
			if (empty($ovh_id) ) {
				die("Invalid OverheadCost id.");
			}
			$q = "SELECT ID, OVH_CODE, OVH_DESC, OVH_VALUE, OVH_DATE, STATION_ID FROM OVERHEAD_COST WHERE ID = ?1";
			$q = str_replace("?1", $ovh_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);

			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new OverheadCost();
				$ovh_date = $row['OVH_DATE'];
				$date_formatted = date("d/m/Y", strtotime($ovh_date));
				$result->setOvhDate($date_formatted);
				$result->setOvhId($row['ID']);
				$result->setOvhCode($row['OVH_CODE']);
				$result->setOvhValue((double) $row['OVH_VALUE']);
				$result->setOvhDesc($row['OVH_DESC']);
				$result->setStationId($row['STATION_ID']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its id : ".$e);
		}
		return $result;
	}
	public function findByOverheadCode($ovh_code, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($ovh_code) ) {
				die("Invalid OverheadCost code.");
			}
			$q = "SELECT ID, OVH_CODE, OVH_DESC, OVH_VALUE, OVH_DATE, STATION_ID FROM OVERHEAD_COST WHERE OVH_CODE = ?1 ";
			$q = str_replace("?1", "'".$ovh_code."'", $q);
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY OVH_DATE DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new OverheadCost();
				$ovh_date = $row['OVH_DATE'];
				$date_formatted = date("d/m/Y", strtotime($ovh_date));
				$result->setOvhDate($date_formatted);
				$result->setOvhId($row['ID']);
				$result->setOvhCode($row['OVH_CODE']);
				$result->setOvhValue((double) $row['OVH_VALUE']);
				$result->setOvhDesc($row['OVH_DESC']);
				$result->setStationId($row['STATION_ID']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its id : ".$e);
		}
		return $result;
	}


	public function findAll($ovh_start_date = NULL, $ovh_end_date = NULL, $pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT ID, OVH_CODE, OVH_DESC, OVH_VALUE, OVH_DATE, STATION_ID FROM OVERHEAD_COST WHERE 1=1";
			if (!empty ($ovh_start_date) && !empty($ovh_end_date)) {
				$q = "SELECT ID, OVH_CODE, OVH_DESC, OVH_VALUE, OVH_DATE, STATION_ID FROM OVERHEAD_COST WHERE OVH_DATE >= ?1 AND OVH_DATE <= ?2 ";
				$q_pr = array ("?1", "?2");
				$input_var = array ("'".$ovh_start_date."'", "'".$ovh_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY OVH_DATE DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new OverheadCost();
				$ovh_date = $row['OVH_DATE'];
				$date_formatted = date("d/m/Y", strtotime($ovh_date));
				$vo->setOvhDate($date_formatted);
				$vo->setOvhId($row['ID']);
				$vo->setOvhCode($row['OVH_CODE']);
				$vo->setOvhValue((double) $row['OVH_VALUE']);
				$vo->setOvhDesc($row['OVH_DESC']);
				$vo->setStationId($row['STATION_ID']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its id : ".$e);
		}
		return $results;
	}

	public function findTotalOverheadCost($ovh_start_date = NULL, $ovh_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT sum(OVH_VALUE) FROM OVERHEAD_COST WHERE 1=1";
			if (!empty ($ovh_start_date) && !empty($ovh_end_date)) {
				$q = "SELECT sum(OVH_VALUE) FROM OVERHEAD_COST WHERE OVH_DATE >= ?1 AND OVH_DATE <= ?2";

				$q_pr = array ("?1", "?2");
				$input_var = array ("'".$ovh_start_date."'", "'".$ovh_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
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
			die("Can't find Inventory by its id : ".$e);
		}
		return $result;
	}

	public function countAll($station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM OVERHEAD_COST";
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
			die("Can't find overhead costs : ".$e);
		}
		return $result;
	}

	public function update(OverheadCost $input) {
		$q = "UPDATE OVERHEAD_COST SET OVH_CODE = ?1, OVH_DESC = ?2, OVH_VALUE = ?3, OVH_DATE = ?4 WHERE ID = ?5";

		try {
			if (empty($input) || !$input->getOvhId()) {
				die("Invalid Overhead cost parameter or Overhead cost Id.");
			}
			$ovh_date = $input->getOvhDate();

			$q_pr = array ("?1", "?2", "?3", "?4", "?5");
			$input_var = array ("'".$input->getOvhCode()."'",
                                "'".$input->getOvhDesc()."'",
			$input->getOvhValue(),
                                "'".$ovh_date."'",
			$input->getOvhId());
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

	public function delete($ovh_id) {
		$q = "DELETE FROM OVERHEAD_COST WHERE ID = ?1";

		try {
			if (empty($ovh_id)) {
				die("Invalid Overhead cost Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($ovh_id);
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
		$q = "DELETE FROM OVERHEAD_COST";

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