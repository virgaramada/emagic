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
require_once 'vo/RealStock.class.php';
require_once 'LogManager.class.php';

class RealStockManager {
	
public function create(RealStock $input) {
		$q = "INSERT INTO INV_MGT_REAL_STOCK (INV_TYPE, START_DATE, END_DATE, QUANTITY, STATION_ID) "
		." VALUES (?1, ?2, ?3, ?4, ?5)";
		$insert_id = 0;
		try {
			if (!isset($input) || !($input)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " : Invalid RealStock parameter.");
			}
			

			$q_pr = array ("?1", "?2", "?3", "?4", "?5");
			$input_var = array ("'".$input->getInvType()."'",
                                "'".$input->getStartDate()."'",
                                "'".$input->getEndDate()."'",
			                        $input->getQuantity(),
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
	public function findByPrimaryKey($real_stock_id) {
		$result = NULL;
		try {
			if (empty($real_stock_id)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " : Invalid Real stock Id.");
			}
			$q = "SELECT ID, INV_TYPE, START_DATE, END_DATE, QUANTITY, STATION_ID "
 			    ." FROM INV_MGT_REAL_STOCK WHERE ID = ?1 ";
			$q = str_replace("?1", $real_stock_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = new RealStock();
				$result->setRealStockId($row['ID']);
				$result->setInvType($row['INV_TYPE']);
				$result->setQuantity((double) $row['QUANTITY']);

				
				$result->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
                $result->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$result->setStationId($row['STATION_ID']);

			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its id : ".$e);
		}
		return $result;
	}
	public function findByInventoryTypeAndDate($inv_type, $start_date= NULL, $end_date = NULL, $station_id=NULL) {
		$results = NULL;
		try {
			if (empty($inv_type)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " : Invalid real stock inventory type.");
			}
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, START_DATE, END_DATE, QUANTITY, STATION_ID "
			." FROM INV_MGT_REAL_STOCK "
			." WHERE INV_TYPE = ?1 ";

			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);


			
			
			if (!empty ($start_date) && !empty ($end_date)) {
				//$q = $q." AND (START_DATE BETWEEN ". "DATE('".$start_date."') AND ". "DATE('".$end_date."')";
				//$q = $q." OR END_DATE BETWEEN ". "DATE('".$start_date."') AND ". "DATE('".$end_date."'))";
				$q = $q." AND (START_DATE >= DATE('".$start_date."')" ;
				$q = $q." AND END_DATE <= DATE('".$end_date."')) ";
				
			} /**else {
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
			}*/
			
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY START_DATE DESC";
			
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new RealStock();
				$vo->setRealStockId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);

				
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
                $vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$vo->setStationId($row['STATION_ID']);
				$results[$count] = $vo;
				$count ++;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find Inventory by its type and date : ".$e);
		}
		return $results;
	}
	
	public function findTotalQuantityByInventoryTypeAndDate($inv_type, $start_date= NULL, $end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($inv_type) ) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " :  Invalid real stock inventory type");
			}
			$q = "SELECT sum(QUANTITY) as TOTAL_QUANTITY FROM INV_MGT_REAL_STOCK "
			." WHERE INV_TYPE = ?1 ";


			$q_pr = array ("?1");
			$input_var = array ("'".$inv_type."'");
			$q = str_replace($q_pr, $input_var, $q);

			/**if (!empty($start_date)) {
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
			}*/
		    if (!empty ($start_date) && !empty ($end_date)) {
				//$q = $q." AND (START_DATE BETWEEN ". "DATE('".$start_date."') AND ". "DATE('".$end_date."')";
				//$q = $q." OR END_DATE BETWEEN ". "DATE('".$start_date."') AND ". "DATE('".$end_date."'))";
				$q = $q." AND (START_DATE >= DATE('".$start_date."')" ;
				$q = $q." AND END_DATE <= DATE('".$end_date."')) ";
				
			}
			
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}

			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = $row['TOTAL_QUANTITY'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Error in method ".__METHOD__." of " .__CLASS__. " : ".$e);
		}
		return $result;
	}
	
	public function findTotalQuantityByDate($start_date= NULL, $end_date = NULL, $station_id=NULL) {
		$result = NULL;
		try {
				
			$q = "SELECT sum(QUANTITY) as TOTAL_QUANTITY FROM INV_MGT_REAL_STOCK "
			." WHERE 1=1 ";

			/**if (!empty($start_date)) {
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
			}*/
		    if (!empty ($start_date) && !empty ($end_date)) {
				//$q = $q." AND (START_DATE BETWEEN ". "DATE('".$start_date."') AND ". "DATE('".$end_date."')";
				//$q = $q." OR END_DATE BETWEEN ". "DATE('".$start_date."') AND ". "DATE('".$end_date."'))";
				$q = $q." AND (START_DATE >= DATE('".$start_date."')" ;
				$q = $q." AND END_DATE <= DATE('".$end_date."')) ";
				
			}
				
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}

			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$result = $row['TOTAL_QUANTITY'];
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Error in method ".__METHOD__." of " .__CLASS__. " : ".$e);
		}
		return $result;
	}
	
	public function findAll($pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT DISTINCT ID, INV_TYPE, START_DATE, END_DATE, QUANTITY, STATION_ID FROM INV_MGT_REAL_STOCK WHERE 1=1";
			
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY START_DATE DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new RealStock();
				$vo->setRealStockId($row['ID']);
				$vo->setInvType($row['INV_TYPE']);
				$vo->setQuantity((double) $row['QUANTITY']);

				
				$vo->setStartDate(date("d/m/Y", strtotime($row['START_DATE'])));
                $vo->setEndDate(date("d/m/Y", strtotime($row['END_DATE'])));
				$vo->setStationId($row['STATION_ID']);
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
	
	public function countAll($station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_REAL_STOCK WHERE 1=1";

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
	public function update(RealStock $input) {
		$q = "UPDATE INV_MGT_REAL_STOCK SET INV_TYPE = ?1, QUANTITY = ?2, START_DATE = ?3, END_DATE = ?4  " 
		    ."  WHERE ID = ?5";

		try {

			if (empty($input) || !$input->getRealStockId()) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " : Invalid real stock Id.");
			}
			

			$q_pr = array ("?1", "?2", "?3", "?4", "?5");
			$input_var = array ("'".$input->getInvType()."'",
			                        $input->getQuantity(),
                                "'".$input->getStartDate()."'",
                                "'".$input->getEndDate()."'",
			                        $input->getRealStockId());
			
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

	public function delete($real_stock_id, $station_id=NULL) {
		$q = "DELETE FROM INV_MGT_REAL_STOCK WHERE ID = ?1";

		try {
			if (empty($real_stock_id)) {
				die("Error in method ".__METHOD__." of " .__CLASS__. " : Invalid real stock Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($real_stock_id);
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

	public function deleteAll($station_id=NULL) {
		$q = "DELETE FROM INV_MGT_REAL_STOCK WHERE 1=1";

		try {
			
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
}
?>
