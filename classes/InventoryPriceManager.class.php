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
require_once 'vo/InventoryPrice.class.php';
require_once 'LogManager.class.php';

class InventoryPriceManager {

	public function create(InventoryPrice $input) {
		$q = "INSERT INTO INV_MGT_PRICE (INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID) VALUES (?1, ?2, ?3, ?4, ?5, ?6)";
		$insert_id = 0;
		try {
			if (empty($input)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid InventoryPrice param");
			}
			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6");
			$input_var = array ("'".$input->getInvType()."'",
			                        $input->getUnitPrice(),
                                "'".$input->getCategory()."'",
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
			if (empty($inv_id)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory price id");
			}
			$q = "SELECT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE WHERE ID = ?1";
			$q = str_replace("?1", $inv_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new InventoryPrice();
				$result->setInvId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setUnitPrice((double) $row['UNIT_PRICE']);
				$result->setCategory($row['CATEGORY']);
				$result->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$result->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));				
				$result->setStationId($row['STATION_ID']);
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Unit price by its id : ".$e);
		}
		return $result;
	}
	/**
	 * @deprecated
	 * @param string $inv_type
	 * @param string $station_id
	 */
	public function findByInventoryType($inv_type, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE WHERE INV_TYPE = ?1 "
			."AND CATEGORY = 'SALES' ";

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q. " ORDER BY ID DESC";

			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryPrice();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Unit price by inventory type : ".$e);
		}
		return $results;
	}
	
	/**
	 * 
	 * @param string $inv_type
	 * @param string $start_date
	 * @param string $end_date
	 * @param string $station_id
	 */
    public function findByInventoryTypeAndDate($inv_type, $start_date= NULL, $end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE WHERE INV_TYPE = ?1 "
			     ."AND CATEGORY = 'SALES' ";

			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);
			
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
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryPrice();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Unit price by inventory type : ".$e);
		}
		return $results;
	}

	/**
	 * @deprecated
	 * @param string $inv_type
	 * @param string $category
	 * @param string $unit_price
	 * @param string $station_id
	 */
    public function findByInventoryTypeAndPrice($inv_type, $category = 'SALES', $unit_price, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			else if (empty($unit_price) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid unit price");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE WHERE INV_TYPE = ?1 "
			."AND CATEGORY = ?2 AND UNIT_PRICE = ?3 ";

			$q_pr = array ("?1", "?2", "?3");
			$input_var = array ("'".$inv_type."'", "'".$category."'", $unit_price);
			$q = str_replace($q_pr, $input_var, $q);
			
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY ID DESC";
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryPrice();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Unit price by inventory type : ".$e);
		}
		return $results;
	}
	
	public function findByInventoryTypeAndPriceAndDate($inv_type, $category = 'SALES', $unit_price, $start_date= NULL, $end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			else if (empty($unit_price) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid unit price");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE WHERE INV_TYPE = ?1 "
			."AND CATEGORY = ?2 AND UNIT_PRICE = ?3 ";

			$q_pr = array ("?1", "?2", "?3");
			$input_var = array ("'".$inv_type."'", "'".$category."'", $unit_price);
			$q = str_replace($q_pr, $input_var, $q);
			
			
		    if (!empty ($start_date)) {
				$q = $q." AND START_DATE >= ?4";
				$q_pr = array ("?4");
				$input_var = array ("'".$start_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			if (!empty ($end_date)) {
				$q = $q." AND END_DATE <= ?5 ";
				$q_pr = array ("?5");
				$input_var = array ("'".$end_date."'");
				$q = str_replace($q_pr, $input_var, $q);
			}
			
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY ID DESC";
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryPrice();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Unit price by inventory type : ".$e);
		}
		return $results;
	}
    /**
     * @deprecated
     * @param string $inv_type
     * @param string $station_id
     */
	public function findOwnUseByInventoryType($inv_type, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE WHERE INV_TYPE = ?1 "
			."AND CATEGORY = 'OWN_USE' ";

			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY ID DESC";

			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryPrice();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Unit price by inventory type : ".$e);
		}
		return $results;
	}

     public function findOwnUseByInventoryTypeAndDate($inv_type, $start_date= NULL, $end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE WHERE INV_TYPE = ?1 "
			."AND CATEGORY = 'OWN_USE' ";

			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);
			
			
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
			$q = $q . " ORDER BY ID DESC";

			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryPrice();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Unit price by inventory type : ".$e);
		}
		return $results;
	}
	
	public function findAll($product_type = NULL, $pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE WHERE 1=1 ";
			if (!empty ($product_type)) {
				$q = "SELECT DISTINCT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE "
				." WHERE INV_TYPE IN "
				. "("
				."SELECT DISTINCT INV_TYPE "
				." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1 ";
				$q = str_replace("?1", "'".$product_type."'", $q);
				$q = $q .")";
			}

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY ID DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryPrice();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Unit prices : ".$e);
		}
		return $results;
	}
	
    public function findAllByDate($product_type = NULL, $pageIndex=NULL, $linePerPage=NULL, $station_id=NULL, $start_date= NULL, $end_date = NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE WHERE 1=1 ";
			if (!empty ($product_type)) {
				$q = "SELECT DISTINCT ID, INV_TYPE, UNIT_PRICE, CATEGORY, START_DATE, END_DATE, STATION_ID FROM INV_MGT_PRICE "
				." WHERE INV_TYPE IN "
				. "("
				."SELECT DISTINCT INV_TYPE "
				." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1 ";
				$q = str_replace("?1", "'".$product_type."'", $q);
				$q = $q .")";
			}

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
			$q = $q . " ORDER BY ID DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new InventoryPrice();
				$vo->setInvId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setUnitPrice((double) $row['UNIT_PRICE']);
				$vo->setCategory($row['CATEGORY']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
				$vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Unit prices : ".$e);
		}
		return $results;
	}
	
	public function countAll($product_type = NULL, $station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_PRICE WHERE 1=1";
			if (!empty ($product_type)) {
				$q = "SELECT COUNT(ID) FROM INV_MGT_PRICE "
				." WHERE INV_TYPE IN "
				."("
				."SELECT INV_TYPE "
				." FROM INV_MGT_TYPE WHERE PRODUCT_TYPE = ?1 ";
				$q = str_replace("?1", "'".$product_type."'", $q);
				$q = $q .")";
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
			die("Can't find All Unit prices : ".$e);
		}
		return $result;
	}
/**
 * @deprecated
 * @param string $inv_type
 * @param string $station_id
 */
	public function getAveragePriceByInventoryType($inv_type, $station_id=NULL) {
		$result = NULL;
		
	    if (empty($inv_type)) {
			die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
		}

		try {

			$q = "SELECT AVG(UNIT_PRICE) FROM INV_MGT_PRICE WHERE INV_TYPE = '".$inv_type."'";
			
		    if (!empty ($station_id)) {
				$q = $q. " AND STATION_ID = '".$station_id."'";
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
			die("Can't find Average Unit price : ".$e);
		}
		return $result;
	}
	
    public function getAveragePriceByInventoryTypeAndDate($inv_type, $start_date= NULL, $end_date = NULL, $station_id=NULL) {
		$result = NULL;
		
	    if (empty($inv_type)) {
			die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory type");
		}

		try {

			$q = "SELECT AVG(UNIT_PRICE) FROM INV_MGT_PRICE WHERE INV_TYPE = '".$inv_type."'";
			
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
				$q = $q. " AND STATION_ID = '".$station_id."'";
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
			die("Can't find Average Unit price : ".$e);
		}
		return $result;
	}
	public function update(InventoryPrice $input) {
		$q = "UPDATE INV_MGT_PRICE SET INV_TYPE = ?1, UNIT_PRICE = ?2, CATEGORY = ?3, START_DATE = ?4, END_DATE = ?5, WHERE ID = ?6";

		try {
			if (!$input->getInvId()) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid price id");
			}

			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6");
			$input_var = array ("'".$input->getInvType()."'",
			                        $input->getUnitPrice(),
                                "'".$input->getCategory()."'",
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
		$q = "DELETE FROM INV_MGT_PRICE WHERE ID = ?1";

		try {
			if (empty($inv_id)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid inventory price id");
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
	public function deleteAll($station_id) {
		$q = "DELETE FROM INV_MGT_PRICE";

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