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
require_once 'vo/InventoryOutput.class.php';
require_once 'vo/Station.class.php';
require_once 'vo/InventoryType.class.php';
require_once 'vo/DistributionLocation.class.php';
require_once 'LogManager.class.php';
class InventoryOutputManager {


	public function create(InventoryOutput $input) {
		$q = "INSERT INTO INV_MGT_OUTPUT (INV_TYPE, CUSTOMER_TYPE, OUTPUT_VALUE, OUTPUT_DATE, UNIT_PRICE, CATEGORY, BEGIN_STAND_METER,"
		    ."   END_STAND_METER, VEHICLE_TYPE, TERA_VALUE, PUMP_ID, NOZZLE_ID, OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT) "
		    ."  VALUES (?1, ?2, ?3, ?4, ?5, ?6, ?7, ?8, ?9, ?0, ?A, ?B, ?C, ?D, ?E)";
		$insert_id = 0;
		try {
			if (empty($input)) {
				die("Invalid InventoryOutput parameter.");
			}
			

			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6", "?7", "?8", "?9", "?0", "?A", "?B", "?C", "?D", "?E");
			$input_var = array ("'".$input->getInvType()."'",
                                "'".$input->getCustomerType()."'",
								$input->getOutputValue(),
					            "'".$input->getOutputDate()."'",
								$input->getUnitPrice(),
					            "'".$input->getCategory()."'",
								$input->getBeginStandMeter(),
								$input->getEndStandMeter(),
                                "'".$input->getVehicleType()."'",
			                    $input->getTeraValue(),
                                "'".$input->getPumpId()."'",
                                "'".$input->getNozzleId()."'",
                                "'".$input->getOutputTime()."'",
                                "'".$input->getStationId()."'",
			                    "'".$input->getOutputTimeShift()."'"
			                    );
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
			if (empty($inv_id)) {
				die("Invalid inventory output Id.");
			}
			$q = "SELECT ID, INV_TYPE, CUSTOMER_TYPE, OUTPUT_DATE, OUTPUT_VALUE, UNIT_PRICE, CATEGORY, BEGIN_STAND_METER, END_STAND_METER, "
			." VEHICLE_TYPE, TERA_VALUE, PUMP_ID, NOZZLE_ID, OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT "
			." FROM INV_MGT_OUTPUT WHERE ID = ?1 ";
			$q = str_replace("?1", $inv_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new InventoryOutput();
				$result->setInvId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setOutputValue((double) $row['OUTPUT_VALUE']);
				$supply_date = $row['OUTPUT_DATE'];
				$date_formatted = date("d/m/Y", strtotime($supply_date));
				$result->setOutputDate($date_formatted);
				$result->setCustomerType($row['CUSTOMER_TYPE']);
				$result->setUnitPrice((double) $row['UNIT_PRICE']);
				$result->setCategory($row['CATEGORY']);
				$result->setBeginStandMeter((double) $row['BEGIN_STAND_METER']);
				$result->setEndStandMeter((double) $row['END_STAND_METER']);
				$result->setVehicleType($row['VEHICLE_TYPE']);
				$result->setTeraValue((double) $row['TERA_VALUE']);
				$result->setPumpId($row['PUMP_ID']);
				$result->setNozzleId($row['NOZZLE_ID']);
				$result->setOutputTime($row['OUTPUT_TIME']);
				$result->setStationId($row['STATION_ID']);
				$result->setOutputTimeShift($row['OUTPUT_TIME_SHIFT']);

			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its id : ".$e);
		}
		return $result;
	}
	public function findByInventoryTypeAndDate($inv_type, $output_start_date= NULL, $output_end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($inv_type)) {
				die("Invalid Inventory type.");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, CUSTOMER_TYPE, OUTPUT_DATE, OUTPUT_VALUE, UNIT_PRICE, CATEGORY, BEGIN_STAND_METER, END_STAND_METER, "
			." VEHICLE_TYPE, TERA_VALUE, PUMP_ID, NOZZLE_ID, OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT FROM INV_MGT_OUTPUT "
			." WHERE INV_TYPE = ?1 ";

			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);


			if (!empty ($output_start_date)) {
				$q = $q." AND OUTPUT_DATE >= ?2";
				$q_pr = array ("?2");
				$input_var = array ("'".$output_start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($output_end_date)) {
				$q = $q." AND OUTPUT_DATE <= ?3 ";
				$q_pr = array ("?3");
				$input_var = array ("'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			$q = $q." AND CATEGORY = 'SALES'";
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY OUTPUT_DATE DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryOutput();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setOutputValue((double) $row['OUTPUT_VALUE']);
				$supply_date = $row['OUTPUT_DATE'];
				$date_formatted = date("d/m/Y", strtotime($supply_date));
				$vo->setOutputDate($date_formatted);
				$vo->setCustomerType($row['CUSTOMER_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setBeginStandMeter((double) $row['BEGIN_STAND_METER']);
				$vo->setEndStandMeter((double) $row['END_STAND_METER']);
				$vo->setVehicleType($row['VEHICLE_TYPE']);
				$vo->setTeraValue((double) $row['TERA_VALUE']);
				$vo->setPumpId($row['PUMP_ID']);
				$vo->setNozzleId($row['NOZZLE_ID']);
				$vo->setOutputTime($row['OUTPUT_TIME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOutputTimeShift($row['OUTPUT_TIME_SHIFT']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its type and output date : ".$e);
		}
		return $results;
	}
	public function findByAllInventoryTypeAndDate($output_start_date= NULL, $output_end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
				
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, CUSTOMER_TYPE, OUTPUT_DATE, OUTPUT_VALUE, UNIT_PRICE, CATEGORY, BEGIN_STAND_METER, "
			." END_STAND_METER, VEHICLE_TYPE, TERA_VALUE, PUMP_ID, NOZZLE_ID, OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT FROM INV_MGT_OUTPUT "
			." WHERE INV_TYPE IN (SELECT INV_TYPE FROM INV_MGT_TYPE)";

				


			if (!empty ($output_start_date)) {
				$q = $q." AND OUTPUT_DATE >= ?2";
				$q_pr = array ("?2");
				$input_var = array ("'".$output_start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($output_end_date)) {
				$q = $q." AND OUTPUT_DATE <= ?3 ";
				$q_pr = array ("?3");
				$input_var = array ("'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			$q = $q." AND CATEGORY = 'SALES'";
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY OUTPUT_DATE DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryOutput();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setOutputValue((double) $row['OUTPUT_VALUE']);
				$supply_date = $row['OUTPUT_DATE'];
				$date_formatted = date("d/m/Y", strtotime($supply_date));
				$vo->setOutputDate($date_formatted);
				$vo->setCustomerType($row['CUSTOMER_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setBeginStandMeter((double) $row['BEGIN_STAND_METER']);
				$vo->setEndStandMeter((double) $row['END_STAND_METER']);
				$vo->setVehicleType($row['VEHICLE_TYPE']);
				$vo->setTeraValue((double) $row['TERA_VALUE']);
				$vo->setPumpId($row['PUMP_ID']);
				$vo->setNozzleId($row['NOZZLE_ID']);
				$vo->setOutputTime($row['OUTPUT_TIME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOutputTimeShift($row['OUTPUT_TIME_SHIFT']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its type and output date : ".$e);
		}
		return $results;
	}
	public function findTotalOutputByInventoryTypeAndDate($inv_type, $output_start_date= NULL, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			$q = "SELECT sum(OUTPUT_VALUE) as TOTAL_OUTPUT_VALUE FROM INV_MGT_OUTPUT "
			." WHERE INV_TYPE = ?1 ";


			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty($output_start_date)) {
				$q = $q." AND OUTPUT_DATE >= ?2";
				$q_pr = array ("?2");
				$input_var = array ("'".$output_start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($output_end_date)) {
				$q = $q." AND OUTPUT_DATE <= ?3 ";
				$q_pr = array ("?3");
				$input_var = array ("'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			$q = $q." AND CATEGORY = 'SALES'";
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}

			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = $row['TOTAL_OUTPUT_VALUE'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Output by its inventory type and date : ".$e);
		}
		return $result;
	}

	
public function findLastOutputDateByInventoryType($inv_type, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			$q = "SELECT CONCAT(OUTPUT_DATE, ' ' , OUTPUT_TIME, ':00') AS O_DATE FROM INV_MGT_OUTPUT "
			." WHERE INV_TYPE = ?1 ";


			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			
			$q = $q." AND CATEGORY = 'SALES'";
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
            $q = $q." ORDER BY O_DATE DESC";
			$q = $q." LIMIT 0,1";
			//LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = $row['O_DATE'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Output by its inventory type and date : ".$e);
		}
		return $result;
	}
	public function findTotalOwnUseOutputByInventoryTypeAndDate($inv_type, $output_start_date= NULL, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($inv_type)) {
				die("Invalid Inventory type.");
			}
			$q = "SELECT sum(OUTPUT_VALUE) as TOTAL_OUTPUT_VALUE FROM INV_MGT_OUTPUT WHERE INV_TYPE = ?1 ";

			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($output_start_date)) {
				$q = $q." AND OUTPUT_DATE >= ?2";
				$q_pr = array ("?2");
				$input_var = array ("'".$output_start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($output_end_date)) {
				$q = $q." AND OUTPUT_DATE <= ?3 ";
				$q_pr = array ("?3");
				$input_var = array ("'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			$q = $q." AND CATEGORY = 'OWN_USE'";
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}

			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = $row['TOTAL_OUTPUT_VALUE'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Own use output by inventory type and date : ".$e);
		}
		return $result;
	}

	public function findTotalLossesOutputByInventoryTypeAndDate($inv_type, $output_start_date= NULL, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($inv_type)) {
				die("Invalid Inventory type.");
			}
			$q = "SELECT sum(OUTPUT_VALUE) as TOTAL_OUTPUT_VALUE FROM INV_MGT_OUTPUT WHERE INV_TYPE = ?1 ";

			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($output_start_date)) {
				$q = $q." AND OUTPUT_DATE >= ?2";
				$q_pr = array ("?2");
				$input_var = array ("'".$output_start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($output_end_date)) {
				$q = $q." AND OUTPUT_DATE <= ?3 ";
				$q_pr = array ("?3");
				$input_var = array ("'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			$q = $q." AND CATEGORY = 'LOSS'";
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = $row['TOTAL_OUTPUT_VALUE'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Own use output by inventory type and date : ".$e);
		}
		return $result;
	}

	public function findOwnUseByInventoryTypeAndDate($inv_type, $output_start_date= NULL, $output_end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($inv_type)) {
				die("Invalid Inventory type.");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, CUSTOMER_TYPE, OUTPUT_DATE, OUTPUT_VALUE, UNIT_PRICE, CATEGORY, "
			. " BEGIN_STAND_METER, END_STAND_METER, VEHICLE_TYPE, TERA_VALUE, PUMP_ID, NOZZLE_ID, OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT "
			."  FROM INV_MGT_OUTPUT WHERE INV_TYPE = ?1 ";

			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($output_start_date)) {
				$q = $q." AND OUTPUT_DATE >= ?2";
				$q_pr = array ("?2");
				$input_var = array ("'".$output_start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($output_end_date)) {
				$q = $q." AND OUTPUT_DATE <= ?3 ";
				$q_pr = array ("?3");
				$input_var = array ("'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			$q = $q." AND CATEGORY = 'OWN_USE' ";

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY OUTPUT_DATE DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryOutput();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setOutputValue((double) $row['OUTPUT_VALUE']);
				$supply_date = $row['OUTPUT_DATE'];
				$date_formatted = date("d/m/Y", strtotime($supply_date));
				$vo->setOutputDate($date_formatted);
				$vo->setCustomerType($row['CUSTOMER_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setBeginStandMeter((double) $row['BEGIN_STAND_METER']);
				$vo->setEndStandMeter((double) $row['END_STAND_METER']);
				$vo->setVehicleType($row['VEHICLE_TYPE']);
				$vo->setTeraValue((double) $row['TERA_VALUE']);
				$vo->setPumpId($row['PUMP_ID']);
				$vo->setNozzleId($row['NOZZLE_ID']);
				$vo->setOutputTime($row['OUTPUT_TIME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOutputTimeShift($row['OUTPUT_TIME_SHIFT']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its type and output date : ".$e);
		}
		return $results;
	}

	public function findLossesByInventoryTypeAndDate($inv_type, $output_start_date = NULL, $output_end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($inv_type)) {
				die("Invalid Inventory type.");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, CUSTOMER_TYPE, OUTPUT_DATE, OUTPUT_VALUE, UNIT_PRICE, CATEGORY, "
			. " BEGIN_STAND_METER, END_STAND_METER, VEHICLE_TYPE, TERA_VALUE, PUMP_ID, NOZZLE_ID, OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT "
			." FROM INV_MGT_OUTPUT WHERE INV_TYPE = ?1 ";

			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($output_start_date)) {
				$q = $q." AND OUTPUT_DATE >= ?2";
				$q_pr = array ("?2");
				$input_var = array ("'".$output_start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($output_end_date)) {
				$q = $q." AND OUTPUT_DATE <= ?3 ";
				$q_pr = array ("?3");
				$input_var = array ("'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			$q = $q." AND CATEGORY = 'LOSS' ";

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY OUTPUT_DATE DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryOutput();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setOutputValue((double) $row['OUTPUT_VALUE']);
				$supply_date = $row['OUTPUT_DATE'];
				$date_formatted = date("d/m/Y", strtotime($supply_date));
				$vo->setOutputDate($date_formatted);
				$vo->setCustomerType($row['CUSTOMER_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setBeginStandMeter((double) $row['BEGIN_STAND_METER']);
				$vo->setEndStandMeter((double) $row['END_STAND_METER']);
				$vo->setVehicleType($row['VEHICLE_TYPE']);
				$vo->setTeraValue((double) $row['TERA_VALUE']);
				$vo->setPumpId($row['PUMP_ID']);
				$vo->setNozzleId($row['NOZZLE_ID']);
				$vo->setOutputTime($row['OUTPUT_TIME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOutputTimeShift($row['OUTPUT_TIME_SHIFT']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its type and output date : ".$e);
		}
		return $results;
	}

	public function findByCustomerTypeAndDate($customer_type, $output_start_date, $output_end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($customer_type) || empty($output_start_date)) {
				die("Invalid Customer type or output start date.");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, CUSTOMER_TYPE, OUTPUT_DATE, OUTPUT_VALUE, UNIT_PRICE, CATEGORY, BEGIN_STAND_METER, END_STAND_METER, VEHICLE_TYPE, "
			." TERA_VALUE, PUMP_ID, NOZZLE_ID, OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT FROM INV_MGT_OUTPUT "
			." WHERE CUSTOMER_TYPE = ?1 AND OUTPUT_DATE = ?2 ";

			$q_pr = array ("?1", "?2");
			$input_var = array ("'".$customer_type."'", "'".$output_start_date."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($output_end_date)) {
				$q = "SELECT  ID, INV_TYPE, CUSTOMER_TYPE, OUTPUT_DATE, OUTPUT_VALUE, UNIT_PRICE, CATEGORY, BEGIN_STAND_METER, END_STAND_METER, VEHICLE_TYPE, "
				." TERA_VALUE, PUMP_ID, NOZZLE_ID, OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT FROM INV_MGT_OUTPUT "
				." WHERE CUSTOMER_TYPE = ?1 AND OUTPUT_DATE >= ?2 AND OUTPUT_DATE <= ?3 ";
				$q_pr = array ("?1", "?2", "?3");
				$input_var = array ("'".$customer_type."'", "'".$output_start_date."'", "'".$output_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY OUTPUT_DATE DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryOutput();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setOutputValue((double) $row['OUTPUT_VALUE']);
				$supply_date = $row['OUTPUT_DATE'];
				$date_formatted = date("d/m/Y", strtotime($supply_date));
				$vo->setOutputDate($date_formatted);
				$vo->setCustomerType($row['CUSTOMER_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setBeginStandMeter((double) $row['BEGIN_STAND_METER']);
				$vo->setEndStandMeter((double) $row['END_STAND_METER']);
				$vo->setVehicleType($row['VEHICLE_TYPE']);
				$vo->setTeraValue((double) $row['TERA_VALUE']);
				$vo->setPumpId($row['PUMP_ID']);
				$vo->setNozzleId($row['NOZZLE_ID']);
				$vo->setOutputTime($row['OUTPUT_TIME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOutputTimeShift($row['OUTPUT_TIME_SHIFT']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by customer type and output date : ".$e);
		}
		return $results;
	}
	public function findAllOwnUseOutput($output_start_date, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($output_start_date)) {
				die("Invalid output start date.");
			}
			$q = "SELECT sum(OUTPUT_VALUE) as SUM_OUTPUT_VALUE FROM INV_MGT_OUTPUT "
			." WHERE OUTPUT_DATE = ?1 AND CATEGORY = 'OWN_USE'";
			$q = str_replace("?1", "'".$output_start_date."'", $q);
			if (!empty ($output_end_date)) {
				$q = "SELECT sum(OUTPUT_VALUE) as SUM_OUTPUT_VALUE FROM INV_MGT_OUTPUT "
				." WHERE OUTPUT_DATE >= ?1 AND OUTPUT_DATE <= ?2 AND CATEGORY = 'OWN_USE'";
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
				$result = $row['SUM_OUTPUT_VALUE'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't calculate inventory output : ".$e);
		}
		return $result;
	}
	public function findAllLossesOutput($output_start_date, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($output_start_date)) {
				die("Invalid output start date.");
			}
			$q = "SELECT sum(OUTPUT_VALUE) as SUM_OUTPUT_VALUE FROM INV_MGT_OUTPUT "
			." WHERE OUTPUT_DATE = ?1 AND CATEGORY = 'LOSS'";
			$q = str_replace("?1", "'".$output_start_date."'", $q);
			if (!empty ($output_end_date)) {
				$q = "SELECT sum(OUTPUT_VALUE) as SUM_OUTPUT_VALUE FROM INV_MGT_OUTPUT "
				." WHERE OUTPUT_DATE >= ?1 AND OUTPUT_DATE <= ?2 AND CATEGORY = 'LOSS'";
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
				$result = $row['SUM_OUTPUT_VALUE'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't calculate inventory output : ".$e);
		}
		return $result;
	}
	public function findAll($product_type=NULL, $pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, CUSTOMER_TYPE, OUTPUT_DATE, OUTPUT_VALUE, UNIT_PRICE, CATEGORY, BEGIN_STAND_METER, "
			   . "END_STAND_METER, VEHICLE_TYPE, TERA_VALUE, PUMP_ID, NOZZLE_ID, OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT FROM INV_MGT_OUTPUT WHERE 1=1";
			if (!empty ($product_type)) {
				$q = "SELECT DISTINCT ID, INV_TYPE, CUSTOMER_TYPE, OUTPUT_DATE, OUTPUT_VALUE, UNIT_PRICE, CATEGORY, BEGIN_STAND_METER,"
				. " END_STAND_METER, VEHICLE_TYPE, TERA_VALUE, PUMP_ID, NOZZLE_ID, OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT FROM INV_MGT_OUTPUT "
				." WHERE INV_TYPE IN (SELECT INV_TYPE "
				." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1) ";
				$q = str_replace("?1", "'".$product_type."'", $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY OUTPUT_DATE DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryOutput();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setOutputValue((double) $row['OUTPUT_VALUE']);
				$supply_date = $row['OUTPUT_DATE'];
				$date_formatted = date("d/m/Y", strtotime($supply_date));
				$vo->setOutputDate($date_formatted);
				$vo->setCustomerType($row['CUSTOMER_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setBeginStandMeter((double) $row['BEGIN_STAND_METER']);
				$vo->setEndStandMeter((double) $row['END_STAND_METER']);
				$vo->setVehicleType($row['VEHICLE_TYPE']);
				$vo->setTeraValue((double) $row['TERA_VALUE']);
				$vo->setPumpId($row['PUMP_ID']);
				$vo->setNozzleId($row['NOZZLE_ID']);
				$vo->setOutputTime($row['OUTPUT_TIME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOutputTimeShift($row['OUTPUT_TIME_SHIFT']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All inventories : ".$e);
		}
		return $results;
	}

	public function findTotalOutputByCustomerType($customer_type, $product_type=NULL, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($customer_type)) {
				die("Customer type must be specified");
			}

			$q = "SELECT  sum(OUTPUT_VALUE) FROM INV_MGT_OUTPUT "
			." WHERE CUSTOMER_TYPE = ?1";

			$q_pr = array ("?1");
			$input_var = array ("'".$customer_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($product_type)) {
				$q = "SELECT sum(OUTPUT_VALUE) FROM INV_MGT_OUTPUT WHERE CUSTOMER_TYPE = ?1 "
				. " AND INV_TYPE IN "
				. "("
				. " SELECT INV_TYPE FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?2";
				
				$q = $q . ")";
				$q_pr = array ("?1", "?2");
				$input_var = array ("'".$customer_type."'", "'".$product_type."'");
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
			die("Can't find Inventory by customer type and output date : ".$e);
		}
		return $result;
	}

	public function findAllCustomerType($product_type=NULL, $station_id=NULL) {
		$results = NULL;
		try {

			$results = array ();
			$q = "SELECT DISTINCT CUSTOMER_TYPE FROM INV_MGT_OUTPUT WHERE 1=1";

			if (!empty ($product_type)) {
				$q = "SELECT DISTINCT CUSTOMER_TYPE FROM INV_MGT_OUTPUT "
				." WHERE INV_TYPE IN "
				."( "
				." SELECT INV_TYPE "
				." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1";
				$q = $q . ")";
				if (!empty ($station_id)) {
					$q = $q." AND STATION_ID = '".$station_id."'";
				}
				$q = str_replace("?1", "'".$product_type."'", $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$results[$count] = $row['CUSTOMER_TYPE'];
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by customer type and output date : ".$e);
		}
		return $results;
	}

	public function findAllPumpId($product_type='BBM', $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT PUMP_ID FROM INV_MGT_OUTPUT WHERE 1=1";
			if (!empty ($product_type)) {
				$q = "SELECT PUMP_ID FROM INV_MGT_OUTPUT "
				." WHERE INV_TYPE IN "
				."("
				." SELECT INV_TYPE "
				." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1 ";

				$q = $q .")";
				$q = str_replace("?1", "'".$product_type."'", $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY OUTPUT_DATE DESC";

			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$results[$count] = $row['PUMP_ID'];
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All inventories : ".$e);
		}
		return $results;
	}
	public function countAll($product_type=NULL, $pump_id=NULL, $station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_OUTPUT WHERE 1=1";
			if (!empty ($product_type)) {
				$q = "SELECT  COUNT(ID) FROM INV_MGT_OUTPUT "
				." WHERE INV_TYPE IN "
				. "("
				." SELECT DISTINCT INV_TYPE "
				." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1 ";

				$q = $q . ")";
				$q = str_replace("?1", "'".$product_type."'", $q);
			}
			if (!empty ($pump_id)) {
				$q = $q. " AND PUMP_ID = ?2 ";
				$q = str_replace("?2", "'".$pump_id."'", $q);
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
			die("Can't find All inventories : ".$e);
		}
		return $result;
	}

	public function findByPumpId($pump_id, $pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			if (empty($pump_id)) {
				die("Invalid Pump Id.");
			}
			$q = "SELECT ID, INV_TYPE, CUSTOMER_TYPE, OUTPUT_DATE, OUTPUT_VALUE, UNIT_PRICE, CATEGORY, BEGIN_STAND_METER, END_STAND_METER, "
			. " VEHICLE_TYPE, TERA_VALUE, PUMP_ID, NOZZLE_ID, "
			." OUTPUT_TIME, STATION_ID, OUTPUT_TIME_SHIFT FROM INV_MGT_OUTPUT "
			." WHERE PUMP_ID = ?1 ";
			$q = str_replace("?1", "'".$pump_id."'", $q);

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY OUTPUT_DATE DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryOutput();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setOutputValue((double) $row['OUTPUT_VALUE']);
				$supply_date = $row['OUTPUT_DATE'];
				$date_formatted = date("d/m/Y", strtotime($supply_date));
				$vo->setOutputDate($date_formatted);
				$vo->setCustomerType($row['CUSTOMER_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setBeginStandMeter((double) $row['BEGIN_STAND_METER']);
				$vo->setEndStandMeter((double) $row['END_STAND_METER']);
				$vo->setVehicleType($row['VEHICLE_TYPE']);
				$vo->setTeraValue((double) $row['TERA_VALUE']);
				$vo->setPumpId($row['PUMP_ID']);
				$vo->setNozzleId($row['NOZZLE_ID']);
				$vo->setOutputTime($row['OUTPUT_TIME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setOutputTimeShift($row['OUTPUT_TIME_SHIFT']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All inventories : ".$e);
		}
		return $results;
	}

	public function findTotalOutput($output_start_date, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($output_start_date)) {
				die("Invalid Output start date.");
			}
			$q = "SELECT sum(OUTPUT_VALUE) as TOTAL_OUTPUT_VALUE FROM INV_MGT_OUTPUT WHERE SUPPLY_DATE = ?1";

			$q_pr = array ("?1");
			$input_var = array ("'".$output_start_date."'");
			$q = str_replace($q_pr, $input_var, $q);
			if (!empty ($supply_end_date)) {
				$q = "SELECT sum(OUTPUT_VALUE) as TOTAL_OUTPUT_VALUE FROM INV_MGT_OUTPUT WHERE OUTPUT_DATE >= ?1 AND OUTPUT_DATE <= ?2";

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
				$result = $row['TOTAL_OUTPUT_VALUE'];
			}
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Inventories : ".$e);
		}
		return $result;
	}
	public function update(InventoryOutput $input) {
		$q = "UPDATE INV_MGT_OUTPUT SET INV_TYPE = ?1, OUTPUT_VALUE = ?2, OUTPUT_DATE = ?3, CUSTOMER_TYPE = ?4, UNIT_PRICE = ?5, CATEGORY = ?6, " .
                " BEGIN_STAND_METER = ?7, END_STAND_METER = ?8, VEHICLE_TYPE = ?9, TERA_VALUE = ?0, PUMP_ID = ?A, NOZZLE_ID = ?B, OUTPUT_TIME = ?C, OUTPUT_TIME_SHIFT = ?D WHERE ID = ?E";

		try {

			if (empty($input) || !$input->getInvId()) {
				die("Invalid Inventory output Id.");
			}
			$supply_date = $input->getOutputDate();

			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6", "?7", "?8", "?9", "?0", "?A", "?B", "?C", "?D", "?E");
			$input_var = array ("'".$input->getInvType()."'",
			$input->getOutputValue(),
                                "'".$supply_date."'",
                                "'".$input->getCustomerType()."'",
			$input->getUnitPrice(),
                                "'".$input->getCategory()."'",
			$input->getBeginStandMeter(),
			$input->getEndStandMeter(),
                                "'".$input->getVehicleType()."'",
			$input->getTeraValue(),
                                "'".$input->getPumpId()."'",
                                "'".$input->getNozzleId()."'",
                                "'".$input->getOutputTime()."'",
			  "'".$input->getOutputTimeShift()."'",
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

	public function delete($inv_id,$station_id=NULL) {
		$q = "DELETE FROM INV_MGT_OUTPUT WHERE ID = ?1";

		try {
			if (empty($inv_id)) {
				die("Invalid Inventory output Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($inv_id);
			$q = str_replace($q_pr, $input_var, $q);
		   if (!empty ($station_id)) {
				  $q = $q." AND STATION_ID = '".$station_id."'";
			}
			   
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}

	public function deleteAll($product_type=NULL,$station_id=NULL) {
		$q = "DELETE FROM INV_MGT_OUTPUT WHERE 1=1";

		try {
			if (!empty ($product_type)) {
				$q = "DELETE FROM INV_MGT_OUTPUT "
				." WHERE INV_TYPE IN "
				. "("
				. "SELECT INV_TYPE "
				." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1 ";

			   if (!empty ($station_id)) {
				  $q = $q." AND STATION_ID = '".$station_id."'";
			   }
			
				$q = $q .")";
				
				$q = str_replace("?1", "'".$product_type."'", $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}
	
public function findAllSuppliedStation() {
		$results = NULL;
		try {
			$results = array ();
			
			$q = "SELECT DISTINCT STATION_ID, STATION_ADDRESS, LOCATION_CODE FROM INV_MGT_STATION WHERE STATION_ID IN (";
				
			$q = $q . "SELECT STATION_ID FROM INV_MGT_SUPPLY ";
				
			$q = $q . ")";
			
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$result = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$vo = new Station();
				$vo->setStationId($row['STATION_ID']);
				$vo->setStationAddress($row['STATION_ADDRESS']);
				$vo->setLocationCode($row['LOCATION_CODE']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($result);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All stations : ".$e);
		}
		return $results;
	}
	public function findAllSuppliedInvType() {
		$results = NULL;
		try {
			$results = array ();
				
			$q = "SELECT DISTINCT ID, INV_TYPE, INV_DESC, PRODUCT_TYPE FROM INV_MGT_TYPE WHERE INV_TYPE IN (";

			$q = $q . "SELECT INV_TYPE FROM INV_MGT_SUPPLY";

			$q = $q . ")";
				
				
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
			die("Can't find All stations : ".$e);
		}
		return $results;
	}
    public function findAllSuppliedDistLoc() {
		$results = NULL;
		try {
			$results = array ();
				
			$q = "SELECT ID, LOCATION_CODE, LOCATION_NAME, SUPPLY_POINT, SALES_AREA_MANAGER FROM INV_MGT_DIST_LOCATION WHERE LOCATION_CODE IN (";
             $q = $q . "SELECT LOCATION_CODE FROM INV_MGT_STATION WHERE STATION_ID IN ( ";
			$q = $q . "SELECT STATION_ID FROM INV_MGT_SUPPLY ";

			$q = $q . ")";
			$q = $q . ")";	
				
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$result = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$vo = new DistributionLocation();
				$vo->setLocationId($row['ID']);
				$vo->setLocationCode($row['LOCATION_CODE']);
				$vo->setLocationName($row['LOCATION_NAME']);
				$vo->setSupplyPoint($row['SUPPLY_POINT']);
				$vo->setSalesAreaManager($row['SALES_AREA_MANAGER']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($result);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All distribution location : ".$e);
		}
		return $results;
	}
	
	public function findAllOutputByInvTypeAndDate($inv_type, $output_start_date= NULL, $output_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			$q = "SELECT sum(OUTPUT_VALUE) as TOTAL_OUTPUT_VALUE FROM INV_MGT_OUTPUT "
			." WHERE INV_TYPE = ?1 ";


			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty($output_start_date)) {
				$q = $q." AND OUTPUT_DATE >= ?2";
				$q_pr = array ("?2");
				$input_var = array ("'".$output_start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($output_end_date)) {
				$q = $q." AND OUTPUT_DATE <= ?3 ";
				$q_pr = array ("?3");
				$input_var = array ("'".$output_end_date."'");
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
				$result = $row['TOTAL_OUTPUT_VALUE'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Output by its inventory type and date : ".$e);
		}
		return $result;
	}
	
	// findEndStandMeterByInventoryType
public function findEndStandMeterByInventoryType($inv_type, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			$q = "SELECT END_STAND_METER, CONCAT(OUTPUT_DATE, ' ' , OUTPUT_TIME, ':00') AS O_DATE FROM INV_MGT_OUTPUT "
			." WHERE INV_TYPE = ?1 ";


			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			
			$q = $q." AND CATEGORY = 'SALES'";
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
            $q = $q." ORDER BY O_DATE DESC";
			$q = $q." LIMIT 0,1";
			//LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = $row['END_STAND_METER'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Output by its inventory type and date : ".$e);
		}
		return $result;
	}
}


?>