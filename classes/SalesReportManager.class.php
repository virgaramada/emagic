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
require_once 'LogManager.class.php';
class SalesReportManager {

	public function calculateAllSales($output_start_date, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT "
			. "WHERE OUTPUT_DATE = ?1 AND CATEGORY = 'SALES'";
			$q = str_replace("?1", "'".$output_start_date."'", $q);

			if (!empty($output_end_date)) {
				$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT "
				. "WHERE OUTPUT_DATE >= ?1 AND OUTPUT_DATE <= ?2 AND CATEGORY = 'SALES'";

				$q_pr = array ("?1", "?2");
				$input_var = array ("'".$output_start_date."'", "'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);

			if ($row) {
				$result =  $row['SUM_SALES'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't calculate inventory output : ".$e);
		}
		return $result;
	}

	public function calculateAllOwnUseSales($output_start_date, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT "
			. "WHERE OUTPUT_DATE = ?1 AND CATEGORY = 'OWN_USE'";
			$q = str_replace("?1", "'".$output_start_date."'", $q);

			if (!empty($output_end_date)) {
				$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT "
				. "WHERE OUTPUT_DATE >= ?1 AND OUTPUT_DATE <= ?2 AND CATEGORY = 'OWN_USE'";

				$q_pr = array ("?1", "?2");
				$input_var = array ("'".$output_start_date."'", "'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);

			if ($row) {
				$result =  $row['SUM_SALES'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't calculate inventory output : ".$e);
		}
		return $result;
	}

	public function calculateAllLosses($output_start_date, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT "
			. "WHERE OUTPUT_DATE = ?1 AND CATEGORY = 'LOSS'";
			$q = str_replace("?1", "'".$output_start_date."'", $q);

			if (!empty($output_end_date)) {
				$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT "
				. "WHERE OUTPUT_DATE >= ?1 AND OUTPUT_DATE <= ?2 AND CATEGORY = 'LOSS'";

				$q_pr = array ("?1", "?2");
				$input_var = array ("'".$output_start_date."'", "'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);

			if ($row) {
				$result =  $row['SUM_SALES'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't calculate inventory output : ".$e);
		}
		return $result;
	}
	public function calculateSalesByInventoryType($inventory_type, $output_start_date, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT WHERE INV_TYPE = ?1 AND OUTPUT_DATE = ?2 "
			."AND CATEGORY = 'SALES'";
			$q_pr = array ("?1", "?2");
			$input_var = array ("'".$inventory_type."'", "'".$output_start_date."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty($output_end_date)) {
				$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT "
				. "WHERE INV_TYPE = ?1 AND OUTPUT_DATE >= ?2 AND OUTPUT_DATE <= ?3 AND CATEGORY = 'SALES'";

				$q_pr = array ("?1", "?2", "?3");
				$input_var = array ("'".$inventory_type."'", "'".$output_start_date."'", "'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);

			if ($row) {
				$result = $row['SUM_SALES'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't calculate inventory output : ".$e);
		}
		return $result;
	}
	public function calculateOwnUseSalesByInventoryType($inventory_type, $output_start_date, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT WHERE INV_TYPE = ?1 AND OUTPUT_DATE = ?2 "
			."AND CATEGORY = 'OWN_USE'";
			$q_pr = array ("?1", "?2");
			$input_var = array ("'".$inventory_type."'", "'".$output_start_date."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty($output_end_date)) {
				$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT "
				. "WHERE INV_TYPE = ?1 AND OUTPUT_DATE >= ?2 AND OUTPUT_DATE <= ?3 AND CATEGORY = 'OWN_USE'";

				$q_pr = array ("?1", "?2", "?3");
				$input_var = array ("'".$inventory_type."'", "'".$output_start_date."'", "'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);

			if ($row) {
				$result = $row['SUM_SALES'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't calculate inventory output : ".$e);
		}
		return $result;
	}

	public function calculateLossesByInventoryType($inventory_type, $output_start_date, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT WHERE INV_TYPE = ?1 AND OUTPUT_DATE = ?2 "
			."AND CATEGORY = 'LOSS'";
			$q_pr = array ("?1", "?2");
			$input_var = array ("'".$inventory_type."'", "'".$output_start_date."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty($output_end_date)) {
				$q = "SELECT TRUNCATE(sum(OUTPUT_VALUE * UNIT_PRICE), 2) as SUM_SALES FROM INV_MGT_OUTPUT "
				. "WHERE INV_TYPE = ?1 AND OUTPUT_DATE >= ?2 AND OUTPUT_DATE <= ?3 AND CATEGORY = 'LOSS'";

				$q_pr = array ("?1", "?2", "?3");
				$input_var = array ("'".$inventory_type."'", "'".$output_start_date."'", "'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);

			if ($row) {
				$result = $row['SUM_SALES'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't calculate inventory output : ".$e);
		}
		return $result;
	}
}
?>