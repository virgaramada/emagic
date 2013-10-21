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
require_once 'vo/Station.class.php';
require_once 'LogManager.class.php';

class StationManager {

	public function create(Station $input) {
		
		$insert_id = 0;
		try {


			$q = "INSERT INTO INV_MGT_STATION (STATION_ID, STATION_ADDRESS, LOCATION_CODE, STATION_STATUS) VALUES (?1, ?2, ?3, ?4)";
			$q_pr = array ("?1", "?2", "?3", "?4");
			$input_var = array ("'".$input->getStationId()."'",
			                    "'".$input->getStationAddress()."'",
			                    "'".$input->getLocationCode()."'",
			                    "'UNREGISTERED'");
			
			
			if (($input->getSupplyPointDistance()) && is_numeric($input->getSupplyPointDistance())) {

				$q = "INSERT INTO INV_MGT_STATION (STATION_ID, STATION_ADDRESS, LOCATION_CODE, SUPPLY_POINT_DISTANCE, STATION_STATUS) VALUES (?1, ?2, ?3, ?4, ?5)";
				$q_pr = array ("?1", "?2", "?3", "?4", "?5");
				$input_var = array ("'".$input->getStationId()."'",
			                    "'".$input->getStationAddress()."'",
			                    "'".$input->getLocationCode()."'",
				$input->getSupplyPointDistance(),
				"'UNREGISTERED'");
					
				if (($input->getMaxTolerance()) && is_numeric($input->getMaxTolerance())) {
					$q = "INSERT INTO INV_MGT_STATION (STATION_ID, STATION_ADDRESS, LOCATION_CODE, SUPPLY_POINT_DISTANCE, MAX_TOLERANCE, STATION_STATUS) VALUES (?1, ?2, ?3, ?4, ?5, ?6)";
					$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6");
					$input_var = array ("'".$input->getStationId()."'",
			                    "'".$input->getStationAddress()."'",
			                    "'".$input->getLocationCode()."'",
					$input->getSupplyPointDistance(),
					$input->getMaxTolerance(),
					"'UNREGISTERED'");
				}
			}
			$q = str_replace($q_pr, $input_var, $q);
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			$insert_id = $input->getStationId();
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while inserting data into database : ".$e);
		}
		return $insert_id;
	}

	public function findByPrimaryKey($station_id) {
		$result = NULL;
		try {
			if (empty($station_id)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid station id");
			}
			$q = "SELECT ID, STATION_ID, STATION_ADDRESS, LOCATION_CODE, SUPPLY_POINT_DISTANCE, MAX_TOLERANCE, STATION_STATUS FROM INV_MGT_STATION WHERE STATION_ID = ?1";
			$q = str_replace("?1", "'".$station_id."'", $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new Station();
				$result->setStationId($row['STATION_ID']);
				$result->setUniqueId($row['ID']);
				$result->setStationAddress($row['STATION_ADDRESS']);
				$result->setLocationCode($row['LOCATION_CODE']);
				$result->setStationStatus($row['STATION_STATUS']);
				$result->setSupplyPointDistance((double) $row['SUPPLY_POINT_DISTANCE']);
				$result->setMaxTolerance((double) $row['MAX_TOLERANCE']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Station by its id : ".$e);
		}
		return $result;
	}

	public function findByInventoryType($inv_type) {
		$results = NULL;
		try {
			if (empty($inv_type)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			$results = array();
			$q = "SELECT DISTINCT ID, STATION_ID, STATION_ADDRESS, LOCATION_CODE, SUPPLY_POINT_DISTANCE, MAX_TOLERANCE, STATION_STATUS FROM INV_MGT_STATION WHERE STATION_ID IN (";
				
			$q = $q . "SELECT DISTINCT STATION_ID FROM INV_MGT_OUTPUT WHERE INV_TYPE = ?1";
				
			$q = $q . ") AND STATION_STATUS = 'REGISTERED'";
			$q = str_replace("?1", "'".$inv_type."'", $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new Station();
				$vo->setStationId($row['STATION_ID']);
				$vo->setUniqueId($row['ID']);
				$vo->setStationAddress($row['STATION_ADDRESS']);
				$vo->setLocationCode($row['LOCATION_CODE']);
				$vo->setStationStatus($row['STATION_STATUS']);
				$vo->setSupplyPointDistance((double) $row['SUPPLY_POINT_DISTANCE']);
				$vo->setMaxTolerance((double) $row['MAX_TOLERANCE']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Station by its id : ".$e);
		}
		return $results;
	}
public function findByAllInventoryType() {
		$results = NULL;
		try {
			
			$results = array();
			$q = "SELECT DISTINCT ID, STATION_ID, STATION_ADDRESS, LOCATION_CODE, SUPPLY_POINT_DISTANCE, MAX_TOLERANCE, STATION_STATUS FROM INV_MGT_STATION WHERE STATION_ID IN (";
				
			$q = $q . "SELECT DISTINCT STATION_ID FROM INV_MGT_OUTPUT WHERE INV_TYPE IN (SELECT INV_TYPE FROM INV_MGT_TYPE)";
				
			$q = $q . ") AND STATION_STATUS = 'REGISTERED'";
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new Station();
				$vo->setStationId($row['STATION_ID']);
				$vo->setUniqueId($row['ID']);
				$vo->setStationAddress($row['STATION_ADDRESS']);
				$vo->setLocationCode($row['LOCATION_CODE']);
				$vo->setStationStatus($row['STATION_STATUS']);
				$vo->setSupplyPointDistance((double) $row['SUPPLY_POINT_DISTANCE']);
				$vo->setMaxTolerance((double) $row['MAX_TOLERANCE']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Station by its id : ".$e);
		}
		return $results;
	}
    public function findByDistributionLocation($dist_loc_code) {
		$results = NULL;
		try {
			if (empty($dist_loc_code)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid distribution location code");
			}
			$results = array();
			$q = "SELECT DISTINCT ID, STATION_ID, STATION_ADDRESS, LOCATION_CODE, SUPPLY_POINT_DISTANCE, MAX_TOLERANCE, STATION_STATUS FROM INV_MGT_STATION WHERE LOCATION_CODE = ?1 AND STATION_STATUS = 'REGISTERED'";
			
			$q = str_replace("?1", "'".$dist_loc_code."'", $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new Station();
				$vo->setStationId($row['STATION_ID']);
				$vo->setUniqueId($row['ID']);
				$vo->setStationAddress($row['STATION_ADDRESS']);
				$vo->setLocationCode($row['LOCATION_CODE']);
				$vo->setStationStatus($row['STATION_STATUS']);
				$vo->setSupplyPointDistance((double) $row['SUPPLY_POINT_DISTANCE']);
				$vo->setMaxTolerance((double) $row['MAX_TOLERANCE']);
				
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Station by its id : ".$e);
		}
		return $results;
	}
	public function findAll($pageIndex=NULL, $linePerPage=NULL) {
		$results = NULL;
		try {
			$results = array();
			$q = "SELECT ID, STATION_ID, STATION_ADDRESS, LOCATION_CODE, SUPPLY_POINT_DISTANCE, MAX_TOLERANCE, STATION_STATUS FROM INV_MGT_STATION WHERE STATION_STATUS = 'REGISTERED' ORDER BY STATION_ID DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new Station();
				$vo->setStationId($row['STATION_ID']);
				$vo->setUniqueId($row['ID']);
				$vo->setStationAddress($row['STATION_ADDRESS']);
				$vo->setLocationCode($row['LOCATION_CODE']);
				$vo->setStationStatus($row['STATION_STATUS']);
				$vo->setSupplyPointDistance((double) $row['SUPPLY_POINT_DISTANCE']);
				$vo->setMaxTolerance((double) $row['MAX_TOLERANCE']);
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
	public function findAllIgnoreStatus($pageIndex=NULL, $linePerPage=NULL) {
		$results = NULL;
		try {
			$results = array();
			$q = "SELECT ID, STATION_ID, STATION_ADDRESS, LOCATION_CODE, SUPPLY_POINT_DISTANCE, MAX_TOLERANCE, STATION_STATUS FROM INV_MGT_STATION ORDER BY STATION_ID DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new Station();
				$vo->setStationId($row['STATION_ID']);
				$vo->setUniqueId($row['ID']);
				$vo->setStationAddress($row['STATION_ADDRESS']);
				$vo->setLocationCode($row['LOCATION_CODE']);
				$vo->setSupplyPointDistance((double) $row['SUPPLY_POINT_DISTANCE']);
				$vo->setMaxTolerance((double) $row['MAX_TOLERANCE']);
				$vo->setStationStatus($row['STATION_STATUS']);
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

	public function countAll() {
		$result = NULL;
		try {

			$q = "SELECT COUNT(STATION_ID) FROM INV_MGT_STATION WHERE STATION_STATUS = 'REGISTERED'";
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
			die("Can't count All Stations : ".$e);
		}
		return $result;
	}
	public function countAllIgnoreStatus() {
		$result = NULL;
		try {

			$q = "SELECT COUNT(STATION_ID) FROM INV_MGT_STATION";
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
			die("Can't count All Stations : ".$e);
		}
		return $result;
	}

	public function update(Station $input, $original_station_id=NULL) {
		
		
		
		$q = "UPDATE INV_MGT_STATION SET STATION_ADDRESS = ?1, LOCATION_CODE = ?2 WHERE STATION_ID = ?3";

		try {
			if (!$input->getStationId()) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid station id");
			}
			
			$q_pr = array ("?1", "?2", "?3");
			$input_var = array ("'".$input->getStationAddress()."'",
			                    "'".$input->getLocationCode()."'",
                                "'".$input->getStationId()."'");
			
			$q = str_replace($q_pr, $input_var, $q);
			if (!empty($original_station_id)) {
				$q = "UPDATE INV_MGT_STATION SET STATION_ID = ?1, STATION_ADDRESS = ?2, LOCATION_CODE = ?3 WHERE STATION_ID = ?4";
				
				
				
				$q_pr = array ("?1", "?2", "?3", "?4");
			    $input_var = array ("'".$input->getStationId()."'",
			                       "'".$input->getStationAddress()."'",
			                       "'".$input->getLocationCode()."'",
			                       "'".$original_station_id."'");
			}
			
		if (($input->getSupplyPointDistance()) && is_numeric($input->getSupplyPointDistance())) {

				$q = "UPDATE INV_MGT_STATION SET STATION_ADDRESS = ?1, LOCATION_CODE = ?2, SUPPLY_POINT_DISTANCE = ?3 WHERE STATION_ID = ?4";
				$q_pr = array ("?1", "?2", "?3", "?4");
				$input_var = array ("'".$input->getStationAddress()."'",
			                        "'".$input->getLocationCode()."'",
				                        $input->getSupplyPointDistance(),
				                    "'".$input->getStationId()."'");
				$q = str_replace($q_pr, $input_var, $q);	


				  if (!empty($original_station_id)) {
				      $q = "UPDATE INV_MGT_STATION SET STATION_ID = ?1, STATION_ADDRESS = ?2, LOCATION_CODE = ?3, SUPPLY_POINT_DISTANCE = ?4 WHERE STATION_ID = ?5";
				      $q_pr = array ("?1", "?2", "?3", "?4", "?5");
				      $input_var = array ("'".$input->getStationId()."'",
                                          "'".$input->getStationAddress()."'",
                                          "'".$input->getLocationCode()."'",
				                        	$input->getSupplyPointDistance(),
                                          "'".$original_station_id."'");
				     $q = str_replace($q_pr, $input_var, $q);                   	
				  }
					
				if (($input->getMaxTolerance()) && is_numeric($input->getMaxTolerance())) {
					$q = "UPDATE INV_MGT_STATION SET STATION_ADDRESS = ?1, LOCATION_CODE = ?2, SUPPLY_POINT_DISTANCE = ?3, MAX_TOLERANCE = ?4 WHERE STATION_ID = ?5";
					
					$q_pr = array ("?1", "?2", "?3", "?4", "?5");
					$input_var = array (
			                    "'".$input->getStationAddress()."'",
			                    "'".$input->getLocationCode()."'",
					                $input->getSupplyPointDistance(),
					                $input->getMaxTolerance(),
					            "'".$input->getStationId()."'");

					$q = str_replace($q_pr, $input_var, $q);                
				 if (!empty($original_station_id)) {
				      $q = "UPDATE INV_MGT_STATION SET STATION_ID = ?1, STATION_ADDRESS = ?2, LOCATION_CODE = ?3, SUPPLY_POINT_DISTANCE = ?4, MAX_TOLERANCE = ?5 WHERE STATION_ID = ?6";
				      $q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6");
				      $input_var = array ("'".$input->getStationId()."'",
                                          "'".$input->getStationAddress()."'",
                                          "'".$input->getLocationCode()."'",
				                        	  $input->getSupplyPointDistance(),
				                        	  $input->getMaxTolerance(),
                                          "'".$original_station_id."'");
				      $q = str_replace($q_pr, $input_var, $q);                  	  
				  }                
				}
			}
			
			
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			
		   if (!empty($original_station_id)) {
				$mq = "UPDATE INV_MGT_MARGIN SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				$uq = "UPDATE INV_MGT_USER_ROLE SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				$oq = "UPDATE INV_MGT_OUTPUT SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				$tq = "UPDATE INV_MGT_TANK_CAPACITY SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				$drq = "UPDATE INV_MGT_DELIVERY_REALISATION SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				$ocq = "UPDATE OVERHEAD_COST SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				$ipq = "UPDATE INV_MGT_PRICE SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				$wiq = "UPDATE WORK_IN_CAPITAL SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				$sq = "UPDATE INV_MGT_SUPPLY SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				$soq = "UPDATE INV_MGT_SALES_ORDER SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				$dpq = "UPDATE INV_MGT_DELIVERY_PLAN SET STATION_ID = '".$input->getStationId()."' WHERE STATION_ID = '".$original_station_id."'";
				
				mysql_query($mq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query($uq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query($oq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query($tq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query($drq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query($ocq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query($ipq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query($wiq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query($sq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query($soq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query($dpq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
				mysql_query("COMMIT");
			}
			

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while updating data in database : ".$e);
		}
	}

	public function delete($station_id) {
		$mq = "DELETE FROM INV_MGT_MARGIN WHERE STATION_ID = ?1";
		$uq = "DELETE FROM INV_MGT_USER_ROLE WHERE STATION_ID = ?1";
		$oq = "DELETE FROM INV_MGT_OUTPUT WHERE STATION_ID = ?1";
		$tq = "DELETE FROM INV_MGT_TANK_CAPACITY WHERE STATION_ID = ?1";
		$drq = "DELETE FROM INV_MGT_DELIVERY_REALISATION WHERE STATION_ID = ?1";
		$ocq = "DELETE FROM OVERHEAD_COST WHERE STATION_ID = ?1";
		$ipq = "DELETE FROM INV_MGT_PRICE WHERE STATION_ID = ?1";
		$wiq = "DELETE FROM WORK_IN_CAPITAL WHERE STATION_ID = ?1";
		$sq = "DELETE FROM INV_MGT_SUPPLY WHERE STATION_ID = ?1";
		$soq = "DELETE FROM INV_MGT_SALES_ORDER WHERE STATION_ID = ?1";
		$dpq = "DELETE FROM INV_MGT_DELIVERY_PLAN WHERE STATION_ID = ?1";
		
		$q = "DELETE FROM INV_MGT_STATION WHERE STATION_ID = ?1";

		try {
			if (empty($station_id)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid station id");
			}

			$q_pr = array ("?1");
			$input_var = array ("'".$station_id."'");
			
			$mq = str_replace($q_pr, $input_var, $mq);
			$uq = str_replace($q_pr, $input_var, $uq);
			$oq = str_replace($q_pr, $input_var, $oq);
			$tq = str_replace($q_pr, $input_var, $tq);
			$drq = str_replace($q_pr, $input_var, $drq);
			$ocq = str_replace($q_pr, $input_var, $ocq);
			$ipq = str_replace($q_pr, $input_var, $ipq);
			$wiq = str_replace($q_pr, $input_var, $wiq);
			$sq = str_replace($q_pr, $input_var, $sq);
			$soq = str_replace($q_pr, $input_var, $soq);
			$dpq = str_replace($q_pr, $input_var, $dpq);
			
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($mq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($uq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($oq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($tq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($drq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($ocq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($ipq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($wiq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($sq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($soq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query($dpq) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			
			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}

	/**public function deleteAll() {
		$q = "DELETE FROM INV_MGT_STATION";

		try {
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}*/
	public function activateStation($station_id=NULL) {
		if (empty($station_id)) {
			die("Station id must be specified");
		}

		try {

			$by_id = self::findByPrimaryKey($station_id);
			if (empty($by_id)) {
				die("Station not found");
			}
				

			$q = "UPDATE INV_MGT_STATION SET STATION_STATUS = ?1 WHERE STATION_ID = ?2";

			$q_pr = array ("?1", "?2");
			$input_var = array ("'REGISTERED'", "'".$station_id."'");
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
    public function passivateStation($station_id=NULL) {
		if (empty($station_id)) {
			die("Station id must be specified");
		}

		try {

			$by_id = self::findByPrimaryKey($station_id);
			if (empty($by_id)) {
				die("Station not found");
			}

			$q = "UPDATE INV_MGT_STATION SET STATION_STATUS = ?1 WHERE STATION_ID = ?2";

			$q_pr = array ("?1", "?2");
			$input_var = array ("'UNREGISTERED'", "'".$station_id."'");
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
}
?>