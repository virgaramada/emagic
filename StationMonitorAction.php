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
require_once 'classes/InventoryOutputManager.class.php';
require_once 'classes/InventorySupplyManager.class.php';
require_once 'classes/InventoryPriceManager.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'classes/DistributionLocationManager.class.php';
require_once 'classes/StationManager.class.php';
require_once 'classes/TankCapacityManager.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/ControllerUtils.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/Constants.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'utils/DateUtil.class.php';

execute();
function execute() {

	if (empty($_REQUEST['PHPSESSID'])) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("session_expired" => "Anda harus login terlebih dahulu"));
		$tpl_engine->display('login.tpl');

	} else {
		session_id($_REQUEST['PHPSESSID']);
		session_start();
		validateSession();
	}
}

function validateSession() {
	if (isset ($_SESSION['user_role'])) {
		if ($_SESSION['user_role'] != UserRoleEnum::PERTAMINA && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER) {
			$tpl_engine = TemplateEngine::getEngine();

			$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk memonitor SPBU"));
			$tpl_engine->display('login.tpl');
		} else {
			$input_type = @ $_REQUEST["type"];
			$tpl_engine = TemplateEngine::getEngine();

			$found = findAllMonitorData($tpl_engine);
			
			 if ($found === TRUE) {
				$tpl_engine->display('station_monitor.tpl');
			}
		}
	} else {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');
	}

}

function findAllMonitorData($tpl_engine=NULL) {
	// check whether station has inventory or not
	$found = TRUE;
	
	$gas_stations = array();
    //$all_gas_stations = ControllerUtils::findAllStation();

    // if (($all_gas_stations == NULL || sizeof($all_gas_stations)  == 0)) {

     //	$tpl_engine->clear_all_assign();
     //	$tpl_engine->assign("errors", array ("station_id" => "Belum ada SPBU yang terdaftar!"));
     //	$tpl_engine->display('station_monitor_error.tpl');
     		
     //	return TRUE;
    // }
	
	$selected_inv_type = @$_REQUEST['inventory_type'];
	$selected_dist_loc_id = @$_REQUEST['dist_loc_id'];
	
    $inv_output_mgr = new InventoryOutputManager();
    
   
	// find all inventory
	$inv_types = ControllerUtils::findAllInventoryType();
	$inv_type_sel = array();
	$inv_type_list =  array(); //$inv_types;//array($inv_types[sizeof($inv_types) - 1]); 
	if (isset($selected_inv_type) && !empty($selected_inv_type)) {
			
		$inv_type_mgr = new InventoryTypeManager();
		$selected_inv_list = $inv_type_mgr->findByInventoryType($selected_inv_type);


		if ($selected_inv_list != NULL && sizeof($selected_inv_list) > 0) {

			$inv_type_list = array();
			$inv_type_list = array_merge($inv_type_list, $selected_inv_list);
		}
	} else {
		 
		 $inv_type_sel = !empty ($inv_types) && sizeof($inv_types) > 0 ? array($inv_types[0]) : NULL;
	     $inv_type_list =  $inv_type_sel;
	}
	 
    if (($inv_type_list == NULL || sizeof($inv_type_list) == 0)) {
		$tpl_engine->assign("errors", array ("station_id" => "Tidak ditemukan SPBU yang sesuai dengan kriteria pencarian"));
		// get all dist locations
		$dist_locations =  ControllerUtils::findAllDistLocation();
		$tpl_engine->assign("dist_locations", $dist_locations);

		return TRUE;
	} else {
		$tpl_engine->assign("inv_type_list", $inv_type_list);
		$tpl_engine->assign("inv_types", $inv_types);
	}
	
	/**
	if (($inv_types == NULL || sizeof($inv_types)  == 0)) {
        $found = FALSE;
		$tpl_engine->clear_all_assign();
		$tpl_engine->assign("errors", array ("inv_type" => "Belum ada SPBU yang memiliki inventory!"));
		$tpl_engine->display('station_monitor_error.tpl');
        
	} else {
		$tpl_engine->assign("inv_types", $inv_types);
		$found = TRUE;
	} */
	
    if ($found === TRUE) {
	    // get all gas station
	    
    	$output_list = array();
    	if (isset($selected_inv_type) && !empty($selected_inv_type)) {
         	foreach($inv_type_list as $key=>$value) {
	    	  $output_list = array_merge($output_list, 
	    	  $inv_output_mgr->findByInventoryTypeAndDate($value->getInvType(), NULL, date("Y-m-d"), NULL));
	    	 
	    	}
    	} else {
    		
    	    
	    	  $output_list = array_merge($output_list, 
	    	  $inv_output_mgr->findByAllInventoryTypeAndDate(NULL, date("Y-m-d"), NULL));
	    	 
	    	
    	}
    	
    	if (($output_list == NULL || sizeof($output_list)  == 0)) {

    		$tpl_engine->clear_all_assign();
    		$tpl_engine->assign("errors", array ("output_list" => "Belum ada SPBU yang melakukan penjualan atas inventory yang dipilih!"));
    		$tpl_engine->display('station_monitor_error.tpl');
    		$found = FALSE;
    	} else {
    		   
    		

    			$gas_stations = ControllerUtils::findGasStationByInventoryType($inv_type_list);

    		if (($gas_stations == NULL || sizeof($gas_stations) == 0)) {
    			$tpl_engine->assign("errors", array ("station_id" => "Tidak ditemukan SPBU yang sesuai dengan kriteria pencarian"));
    			// get all dist locations
    			$dist_locations =  ControllerUtils::findAllDistLocation();
    			$tpl_engine->assign("dist_locations", $dist_locations);

    			return TRUE;
    		}
    	}
    }
	
	
	if ($found === TRUE) {
		
	   // get all dist locations
		$dist_locations =  ControllerUtils::findAllDistLocation();
		$tpl_engine->assign("dist_locations", $dist_locations);
		
		$dist_mgr =  new DistributionLocationManager();
		
		$dist_loc_list = $dist_mgr->findAll();
	

		if (isset($selected_dist_loc_id) && !empty($selected_dist_loc_id)) {
			
			$sel_dist_list = $dist_mgr->findByPrimaryKey($selected_dist_loc_id);
				
			if ($sel_dist_list) {

				$dist_loc_list = array();
				$dist_loc_list = array_merge($dist_loc_list, array($sel_dist_list));
			}
		}
		
		$dist_loc_code_list = array();
		if ($dist_loc_list != NULL && sizeof($dist_loc_list) > 0) {
			foreach ($dist_loc_list as $key=>$value) {
				$dist_loc_code_list = array_merge($dist_loc_code_list, array($value->getLocationCode()));
			}
			$tpl_engine->assign("dist_loc_list", $dist_loc_list);
		}
		
		
		$number_of_gas_station = 0;
		$valid_gas_station_by_inv_list = $gas_stations;//array();
		
		if (isset($selected_inv_type) && !empty($selected_inv_type)) {
			$valid_gas_station_by_inv_list = array();
			
			foreach ($gas_stations as $key => $value) {
				$valid_gas_station_list = array();
				
				foreach ($value as $k=>$v) {
					if (in_array($v->getLocationCode(), $dist_loc_code_list)) {
						$valid_gas_station_list = array_merge($valid_gas_station_list, array($v));
					}
				}
				if ($valid_gas_station_list != NULL && sizeof($valid_gas_station_list) > 0) {
					$valid_gas_station_by_inv_list = array_merge($valid_gas_station_by_inv_list, array($key=>$valid_gas_station_list));
	
					$number_of_gas_station = $number_of_gas_station + sizeof($valid_gas_station_list);
				}
				
			}
			
		} else {
			$number_of_gas_station = sizeof($gas_stations);
		}

		
		if (($valid_gas_station_by_inv_list == NULL || sizeof($valid_gas_station_by_inv_list) == 0)) {
			$tpl_engine->assign("errors", array ("station_id" => "Tidak ditemukan SPBU yang sesuai dengan kriteria pencarian"));
			// get all dist locations
			$dist_locations =  ControllerUtils::findAllDistLocation();
			$tpl_engine->assign("dist_locations", $dist_locations);

			return TRUE;
		} else {
			$tpl_engine->assign("gas_stations", $valid_gas_station_by_inv_list);
		}
		
		$tpl_engine->assign("number_of_gas_station", $number_of_gas_station);
		
		$inv_gas_station_key = ControllerUtils::getInventoryTypeGasStationKey($gas_stations);
		
	
		// get inventory price for each inventory type
		//$avg_prices = _findAveragePriceByInventoryTypeAndGasStation($inv_gas_station_key);
		//$tpl_engine->assign("avg_prices", $avg_prices);
	
		// find total supply
		$inv_supply = _findTotalSupplyByInventoryTypeAndGasStation($inv_gas_station_key);
		$tpl_engine->assign("inv_supply", $inv_supply);
		$tpl_engine->assign("total_supply", calculateTotalSupply($inv_supply));
	
		// find last stock
		$last_stock = _findLastStockByInventoryTypeAndGasStation($inv_gas_station_key, @$tpl_engine);
		$tpl_engine->assign("last_stock", $last_stock);
		$tpl_engine->assign("total_last_stock", calculateTotalStock($last_stock));
	
		// find tank capacity
		$tank_cap = _findTankCapacityByInventoryTypeAndGasStation($inv_gas_station_key);
		$tpl_engine->assign("tank_cap", $tank_cap);
	
		// find sales by inventory type
	    $all_sales = _findSalesByInventoryTypeAndGasStation($inv_gas_station_key);
		$tpl_engine->assign("all_sales", $all_sales);
		$tpl_engine->assign("total_sales", calculateTotalSales($all_sales));
	
		// find stock percentage by inventory type
		$stock_percentage = _findStockPercentageByInventoryTypeAndGasStation($inv_gas_station_key);
		$tpl_engine->assign("stock_percentage", $stock_percentage);
		//print_r($stock_percentage);
		$tpl_engine->assign("total_stock_percentage", calculateTotalStockPercentage($stock_percentage));
	
		// find empty tank
		$empty_tank = _findEmptyTankByInventoryTypeAndGasStation($inv_gas_station_key);
		$tpl_engine->assign("empty_tank", $empty_tank);
		
		// last supply date
		$last_supply_date = _findLastSupplyDateByInventoryTypeAndGasStation($inv_gas_station_key);
		$tpl_engine->assign("last_supply_date", $last_supply_date);
		
		// last output date
		$last_output_date = _findLastOutputDateByInventoryTypeAndGasStation($inv_gas_station_key);
		$tpl_engine->assign("last_output_date", $last_output_date);

	}
	return $found;
}


function _findSalesByInventoryTypeAndGasStation($inv_gas_station_key) {
	
	$inv_output_mgr = new InventoryOutputManager();
	$END_DATE = date("Y-m-d");
	$START_DATE = NULL;
	$input_type = @ $_REQUEST["type"];
	//$aDay = 60 * 60 * 24;
	if (!empty ($input_type)) {
		
		if ($input_type == 'SEARCH') {
			$start_day = (int) @$_POST["StartDate_Day"];
			$smt = mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], $start_day, (int) @$_POST["StartDate_Year"]);
			$START_DATE = date("Y-m-d", $smt);
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = NULL;
	if (($inv_gas_station_key != NULL && sizeof($inv_gas_station_key) > 0)) {
		$result = array ();
		foreach ($inv_gas_station_key as $key => $value) {
			list($inv_type, $station_id) = explode(Constants::_UNDERSCODE_SYMBOL, $value);
		
			$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($inv_type, $START_DATE, $END_DATE, $station_id);
			$result = array_merge($result, array ($value => number_format(($outputs), 0, ".", ""))); 
		
		}
	}
	
	return $result;
}

function _findLastOutputDateByInventoryTypeAndGasStation($inv_gas_station_key) {
	
	$inv_output_mgr = new InventoryOutputManager();
	
	$result = NULL;
	if (($inv_gas_station_key != NULL && sizeof($inv_gas_station_key) > 0)) {
		$result = array ();
		foreach ($inv_gas_station_key as $key => $value) {
			list($inv_type, $station_id) = explode(Constants::_UNDERSCODE_SYMBOL, $value);
		
			$last_output_date = $inv_output_mgr->findLastOutputDateByInventoryType($inv_type, $station_id);
			$result = array_merge($result, array ($value => $last_output_date)); 
		
		}
	}
	
	return $result;
}

function calculateTotalSales($total_sales) {
	$result = 0.00;
	foreach($total_sales as $key => $value) {
		$result = bcadd($result, $value);
	}
	return number_format($result, 2, ",", ".");
}


function _findAveragePriceByInventoryTypeAndGasStation($inv_gas_station_key) {
	$inv_price = new InventoryPriceManager();
	$result = NULL;
	if (($inv_gas_station_key != NULL && sizeof($inv_gas_station_key) > 0)) {
		$result = array ();
		 
		  
		foreach ($inv_gas_station_key as $key => $value) {
			   // key format is $inv_type_$gas_station_id
				list($inv_type, $station_id) = explode(Constants::_UNDERSCODE_SYMBOL, $value);
      
				$outputs = $inv_price->getAveragePriceByInventoryTypeAndDate($inv_type, date("Y-m-d"), date("Y-m-d"), $station_id);
		      
				if (empty($outputs) ) {
					$outputs = 0;
				}
				$result = array_merge($result, array ($value => number_format(($outputs), 0, ".", "")));	
			     
			
		}
	}

	return $result;

}


function _findTankCapacityByInventoryTypeAndGasStation($inv_gas_station_key) {
	$tank_cap_mgr = new TankCapacityManager();

	$result = NULL;

	if (($inv_gas_station_key != NULL && sizeof($inv_gas_station_key) > 0)) {
		$result = array ();
		foreach ($inv_gas_station_key as $key => $value) {
			// key format is $inv_type_$gas_station_id
			list($inv_type, $station_id) = explode(Constants::_UNDERSCODE_SYMBOL, $value);
	
			$vo = $tank_cap_mgr->findByInventoryType($inv_type, $station_id);
	
	        $tank_cap = 0;
			if (($vo) ) {
				$tank_cap = $vo->getTankCapacity();
			}
			$result = array_merge($result, array ($value => number_format(($tank_cap), 0, ".", "")));
		}
	}
   
	return $result;

}


function _findEmptyTankByInventoryTypeAndGasStation($inv_gas_station_key) {
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();
	$tank_cap_mgr = new TankCapacityManager();

	$END_DATE = date("Y-m-d");
	$START_DATE = NULL;
	$input_type = @ $_REQUEST["type"];
	//$aDay = 60 * 60 * 24;
	if (!empty ($input_type)) {
		
		if ($input_type == 'SEARCH') {
			$start_day = (int) @$_POST["StartDate_Day"];
			$smt = mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], $start_day, (int) @$_POST["StartDate_Year"]);
			$START_DATE = date("Y-m-d", $smt);
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();
	$lastMonthStockArr = _findLastMonthStockByInventoryTypeAndGasStation($inv_gas_station_key);
	
	
	foreach ($inv_gas_station_key as $key => $value) {
		// key format is $inv_type_$gas_station_id
		list($inv_type, $station_id) = explode(Constants::_UNDERSCODE_SYMBOL, $value);

		
		$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($inv_type, $START_DATE, $END_DATE, $station_id);
		$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($inv_type, $START_DATE, $END_DATE, $station_id);
		$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($inv_type, $START_DATE, $END_DATE, $station_id);
		$losses = $inv_output_mgr->findTotalLossesOutputByInventoryTypeAndDate($inv_type, $START_DATE, $END_DATE, $station_id);
		

        if (empty($supply) ) {
			$supply = 0;
		}
		if (empty($outputs) ) {
			$outputs = 0;
		}
		if (empty($ownuse) ) {
			$ownuse = 0;
		}
		if (empty($losses) ) {
			$losses = 0;
		}
		
		$last_month_stock = $lastMonthStockArr[$value];
		if (empty($last_month_stock) ) {
			$last_month_stock = 0;

		}
		
		$esupply =  bcadd($supply, $last_month_stock);
		$last_stock_calc = bcsub($esupply, bcadd($outputs, bcadd($ownuse, $losses)));

		$vo = $tank_cap_mgr->findByInventoryType($inv_type, $station_id);
		$tank_cap = 0;
		if (($vo) ) {
			$tank_cap = $vo->getTankCapacity();
		}
		$empty_tank = bcsub($tank_cap, $last_stock_calc);

		$result = array_merge($result, array ($value => number_format(($empty_tank), 0, ".", "")));
	}

	return $result;
}



function _findStockPercentageByInventoryTypeAndGasStation($inv_gas_station_key) {
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();
	$tank_cap_mgr = new TankCapacityManager();

	$END_DATE = date("Y-m-d");
	$START_DATE = "";
	$input_type = @ $_REQUEST["type"];
	//$aDay = 60 * 60 * 24 * 1000;
	if (!empty ($input_type)) {
		
		if ($input_type == 'SEARCH') {
			$start_day = (int) @$_POST["StartDate_Day"];
			$smt = mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], $start_day, (int) @$_POST["StartDate_Year"]);
			$START_DATE = date("Y-m-d", $smt);
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	bcscale(10);
	$result = array ();
	$lastMonthStockArr = _findLastMonthStockByInventoryTypeAndGasStation($inv_gas_station_key);
	
	
	
	foreach ($inv_gas_station_key as $key => $value) {
		// key format is $inv_type_$gas_station_id
		list($inv_type, $station_id) = explode(Constants::_UNDERSCODE_SYMBOL, $value);
		
	   // this month stock
		$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($inv_type, $START_DATE, $END_DATE, $station_id);
		$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($inv_type, $START_DATE, $END_DATE, $station_id);
		$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($inv_type, $START_DATE, $END_DATE, $station_id);
		$losses = $inv_output_mgr->findTotalLossesOutputByInventoryTypeAndDate($inv_type, $START_DATE, $END_DATE, $station_id);
		if (empty($supply) ) {
			$supply = 0;
		}
		if (empty($outputs) ) {
			$outputs = 0;
		}
		if (empty($ownuse) ) {
			$ownuse = 0;
		}
		if (empty($losses) ) {
			$losses = 0;
		}
		
	    $last_month_stock = $lastMonthStockArr[$value];
		if (empty($last_month_stock) ) {
			$last_month_stock = 0;

		}
		
		$esupply =  bcadd($supply, $last_month_stock);
		$last_stock_calc = bcsub($esupply, bcadd($outputs, bcadd($ownuse, $losses)));
       // print_r("last_stock : " . $last_stock_calc . "<br/>");

		$tank_cap = 0;
		$vo = $tank_cap_mgr->findByInventoryType($inv_type, $station_id);
		
		
		if (($vo)) {
			$tank_cap = $vo->getTankCapacity();
			
		}
		//print_r("tank cap : (" . $value .") : " . $tank_cap ."<br/>");
		
		$tank_cap_factor = 0;
		if ($tank_cap > 0) {
		   $tank_cap_factor = bcdiv((int) $last_stock_calc, (int) $tank_cap);	
		}
		//print_r("tank_cap_factor : (" . $tank_cap_factor .") <br/>");
		
		$stock_percentage = bcmul((int)100, $tank_cap_factor);

		$result = array_merge($result, array ($value => number_format(($stock_percentage), 2, ".", "")) );

	}

	asort($result, SORT_NUMERIC);
	//print_r($result);
	
	return $result;
}




function _findTotalSupplyByInventoryTypeAndGasStation($inv_gas_station_key) {
	$inv_mgr = new InventorySupplyManager();
	$END_DATE = date("Y-m-d");
	$START_DATE = NULL;
	$input_type = @ $_REQUEST["type"];

	if (!empty ($input_type)) {
		
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();
	foreach ($inv_gas_station_key as $key => $value) {
		// key format is $inv_type_$gas_station_id
		list($inv_type, $station_id) = explode(Constants::_UNDERSCODE_SYMBOL, $value);
		$outputs = $inv_mgr->findTotalSupplyByInventoryType($inv_type, $START_DATE, $END_DATE, $station_id);
		
		if (empty($outputs) ) {
			$outputs = 0;
		}
		$result = array_merge($result, array ($value => number_format(($outputs), 0, ".", "")));
		
	}

	return $result;
}

function _findLastSupplyDateByInventoryTypeAndGasStation($inv_gas_station_key) {
	$inv_mgr = new InventorySupplyManager();

	$result = array ();
	foreach ($inv_gas_station_key as $key => $value) {
		// key format is $inv_type_$gas_station_id
		list($inv_type, $station_id) = explode(Constants::_UNDERSCODE_SYMBOL, $value);
		$supply_date = $inv_mgr->findLastSupplyDateByInventoryType($inv_type, $station_id);
		
		if (empty($supply_date) ) {
			$supply_date = "-";
		}
		$result = array_merge($result, array ($value => $supply_date));
		
	}

	return $result;
}


function calculateTotalSupply($total_supply) {
	$result = 0.00;

	foreach ($total_supply as $key => $value) {
		$result = bcadd($result, $value);
	}
	return number_format($result, 2, ',', '.');
}



function _findLastMonthStockByInventoryTypeAndGasStation($inv_gas_station_key) {
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();

	$input_type = @ $_REQUEST["type"];
	$aDay = 60 * 60 * 24;

	$timeEnd = mktime(0, 0, 0, ((int) date("m")), (int) date("d"), (int) date("Y"));
	$LAST_MONTH_END_DATE = date("Y-m-d", $timeEnd - $aDay);
	$LAST_MONTH_START_DATE = "";
	if (!empty ($input_type)) {
		

		if ($input_type == 'SEARCH') {
			$start_day = (int) @$_POST["StartDate_Day"];
			$smt = mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], $start_day, (int) @$_POST["StartDate_Year"]);
			$LAST_MONTH_END_DATE = date("Y-m-d", $smt - $aDay);
			$LAST_MONTH_START_DATE = "";
		}
	}
	$result = array ();
	
	foreach ($inv_gas_station_key as $key => $value) {
		// key format is $inv_type_$gas_station_id
		list($inv_type, $station_id) = explode(Constants::_UNDERSCODE_SYMBOL, $value);

	    $supply = $inv_supply_mgr->findTotalSupplyByInventoryType($inv_type, $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $station_id);
		$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($inv_type, $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $station_id);
		$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($inv_type, $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $station_id);
		$losses = $inv_output_mgr->findTotalLossesOutputByInventoryTypeAndDate($inv_type, $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $station_id);
		if (empty($supply) ) {
			$supply = 0;
		}
		if (empty($outputs) ) {
			$outputs = 0;
		}
		if (empty($ownuse) ) {
			$ownuse = 0;
		}
		if (empty($losses) ) {
			$losses = 0;
		}

		$last_month_stock = bcsub($supply, bcadd($outputs, bcadd($ownuse, $losses)));
		
		$result = array_merge($result, array ($value => $last_month_stock));
	}
	
	
	return $result;
}



function _findLastStockByInventoryTypeAndGasStation($inv_gas_station_key, $tpl_engine) {
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();
	$END_DATE = date("Y-m-d");
	$START_DATE = "";
	$input_type = @ $_REQUEST["type"];
	//$aDay = 60 * 60 * 24 * 1000;
	if (!empty ($input_type)) {
		
		if ($input_type == 'SEARCH') {
			$start_day = (int) @$_POST["StartDate_Day"];
			$smt = mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], $start_day, (int) @$_POST["StartDate_Year"]);
			$START_DATE = date("Y-m-d", $smt);
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	bcscale(10);
	$result = array ();
	$lastMonthStockArr = _findLastMonthStockByInventoryTypeAndGasStation($inv_gas_station_key);
	$through_put_list = array();
	$throught_put = 0;
	foreach ($inv_gas_station_key as $key => $value) {
		// key format is $inv_type_$gas_station_id
		list($inv_type, $station_id) = explode(Constants::_UNDERSCODE_SYMBOL, $value);
		
		// this month stock
		$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($inv_type, $START_DATE, $END_DATE, $station_id);
		$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($inv_type, $START_DATE, $END_DATE, $station_id);
		$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($inv_type, $START_DATE, $END_DATE, $station_id);
		$losses = $inv_output_mgr->findTotalLossesOutputByInventoryTypeAndDate($inv_type, $START_DATE, $END_DATE, $station_id);
		
		if (empty($supply) ) {
			$supply = 0;
		}
		if (empty($outputs) ) {
			$outputs = 0;
		}
		if (empty($ownuse) ) {
			$ownuse = 0;
		}
		if (empty($losses) ) {
			$losses = 0;
		}

		$last_month_stock = $lastMonthStockArr[$value];

		if (empty($last_month_stock) ) {
			$last_month_stock = 0;
		}

		$esupply =  bcadd($supply, $last_month_stock);

		$last_stock_calc = bcsub($esupply, bcadd($outputs, bcadd($ownuse, $losses)));
			

	/**	LogManager::LOG('findLastStockByInventoryType('.$value.') = '.$START_DATE.'|'
		.$END_DATE.', type='.$input_type.'->'
		.$esupply.'-('. $outputs.'+'.$ownuse.'+'.$losses.')='.$last_stock_calc);
		*/
		if ($outputs == 0) {
			$throught_put = 0;
		} else {
			if ($START_DATE == '')
			{
				$START_DATE = date("Y-m-d");
			}
			
			$s_date = strtotime($START_DATE);
			$e_date = strtotime($END_DATE);
			$number_of_days = DateUtil::_count_days( $s_date, $e_date);
			
			
			if ($number_of_days == 0)
			{
				$number_of_days = 1;
			}
			
			$h_const = $outputs / $number_of_days;
			
			if ($h_const == 0)
			{
				$h_const = 1;
			}
			
			//print_r("h:".$h_const. "<br/>");
			$st_const = $last_stock_calc / $h_const;
			//print_r("s:".$st_const. "<br/>");
			
			$throught_put = $st_const * 24;
			
			/**
			print_r("station_id:".$station_id. "<br/>");
			print_r("number_of_days:".$number_of_days. "<br/>");
			print_r("last_stock_calc:".$last_stock_calc. "<br/>");
			print_r("outputs:".$outputs. "<br/>");
			print_r("throught_put:".$throught_put. "<br/>");
			print_r("============<br/>");
			*/
			
		}
		
		
		$result = array_merge($result, array ($value => $last_stock_calc));
		$through_put_list = array_merge($through_put_list, array ($value => $throught_put));
		
		
	}
	$tpl_engine->assign("through_put_list", $through_put_list);
	
	return $result;
}

function calculateTotalStock($last_stock) {
	$result = 0;
	//bcscale(2);
	foreach ($last_stock as $key => $value) {
		//echo 'key='.$key.', value='.$value;
		$result = bcadd($result, $value);
	}
	return number_format($result, 2, ',', '.');
}

function calculateTotalStockPercentage($stock_percentage) {
	$result = 0.00;
	//bcscale(2);
	foreach ($stock_percentage as $key => $value) {
		$result = bcadd($result, $value);
	}
	return number_format($result, 2, ',', '.');
}

?>
