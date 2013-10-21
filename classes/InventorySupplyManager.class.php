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
require_once 'vo/InventorySupply.class.php';
require_once 'DBManager.class.php';
require_once 'LogManager.class.php';
class InventorySupplyManager {

	public function create(InventorySupply $input) {
		$q = "INSERT INTO INV_MGT_SUPPLY (INV_TYPE, SUPPLY_VALUE, SUPPLY_DATE, DELIVERY_ORDER_NUMBER, PLATE_NUMBER, NIAP_NUMBER, STATION_ID) "
		." VALUES (?1, ?2, ?3, ?4, ?5, ?6, ?7)";
		$insert_id = 0;
		try {

			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6", "?7");
			$input_var = array ("'".$input->getInvType()."'", $input->getSupplyValue(),
			                    "'".$input->getSupplyDate()."'", "'".$input->getDeliveryOrderNumber()."'", 
			                    "'".$input->getPlateNumber()."'", "'".$input->getNiapNumber()."'",
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

	public function findByPrimaryKey($inv_id) {
		$result = NULL;
		try {
			$q = "SELECT ID, INV_TYPE, SUPPLY_VALUE, SUPPLY_DATE, DELIVERY_ORDER_NUMBER, PLATE_NUMBER, NIAP_NUMBER, STATION_ID FROM INV_MGT_SUPPLY WHERE ID = ?1 ";
			$q = str_replace("?1", $inv_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new InventorySupply();
				$result->setInvId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setSupplyValue((double) $row['SUPPLY_VALUE']);
				$supply_date = $row['SUPPLY_DATE'];
				$date_formatted = date("d/m/Y", strtotime($supply_date));
				$result->setSupplyDate($date_formatted);
				$result->setDeliveryOrderNumber($row['DELIVERY_ORDER_NUMBER']);
				$result->setPlateNumber($row['PLATE_NUMBER']);
				$result->setNiapNumber($row['NIAP_NUMBER']);
				$result->setStationId($row['STATION_ID']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its id : ".$e);
		}
		return $result;
	}

	public function findByDate($supply_start_date, $supply_end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT  ID, INV_TYPE, SUPPLY_VALUE, SUPPLY_DATE, DELIVERY_ORDER_NUMBER, PLATE_NUMBER, NIAP_NUMBER, STATION_ID FROM INV_MGT_SUPPLY WHERE SUPPLY_DATE >= ?1 ";
			$q = str_replace("?1", "'".$supply_start_date."'", $q);

			if (!empty ($supply_end_date)) {
				$q = "SELECT  ID, INV_TYPE, SUPPLY_VALUE, SUPPLY_DATE, DELIVERY_ORDER_NUMBER, PLATE_NUMBER, NIAP_NUMBER, STATION_ID FROM INV_MGT_SUPPLY "
				." WHERE SUPPLY_DATE >= ?1 AND SUPPLY_DATE <= ?2 ";
				$q_pr = array ("?1", "?2");
				$input_var = array ("'".$supply_start_date."'", "'".$supply_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY SUPPLY_DATE DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$result = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$vo = new InventorySupply();
				$vo->setDeliveryOrderNumber($row['DELIVERY_ORDER_NUMBER']);
				$vo->setSupplyValue($row['SUPPLY_VALUE']);
				$s_date = $row['SUPPLY_DATE'];
				$date_formatted = date("d/m/Y", strtotime($s_date));
				$vo->setSupplyDate($date_formatted);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setInvId($row['ID']);
				$vo->setPlateNumber($row['PLATE_NUMBER']);
				$vo->setNiapNumber($row['NIAP_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
				$results[$count] = $vo;
				$count ++;
			}
			mysql_free_result($result);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by date : ".$e);
		}
		return $results;
	}
	public function findByDeliveryAndDate($delivery_order_number, $supply_start_date, $supply_end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT  ID, INV_TYPE, SUPPLY_VALUE, SUPPLY_DATE, DELIVERY_ORDER_NUMBER, PLATE_NUMBER, NIAP_NUMBER, STATION_ID FROM INV_MGT_SUPPLY "
			."WHERE DELIVERY_ORDER_NUMBER = ?1 "
			." AND SUPPLY_DATE >= ?2 ";

			$q_pr = array ("?1", "?2");
			$input_var = array ("'".$delivery_order_number."'", "'".$supply_start_date."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($supply_end_date)) {
				$q = "SELECT  ID, INV_TYPE, SUPPLY_VALUE, SUPPLY_DATE, DELIVERY_ORDER_NUMBER, PLATE_NUMBER, NIAP_NUMBER, STATION_ID FROM INV_MGT_SUPPLY "
				." WHERE DELIVERY_ORDER_NUMBER = ?1 AND SUPPLY_DATE >= ?2 AND SUPPLY_DATE <= ?3 ";

				$q_pr = array ("?1", "?2", "?3");
				$input_var = array ("'".$delivery_order_number."'", "'".$supply_start_date."'", "'".$supply_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY SUPPLY_DATE DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$result = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$vo = new InventorySupply();
				$vo->setDeliveryOrderNumber($row['DELIVERY_ORDER_NUMBER']);
				$vo->setSupplyValue($row['SUPPLY_VALUE']);
				$s_date = $row['SUPPLY_DATE'];
				$date_formatted = date("d/m/Y", strtotime($s_date));
				$vo->setSupplyDate($date_formatted);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setInvId($row['ID']);
				$vo->setPlateNumber($row['PLATE_NUMBER']);
				$vo->setNiapNumber($row['NIAP_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
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
	public function findAll($product_type = NULL, $pageIndex = NULL, $linePerPage = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT ID, INV_TYPE, SUPPLY_VALUE, SUPPLY_DATE, DELIVERY_ORDER_NUMBER, PLATE_NUMBER, NIAP_NUMBER, STATION_ID FROM INV_MGT_SUPPLY ";

			if (!empty ($product_type)) {
				$q = "SELECT  ID, INV_TYPE, SUPPLY_VALUE, SUPPLY_DATE, DELIVERY_ORDER_NUMBER, PLATE_NUMBER, NIAP_NUMBER, STATION_ID FROM INV_MGT_SUPPLY "
				." WHERE INV_TYPE IN (SELECT INV_TYPE "." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1) ";
				$q = str_replace("?1", "'".$product_type."'", $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY SUPPLY_DATE DESC";

			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$result = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$vo = new InventorySupply();
				$vo->setDeliveryOrderNumber($row['DELIVERY_ORDER_NUMBER']);
				$vo->setSupplyValue($row['SUPPLY_VALUE']);
				$s_date = $row['SUPPLY_DATE'];
				$date_formatted = date("d/m/Y", strtotime($s_date));
				$vo->setSupplyDate($date_formatted);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setInvId($row['ID']);
				$vo->setPlateNumber($row['PLATE_NUMBER']);
				$vo->setNiapNumber($row['NIAP_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
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
	public function findFirstSupply($product_type = NULL, $station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT DISTINCT ID, INV_TYPE, SUPPLY_VALUE, SUPPLY_DATE, DELIVERY_ORDER_NUMBER, PLATE_NUMBER, NIAP_NUMBER, STATION_ID FROM INV_MGT_SUPPLY WHERE 1=1";

			if (!empty ($product_type)) {
				$q = "SELECT DISTINCT ID, INV_TYPE, SUPPLY_VALUE, SUPPLY_DATE, DELIVERY_ORDER_NUMBER, PLATE_NUMBER, NIAP_NUMBER, STATION_ID FROM INV_MGT_SUPPLY "
				." WHERE INV_TYPE IN (SELECT INV_TYPE "
				." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1) ";
				$q = str_replace("?1", "'".$product_type."'", $q);
			}
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY SUPPLY_DATE ASC";
			$q = $q." LIMIT 0, 1";

			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);

			if ($row) {
				$result = new InventorySupply();
				$result->setDeliveryOrderNumber($row['DELIVERY_ORDER_NUMBER']);
				$result->setSupplyValue($row['SUPPLY_VALUE']);
				$s_date = $row['SUPPLY_DATE'];
				$date_formatted = date("d/m/Y", strtotime($s_date));
				$result->setSupplyDate($date_formatted);
				$result->setInvType($row['INV_TYPE']);
				$result->setInvId($row['ID']);
				$result->setPlateNumber($row['PLATE_NUMBER']);
				$result->setNiapNumber($row['NIAP_NUMBER']);
				$result->setStationId($row['STATION_ID']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Inventories : ".$e);
		}
		return $result;
	}

	public function countAll($product_type = NULL, $station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_SUPPLY WHERE 1=1";

			if (!empty ($product_type)) {
				$q = "SELECT  COUNT(ID) FROM INV_MGT_SUPPLY "
				." WHERE INV_TYPE IN (SELECT INV_TYPE FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1)";
				$q = str_replace("?1", "'".$product_type."'", $q);
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
			die("Can't find All Inventories : ".$e);
		}
		return $result;
	}
	public function findTotalSupplyByProductType($product_type = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT sum(SUPPLY_VALUE) as TOTAL_SUPPLY_VALUE FROM INV_MGT_SUPPLY WHERE 1=1";

			if (!empty ($product_type)) {
				$q = "SELECT sum(SUPPLY_VALUE) as TOTAL_SUPPLY_VALUE FROM INV_MGT_SUPPLY "
				." WHERE INV_TYPE IN "
				."("
				. "SELECT INV_TYPE "
				." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1 ";
				$q = str_replace("?1", "'".$product_type."'", $q);
				$q = $q . ")";
			}

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = $row['TOTAL_SUPPLY_VALUE'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Inventories : ".$e);
		}
		return $result;
	}
	public function findTotalSupply($supply_start_date, $supply_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT sum(SUPPLY_VALUE) as TOTAL_SUPPLY_VALUE FROM INV_MGT_SUPPLY WHERE 1=1 ";
			if (!empty($supply_start_date)) {
				$q = $q . " AND SUPPLY_DATE >= ?1";
				$q_pr = array ("?1");
				$input_var = array ("'".$supply_start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}

			if (!empty ($supply_end_date)) {
				$q = $q . " AND SUPPLY_DATE <= ?2";
				$q_pr = array ("?2");
				$input_var = array ("'".$supply_end_date."'");
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
				$result = $row['TOTAL_SUPPLY_VALUE'];
			}
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Inventories : ".$e);
		}
		return $result;
	}
	public function findTotalSupplyByInventoryType($inv_type, $supply_start_date=NULL, $supply_end_date = NULL, $station_id=NULL) {
		$result = NULL;
		LogManager :: LOG($supply_start_date.','.$supply_end_date);
	    if (empty($inv_type)) {
			die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
		}
		try {
			$q = "SELECT sum(SUPPLY_VALUE) as TOTAL_SUPPLY_VALUE FROM INV_MGT_SUPPLY WHERE 1=1 ";
			if (!empty($inv_type)) {
				$q = $q . " AND INV_TYPE = ?1";
				$q_pr = array ("?1");
				$input_var = array ("'".$inv_type."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty($supply_start_date)) {
				$q = $q. " AND SUPPLY_DATE >= ?2";

				$q_pr = array ("?2");
				$input_var = array ("'".$supply_start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}

			if (!empty($supply_end_date)) {
				$q = $q. " AND SUPPLY_DATE <= ?3";
				$q_pr = array ("?3");
				$input_var = array ("'".$supply_end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);

			LogManager :: LOG($q);
			if ($row) {
				$result = $row['TOTAL_SUPPLY_VALUE'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Inventories : ".$e);
		}
		return $result;
	}
	
	public function update(InventorySupply $input) {
		$q = "UPDATE INV_MGT_SUPPLY SET INV_TYPE = ?1, SUPPLY_VALUE = ?2, SUPPLY_DATE = ?3, DELIVERY_ORDER_NUMBER = ?4, PLATE_NUMBER = ?5, NIAP_NUMBER = ?6 WHERE ID = ?7";

		try {
			if (!$input->getInvId()) {
				die("Invalid Inventory Id.");
			}

			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6", "?7");
			$input_var = array ("'".$input->getInvType()."'", $input->getSupplyValue(), "'".$input->getSupplyDate()."'", "'".$input->getDeliveryOrderNumber()."'", "'".$input->getPlateNumber()."'", "'".$input->getNiapNumber()."'", $input->getInvId());
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
		$q = "DELETE FROM INV_MGT_SUPPLY WHERE ID = ?1";

		try {
			if (empty ($inv_id)) {
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
		$q = "DELETE FROM INV_MGT_SUPPLY";

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