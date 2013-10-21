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
require_once 'vo/DistributionLocation.class.php';
require_once 'LogManager.class.php';
class DistributionLocationManager {

	public function create(DistributionLocation $input) {
		$q = "INSERT INTO INV_MGT_DIST_LOCATION (LOCATION_CODE, LOCATION_NAME, SUPPLY_POINT, SALES_AREA_MANAGER) VALUES (?1, ?2, ?3, ?4)";
		$insert_id = 0;
		try {

			$q_pr = array ("?1", "?2", "?3", "?4");
			$input_var = array ("'".$input->getLocationCode()."'",
			                    "'".$input->getLocationName()."'",
			                    "'".$input->getSupplyPoint()."'",
			                    "'".$input->getSalesAreaManager()."'");
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

	public function findByPrimaryKey($location_id) {
		$result = NULL;
		try {
			if (empty($location_id)) {
				die("Invalid Dist Location Id.");
			}
			$q = "SELECT ID, LOCATION_CODE, LOCATION_NAME, SUPPLY_POINT, SALES_AREA_MANAGER FROM INV_MGT_DIST_LOCATION WHERE ID = ?1";
			$q = str_replace("?1", $location_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new DistributionLocation();
				$result->setLocationId($row['ID']);
				$result->setLocationCode($row['LOCATION_CODE']);
				$result->setLocationName($row['LOCATION_NAME']);
				$result->setSupplyPoint($row['SUPPLY_POINT']);
				$result->setSalesAreaManager($row['SALES_AREA_MANAGER']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Location by its id : ".$e);
		}
		return $result;
	}
	public function findByCode($location_code) {
		$result = NULL;
		try {
			if (empty($location_code)) {
				die("Invalid Dist Location Code.");
			}
			$q = "SELECT ID, LOCATION_CODE, LOCATION_NAME, SUPPLY_POINT, SALES_AREA_MANAGER FROM INV_MGT_DIST_LOCATION WHERE LOCATION_CODE = ?1";
			$q = str_replace("?1", "'".$location_code."'", $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new DistributionLocation();
				$result->setLocationId($row['ID']);
				$result->setLocationCode($row['LOCATION_CODE']);
				$result->setLocationName($row['LOCATION_NAME']);
				$result->setSupplyPoint($row['SUPPLY_POINT']);
				$result->setSalesAreaManager($row['SALES_AREA_MANAGER']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Location by its id : ".$e);
		}
		return $result;
	}

	
	public function findAll($pageIndex=NULL, $linePerPage=NULL) {
		$results = NULL;
		try {
			$results = array();
			$q = "SELECT ID, LOCATION_CODE, LOCATION_NAME, SUPPLY_POINT, SALES_AREA_MANAGER FROM INV_MGT_DIST_LOCATION ORDER BY ID";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new DistributionLocation();
				$vo->setLocationId($row['ID']);
				$vo->setLocationCode($row['LOCATION_CODE']);
				$vo->setLocationName($row['LOCATION_NAME']);
				$vo->setSupplyPoint($row['SUPPLY_POINT']);
				$vo->setSalesAreaManager($row['SALES_AREA_MANAGER']);
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


	public function update(DistributionLocation $input) {
		$q = "UPDATE INV_MGT_DIST_LOCATION SET LOCATION_CODE = ?1, LOCATION_NAME = ?2, SUPPLY_POINT = ?3, SALES_AREA_MANAGER = ?4 WHERE ID = ?5";

		try {
			if (!$input->getLocationId()) {
				die("Invalid Location Id.");
			}

			$q_pr = array ("?1", "?2", "?3", "?4", "?5");
			$input_var = array ("'".$input->getLocationCode()."'",
                                "'".$input->getLocationName()."'",
			                    "'".$input->getSupplyPoint()."'",
			 "'".$input->getSalesAreaManager()."'",
			$input->getLocationId());
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

	public function delete($location_id) {
		$q = "DELETE FROM INV_MGT_DIST_LOCATION WHERE ID = ?1";

		try {
			if (empty($location_id)) {
				die("Invalid Location Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($location_id);
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
		$q = "DELETE FROM INV_MGT_DIST_LOCATION";

		try {
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}
    public function countAll() {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_DIST_LOCATION";

			
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
			die("Can't find All Distribution location : ".$e);
		}
		return $result;
	}

}
?>