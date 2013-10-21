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
require_once 'vo/DeliveryRealisation.class.php';
require_once 'vo/DistributionLocation.class.php';
require_once 'vo/Station.class.php';
require_once 'LogManager.class.php';

class DeliveryRealisationManager {

	public function create(DeliveryRealisation $input) {
		$q = "INSERT INTO INV_MGT_DELIVERY_REALISATION (SALES_ORDER_NUMBER, STATION_ID, INV_TYPE, QUANTITY, PLATE_NUMBER, DRIVER_NAME, DELIVERY_DATE,"
		."DELIVERY_TIME, DELIVERY_SHIFT_NUMBER, DELIVERY_MESSAGE) VALUES (?1, ?2, ?3, ?4, ?5, ?6, ?7, ?8, ?9, ?A)";
		$insert_id = 0;
		try {
			if (empty($input)) {
				die("Invalid DeliveryRealisation parameter");
			}
			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6", "?7", "?8", "?9", "?A");
			$input_var = array ("'".$input->getSalesOrderNumber()."'",
			                    "'".$input->getStationId()."'",     
			                    "'".$input->getInvType()."'", 
			$input->getQuantity(),
			                    "'".$input->getPlateNumber()."'",
			                    "'".$input->getDriverName()."'",      
			                    "'".$input->getDeliveryDate()."'", 
			                    "'".$input->getDeliveryTime()."'",
                                "'".$input->getDeliveryShiftNumber()."'",
			                    "'".$input->getDeliveryMessage()."'");
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
	public function findByPrimaryKey($id) {
		$result = NULL;
		try {
			if (empty($id)) {
				die("Invalid delivery realisation id");
			}
			$q = "SELECT ID, SALES_ORDER_NUMBER, STATION_ID, INV_TYPE, QUANTITY, PLATE_NUMBER, DRIVER_NAME, DELIVERY_DATE, DELIVERY_TIME, DELIVERY_SHIFT_NUMBER, DELIVERY_MESSAGE FROM INV_MGT_DELIVERY_REALISATION WHERE ID = ?1";
			$q = str_replace("?1", $id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$vo = new DeliveryRealisation();

				$delivery_date = date("d/m/Y", strtotime($row['DELIVERY_DATE']));

				$vo->setDeliveryRealisationId($row['ID']);
				$vo->setSalesOrderNumber($row['SALES_ORDER_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);
				$vo->setPlateNumber($row['PLATE_NUMBER']);
				$vo->setDriverName($row['DRIVER_NAME']);
				$vo->setDeliveryDate($delivery_date);
				$vo->setDeliveryTime($row['DELIVERY_TIME']);
				$vo->setDeliveryShiftNumber($row['DELIVERY_SHIFT_NUMBER']);
				$vo->setDeliveryMessage($row['DELIVERY_MESSAGE']);

				$result = $vo;
			}

			mysql_free_result($rs);
			mysql_close($conn);
				
				
		} catch (Exception $e) {
			die("Can't find Delivery Realisation by its id : ".$e);
		}
		return $result;
	}



	public function findByDeliveryDate($pageIndex=NULL, $linePerPage=NULL, $dl_start_date, $dl_end_date=NULL) {
		$results = NULL;
		try {
			$results = array();

			$q = "SELECT ID, SALES_ORDER_NUMBER, STATION_ID, INV_TYPE, QUANTITY, PLATE_NUMBER, DRIVER_NAME, DELIVERY_DATE, DELIVERY_TIME, DELIVERY_SHIFT_NUMBER, DELIVERY_MESSAGE FROM INV_MGT_DELIVERY_REALISATION WHERE 1=1";
				
			if (!empty($dl_start_date)) {
				$q = $q . " AND DELIVERY_DATE >= '".$dl_start_date. "'";
			}
			if (!empty($dl_end_date)) {
				$q = $q . " AND DELIVERY_DATE <= '".$dl_end_date. "'";
			}
				
			$q = $q . " ORDER BY DELIVERY_DATE DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new DeliveryRealisation();

				$delivery_date = date("d/m/Y", strtotime($row['DELIVERY_DATE']));
				$vo->setDeliveryRealisationId($row['ID']);
				$vo->setSalesOrderNumber($row['SALES_ORDER_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);
				$vo->setPlateNumber($row['PLATE_NUMBER']);
				$vo->setDriverName($row['DRIVER_NAME']);
				$vo->setDeliveryDate($delivery_date);
				$vo->setDeliveryTime($row['DELIVERY_TIME']);
				$vo->setDeliveryShiftNumber($row['DELIVERY_SHIFT_NUMBER']);
				$vo->setDeliveryMessage($row['DELIVERY_MESSAGE']);

				$results[$count] = $vo;
				$count ++;
			}
				
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Delivery Realisation by delivery date : ".$e);
		}
		return $results;
	}

	public function findByStationId($pageIndex=NULL, $linePerPage=NULL, $station_id) {
		$results = NULL;
		try {
			$results = array();
			if (empty($station_id)) {
				die("Invalid station id");
			}
			$q = "SELECT ID, SALES_ORDER_NUMBER, STATION_ID, INV_TYPE, QUANTITY, PLATE_NUMBER, DRIVER_NAME, DELIVERY_DATE, DELIVERY_TIME, DELIVERY_SHIFT_NUMBER, DELIVERY_MESSAGE FROM INV_MGT_DELIVERY_REALISATION WHERE STATION_ID = ?1";
				
			$q_pr = array ("?1");
			$input_var = array ("'".$station_id."'");
			$q = str_replace($q_pr, $input_var, $q);
			$q = $q . " ORDER BY DELIVERY_DATE DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new DeliveryRealisation();

				$delivery_date = date("d/m/Y", strtotime($row['DELIVERY_DATE']));
				$vo->setDeliveryRealisationId($row['ID']);
				$vo->setSalesOrderNumber($row['SALES_ORDER_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);
				$vo->setPlateNumber($row['PLATE_NUMBER']);
				$vo->setDriverName($row['DRIVER_NAME']);
				$vo->setDeliveryDate($delivery_date);
				$vo->setDeliveryTime($row['DELIVERY_TIME']);
				$vo->setDeliveryShiftNumber($row['DELIVERY_SHIFT_NUMBER']);
				$vo->setDeliveryMessage($row['DELIVERY_MESSAGE']);

				$results[$count] = $vo;
				$count ++;
			}
				
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Delivery Realisation by sales order : ".$e);
		}
		return $results;
	}

	public function findAllRealisedInventoryType($station_id=NULL) {
		$results = NULL;
		try {
			$results = array();
				
			$q = "SELECT DISTINCT ID, INV_TYPE, INV_DESC, PRODUCT_TYPE FROM INV_MGT_TYPE WHERE INV_TYPE IN "
			  ."(SELECT INV_TYPE FROM INV_MGT_DELIVERY_REALISATION ";
				
			if (!empty ($station_id)) {
				$q = $q." WHERE STATION_ID = '".$station_id."'";
			}
			$q = $q . ")";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryType();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setInvDesc($row['INV_DESC']);
				$vo->setProductType($row['PRODUCT_TYPE']);

				$results[$count] = $vo;
				$count ++;
			}
				
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Delivery Realisation by sales order : ".$e);
		}
		return $results;
	}
	public function findAllRealisedGasStation() {
		$results = NULL;
		try {
			$results = array();
				
			$q = "SELECT STATION_ID, STATION_ADDRESS, LOCATION_CODE FROM INV_MGT_STATION WHERE STATION_ID IN "
			  ."(SELECT STATION_ID FROM INV_MGT_DELIVERY_REALISATION ";
				
			 
			$q = $q . ")";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new Station();
				$vo->setStationId($row['STATION_ID']);
				$vo->setStationAddress($row['STATION_ADDRESS']);
				$vo->setLocationCode($row['LOCATION_CODE']);

				$results[$count] = $vo;
				$count ++;
			}
				
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Delivery Realisation by sales order : ".$e);
		}
		return $results;
	}
	
public function findAllRealisedDistLoc() {
		$results = NULL;
		try {
			$results = array();
				
			$q = "SELECT ID, LOCATION_CODE, LOCATION_NAME, SUPPLY_POINT, SALES_AREA_MANAGER FROM INV_MGT_DIST_LOCATION WHERE LOCATION_CODE IN " 
			."(SELECT LOCATION_CODE FROM INV_MGT_STATION WHERE STATION_ID IN "
			."(SELECT STATION_ID FROM INV_MGT_DELIVERY_REALISATION ";
				
			 
			$q = $q . "))";
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
			die("Can't find Delivery Realisation by sales order : ".$e);
		}
		return $results;
	}


	public function findBySalesOrderNumberAndStation($sales_order_number, $station_id) {
		$result = NULL;
		try {
			if (empty($sales_order_number)) {
				die("Invalid sales order number");
			}
			if (empty($station_id)) {
				die("Invalid station id");
			}
			$q = "SELECT ID, SALES_ORDER_NUMBER, STATION_ID, INV_TYPE, QUANTITY, PLATE_NUMBER, DRIVER_NAME, DELIVERY_DATE, DELIVERY_TIME, DELIVERY_SHIFT_NUMBER, DELIVERY_MESSAGE FROM INV_MGT_DELIVERY_REALISATION WHERE SALES_ORDER_NUMBER = ?1 AND STATION_ID = ?2";
			$q_pr = array ("?1", "?2");
			$input_var = array ("'".$sales_order_number."'",
			                    "'".$station_id."'");
			$q = str_replace($q_pr, $input_var, $q);
			$q = $q . " ORDER BY DELIVERY_DATE DESC";

				
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$vo = new DeliveryRealisation();

				$delivery_date = date("d/m/Y", strtotime($row['DELIVERY_DATE']));

				$vo->setDeliveryRealisationId($row['ID']);
				$vo->setSalesOrderNumber($row['SALES_ORDER_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);
				$vo->setPlateNumber($row['PLATE_NUMBER']);
				$vo->setDriverName($row['DRIVER_NAME']);
				$vo->setDeliveryDate($delivery_date);
				$vo->setDeliveryTime($row['DELIVERY_TIME']);
				$vo->setDeliveryShiftNumber($row['DELIVERY_SHIFT_NUMBER']);
				$vo->setDeliveryMessage($row['DELIVERY_MESSAGE']);

				$result = $vo;
			}

			mysql_free_result($rs);
			mysql_close($conn);
				
				
		} catch (Exception $e) {
			die("Can't find Delivery Realisation by its id : ".$e);
		}
		return $result;
	}
	public function findAll($pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array();
			$q = "SELECT ID, SALES_ORDER_NUMBER, STATION_ID, INV_TYPE, QUANTITY, PLATE_NUMBER, DRIVER_NAME, DELIVERY_DATE, DELIVERY_TIME, DELIVERY_SHIFT_NUMBER, DELIVERY_MESSAGE FROM INV_MGT_DELIVERY_REALISATION ";
			if (!empty ($station_id)) {
				$q = $q." WHERE STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY DELIVERY_DATE DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new DeliveryRealisation();

				$delivery_date = date("d/m/Y", strtotime($row['DELIVERY_DATE']));
				$vo->setDeliveryRealisationId($row['ID']);
				$vo->setSalesOrderNumber($row['SALES_ORDER_NUMBER']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);
				$vo->setPlateNumber($row['PLATE_NUMBER']);
				$vo->setDriverName($row['DRIVER_NAME']);
				$vo->setDeliveryDate($delivery_date);
				$vo->setDeliveryTime($row['DELIVERY_TIME']);
				$vo->setDeliveryShiftNumber($row['DELIVERY_SHIFT_NUMBER']);
				$vo->setDeliveryMessage($row['DELIVERY_MESSAGE']);

				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Delivery Realisation : ".$e);
		}
		return $results;
	}
	public function countAll($station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_DELIVERY_REALISATION";
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
			die("Can't count All Delivery Realisation : ".$e);
		}
		return $result;
	}
}
?>
