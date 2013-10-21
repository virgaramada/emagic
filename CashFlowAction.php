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
require_once 'classes/TemplateEngine.class.php';
require_once 'vo/WorkInCapital.class.php';
require_once 'vo/InventoryMargin.class.php';
require_once 'vo/InventoryType.class.php';
require_once 'vo/InventoryOutput.class.php';
require_once 'vo/OverheadCost.class.php';
require_once 'classes/WorkInCapitalManager.class.php';
require_once 'classes/InventoryMarginManager.class.php';
require_once 'classes/InventoryPriceManager.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'classes/InventoryOutputManager.class.php';
require_once 'classes/InventorySupplyManager.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/SalesReportManager.class.php';
require_once 'classes/InventoryCustomerManager.class.php';
require_once 'classes/OverheadCostManager.class.php';
require_once 'classes/RealStockManager.class.php';



if (empty($_REQUEST['PHPSESSID'])) {
	$tpl_engine = TemplateEngine::getEngine();
	$tpl_engine->assign("errors", array ("session_expired" => "Anda harus login terlebih dahulu"));
	$tpl_engine->display('login.tpl');

} else {
	session_id($_REQUEST['PHPSESSID']);
	session_start();
	validateSession();
}

function validateSession() {
	if (empty($_SESSION["station_id"])) {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("station_id" => "SPBU tidak dikenal!"));
		$tpl_engine->display('login.tpl');
	}
	else if (isset ($_SESSION['user_role'])) {
		if ($_SESSION['user_role'] != 'ADM' && $_SESSION['user_role'] != 'SUP'  && $_SESSION['user_role'] != 'OWN' && $_SESSION['user_role'] != 'USE' && $_SESSION['user_role'] != 'OPE') {
			$tpl_engine = TemplateEngine::getEngine();

			$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk melihat cash flow"));
			$tpl_engine->display('login.tpl');
		} else {
			$input_type = @ $_REQUEST["type"];
			$tpl_engine = TemplateEngine::getEngine();

	        $inv_types = findAllInventoryType();
	        $inv_prices = findAllInventoryPrice();
	        if ($inv_types != NULL && sizeof($inv_types) > 0 && $inv_prices != NULL && sizeof($inv_prices) > 0) {
	        	findCapitalByCode($tpl_engine);
	        	findInventories($tpl_engine);
	        	findStockByInventoryType($tpl_engine, $inv_types, $inv_prices);
	        	findTotalSales($tpl_engine);
	        	findSalesByInventoryType($tpl_engine, $inv_types, $inv_prices);
	        	findAllOwnUseSales($tpl_engine);
	        	findAllLosses($tpl_engine);
	        	findAllOverheadCost($tpl_engine);
	        }
	
			
			if ($input_type == 'SEARCH') {
				$tpl_engine->display('search_cash_flow.tpl');
			} else {
				$tpl_engine->display('cash_flow.tpl');
			}
		}
	} else {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');
	}

}

function findCapitalByCode($tpl_engine = NULL) {
	$mgr = new WorkInCapitalManager();
	$result = $mgr->findByCode('C_INIT', $_SESSION["station_id"]);
	$tpl_engine->assign("work_in_capital", $result);
	return $result;

}

function findStockByInventoryType($tpl_engine, $inv_types, $inv_prices) {

	$inv_supply = findTotalSupplyByInventoryType($inv_types, $inv_prices);
	$last_stock = findLastStockByInventoryType($inv_types, $inv_prices);
	$last_month_stock = findLastMonthStockByInventoryType($inv_types, $inv_prices);

	$tpl_engine->assign("last_month_stock", $last_month_stock);
	$tpl_engine->assign("inv_supply", $inv_supply);
	$tpl_engine->assign("last_stock", $last_stock);
	
	$stock_losses = _findStockLossesByInventoryPrice($inv_types, $inv_prices);
	//print_r($stock_losses);
	$tpl_engine->assign("stock_losses", $stock_losses);

}

function findInventories($tpl_engine) {
	$END_DATE = date("d/m/Y");
	$START_DATE = date("d/m/Y");
	$ACTUAL_DATE = date("d M Y");
	$input_type = @ $_REQUEST["type"];

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$ACTUAL_DATE = date("M Y");
		}
		if ($input_type == 'YEARLY') {
			$ACTUAL_DATE = date("Y");
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("d/m/Y", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("d/m/Y", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
			$ACTUAL_DATE = $START_DATE .'-' .$END_DATE;
		}
	}
	$tpl_engine->assign("actual_date", $ACTUAL_DATE);
	$gas_types = findAllGas();
	$tpl_engine->assign("gas_types", $gas_types);

	$lub_types = findAllLubricants();
	if ($lub_types != NULL && sizeof($lub_types) > 0) {
	   $tpl_engine->assign("lub_types", $lub_types);
	}
}


function findAllInventoryPrice() {
	$inv_mgr = new InventoryPriceManager();
	$result = $inv_mgr->findAll(NULL,NULL,NULL,$_SESSION["station_id"]);
	return $result;
}
function findAllInventoryType() {
	$inv_mgr = new InventoryTypeManager();
	$result = $inv_mgr->findAll(NULL,NULL,$_SESSION["station_id"]);
	return $result;
}
function findTotalSupplyByInventoryType($inv_types, $inv_prices) {
	$inv_mgr = new InventorySupplyManager();
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();
	$own_use_price = 0;
	foreach ($inv_types as $key => $value) {
			foreach ($inv_prices as $k => $v) {
				if ($v->getCategory() == 'OWN_USE' && $v->getInvType() == $value->getInvType()) {
					$own_use_price = 0;
				}
			}
			$outputs = $inv_mgr->findTotalSupplyByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
			if (empty($outputs) ) {
				$outputs = 0;
			}
			$outputPrice = ($outputs *  $own_use_price);
			//LogManager :: LOG('Output in Rp='.$outputs.' x '.$own_use_price.'='.$outputPrice);
			$result = array_merge($result, array ($value->getInvType() => array($outputs => $outputPrice )));
		
	}
	return $result;
}
function findLastMonthStockByInventoryType($inv_types, $inv_prices) {
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();


	$input_type = @ $_REQUEST["type"];

	$aDay = 60 * 60 * 24;

	$timeEnd = mktime(0, 0, 0, ((int) date("m")), (int) date("d"), (int) date("Y"));
	$LAST_MONTH_END_DATE = date("Y-m-d", $timeEnd - $aDay);
	$LAST_MONTH_START_DATE = "";

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$smt = mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y"));
			$LAST_MONTH_END_DATE = date("Y-m-d", $smt - $aDay);
			$LAST_MONTH_START_DATE = "";
		}
		if ($input_type == 'YEARLY') {
			$smt = mktime(0, 0, 0, (int) date("m"), (int) date("d"), ((int) date("Y")) - 1);
			$LAST_MONTH_END_DATE = date("Y-m-d", $smt -$aDay);
			$LAST_MONTH_START_DATE = "";
		}
		if ($input_type == 'SEARCH') {
			$start_day = (int) @$_POST["StartDate_Day"];
			$smt = mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], $start_day, (int) @$_POST["StartDate_Year"]);
			$LAST_MONTH_END_DATE = date("Y-m-d", $smt - $aDay);
			$LAST_MONTH_START_DATE = "";
		}
	}
	$result = array ();
	$own_use_price = 0;

	$px = 0;
	foreach ($inv_types as $key => $value) {
			
			foreach ($inv_prices as $k => $v) {
		       if ($v->getCategory() == 'OWN_USE' && $v->getInvType() == $value->getInvType()) {
			      $own_use_price = $v->getUnitPrice();
               }
            }
			

			$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
			$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
			$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
			$losses = $inv_output_mgr->findTotalLossesOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
			//$losses = $rs_mgr->findTotalQuantityByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
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

			LogManager :: LOG('findLastMonthStockByInventoryType('.$value->getInvType().') = '
			.$LAST_MONTH_START_DATE.'|'.$LAST_MONTH_END_DATE.', type='.$input_type);

			$last_month_stock_value = bcsub($supply, bcadd($outputs, bcadd($ownuse, $losses)));

			$px = $last_month_stock_value * $own_use_price;
			LogManager :: LOG('Last month stock in Rp='.$last_month_stock_value.'X'. $own_use_price.'='.$px);
			$result = array_merge($result, array ($value->getInvType() => array($last_month_stock_value => $px)));
		

	}

	return $result;
}


function findLastStockByInventoryType($inv_types, $inv_prices) {
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();


	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];
	$aDay = 60 * 60 * 24;
	if (!empty ($input_type)) {

		if ($input_type == 'MONTHLY') {
			$smt = mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y"));
			$START_DATE = date("Y-m-d", $smt);
		}
		if ($input_type == 'YEARLY') {
			$smt = mktime(0, 0, 0, (int) date("m"), (int) date("d"), ((int) date("Y")) - 1);
			$START_DATE = date("Y-m-d", $smt);
		}
		if ($input_type == 'SEARCH') {
			$start_day = (int) @$_POST["StartDate_Day"];
			$smt = mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], $start_day , (int) @$_POST["StartDate_Year"]);
			$START_DATE = date("Y-m-d", $smt);
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();
	$own_use_price = 0;

	$lastMonthStockArr = findLastMonthStockByInventoryType($inv_types, $inv_prices);
	foreach ($inv_types as $key => $value) {

			foreach ($inv_prices as $k => $v) {
				if ($v->getCategory() == 'OWN_USE' && $v->getInvType() == $value->getInvType()) {
					$own_use_price = $v->getUnitPrice();
				}
			}

			$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
			$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
			$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
			$losses = $inv_output_mgr->findTotalLossesOutputByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
			//$losses = $rs_mgr->findTotalQuantityByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);

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
			LogManager :: LOG('findLastStockByInventoryType('.$value->getInvType().') = '.$START_DATE.'|'
			.$END_DATE.', type='.$input_type);
			$last_month_stock = 0;
			foreach ($lastMonthStockArr as $k => $v) {
				if ($k == $value->getInvType()) {
					foreach ($v as $a => $b) {
						LogManager :: LOG('Last month stock : value='.$a.', in Rp= '.$b);
						$last_month_stock = $a;
					}
				}
			}

			$esupply = bcadd($supply, $last_month_stock);
			$last_stock_calc = bcsub($esupply, bcadd($outputs, bcadd($ownuse, $losses)));
			$px = $last_stock_calc * $own_use_price;
			LogManager :: LOG('Last stock in Rp='.$last_stock_calc.'X'. $own_use_price.'='.$px);
			$result = array_merge($result, array ($value->getInvType() => array($last_stock_calc => $px)));
		}
	

	return $result;
}

function findSalesByInventoryType($tpl_engine, $inv_types, $inv_prices) {
	$input_type = @ $_REQUEST["type"];
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$sales_report = new SalesReportManager();

	$result = array ();

	foreach ($inv_types as $key => $value) {
		$total_sales = $sales_report->calculateSalesByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if (empty ($total_sales)) {
			$total_sales = 0;
		}
		$result = array_merge($result, array ($value->getInvType() => $total_sales));

	}
	$outputs = findOutputByInventoryType($inv_types);
	$inv_margins = findAllMarginByInventoryType($inv_types);
	$tpl_engine->assign("total_output_inventory", $outputs);
	$tpl_engine->assign("total_margin_inventory", $inv_margins);
	$tpl_engine->assign("total_sales_inventory", $result);
	$inv_supply = findTotalSupplyByInventoryType($inv_types, $inv_prices);

	$tpl_engine->assign("inv_supply", $inv_supply);
	$total_ownuse_sales_inventory = findOwnUseSalesByInventoryType($inv_types);
	$tpl_engine->assign("total_ownuse_sales_inventory", $total_ownuse_sales_inventory);
	$ownuse_outputs = findOwnUseOutputByInventoryType($inv_types);
	$tpl_engine->assign("total_ownuse_output_inventory", $ownuse_outputs);

	// Losses
	
	//$tpl_engine->assign("total_losses_inventory", $total_losses_inventory);
	//$losses_outputs = findLossesOutputByInventoryType($inv_types);
	//$tpl_engine->assign("total_losses_output_inventory", $losses_outputs);
	
	$real_stock_list = findRealStockByInventoryType($inv_types);
	$tpl_engine->assign("real_stock_list", $real_stock_list);

	$cust_types = findAllCustomer();
	$tpl_engine->assign("cust_types", $cust_types);

}

function findOwnUseSalesByInventoryType($inv_types) {
	$input_type = @ $_REQUEST["type"];
	$sales_report = new SalesReportManager();
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();

	foreach ($inv_types as $key => $value) {
		$total_sales = $sales_report->calculateOwnUseSalesByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if (empty ($total_sales)) {
			$total_sales = 0;
		}
		$result = array_merge($result, array ($value->getInvType() => $total_sales));

	}
	return $result;
}

function findLossesByInventoryType($inv_types) {
	
	
    $input_type = @ $_REQUEST["type"];
	$rs_mgr = new RealStockManager();
	$pr_mgr = new InventoryPriceManager();
	
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();

	foreach ($inv_types as $key => $value) {
		$price_by_inv_type = $pr_mgr->findOwnUseByInventoryType($value->getInvType(), $_SESSION["station_id"]);
		$unit_price = 0;
		if ($price_by_inv_type != NULL && sizeof($price_by_inv_type) > 0) {
			$unit_price = $price_by_inv_type[0]->getUnitPrice();
		}
		$total_real_stock = $rs_mgr->findTotalQuantityByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);

		if (empty ($total_real_stock)) {
			$total_real_stock = 0;
		}
		$calculate_real_stock = $total_real_stock * $unit_price;
		$result = array_merge($result, array ($value->getInvType() => $calculate_real_stock));

	}
	return $result;
}

function findRealStockByInventoryType($inv_types) {
	$input_type = @ $_REQUEST["type"];
	$rs_mgr = new RealStockManager();
	$pr_mgr = new InventoryPriceManager();
	
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();

	foreach ($inv_types as $key => $value) {
		$price_by_inv_type = $pr_mgr->findOwnUseByInventoryType($value->getInvType(), $_SESSION["station_id"]);
		$unit_price = 0;
		if ($price_by_inv_type != NULL && sizeof($price_by_inv_type) > 0) {
			$unit_price = $price_by_inv_type[0]->getUnitPrice();
		}
		
		
		$total_real_stock = $rs_mgr->findTotalQuantityByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);

		if (empty ($total_real_stock)) {
			$total_real_stock = 0;
		}
		$calculate_real_stock = $total_real_stock * $unit_price;
		$result = array_merge($result, array ($value->getInvType() => array($total_real_stock => $calculate_real_stock)));

	}
	return $result;
}

function findTotalSales($tpl_engine) {
	$sales_report = new SalesReportManager();
	$input_type = @ $_REQUEST["type"];
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$ACTUAL_DATE = date("d M Y");

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
			$ACTUAL_DATE = date("M Y");
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
			$ACTUAL_DATE = date("Y");
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
			$ACTUAL_DATE = date("d/m/Y", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]))
			.'-' .date("d/m/Y", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}

	$total_sales = $sales_report->calculateAllSales($START_DATE, $END_DATE, $_SESSION["station_id"]);
	$tpl_engine->assign("total_sales", $total_sales);
    //if (empty($total_sales) && !empty($input_type)) {
		//$tpl_engine->clear_all_assign();
		// $tpl_engine->assign("errors", array ("total_sales" => "Belum ada penjualan untuk ". $START_DATE." s.d. ".$END_DATE));
		
	//}
	/**$tpl_engine->assign("actual_date", $ACTUAL_DATE);
	$gas_types = findAllGas();
	$tpl_engine->assign("gas_types", $gas_types);

	$lub_types = findAllLubricants();
	if ($lub_types != NULL && sizeof($lub_types) > 0) {
	    $tpl_engine->assign("lub_types", $lub_types);	
	} */
	
}

function findAllOwnUseSales($tpl_engine) {
	$sales_report = new SalesReportManager();
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int)  @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$total_sales = $sales_report->calculateAllOwnUseSales($START_DATE, $END_DATE, $_SESSION["station_id"]);
	$tpl_engine->assign("total_ownuse_sales", $total_sales);
}

function findAllLosses($tpl_engine) {
	/**
	$sales_report = new SalesReportManager();
	$rs_mgr = new RealStockManager();
	
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	//$total_losses = $sales_report->calculateAllLosses($START_DATE, $END_DATE, $_SESSION["station_id"]);
	$total_losses = $rs_mgr->findTotalQuantityByDate($START_DATE, $END_DATE, $_SESSION["station_id"]);
	$tpl_engine->assign("total_losses", $total_losses);
	
	*/
	
	
	
}

function findOutputByInventoryType($inv_types) {
	$inv_mgr = new InventoryOutputManager();
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();
	foreach ($inv_types as $key => $value) {
		$outputs = $inv_mgr->findByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if (!empty ($outputs)) {
			$result = array_merge($result, $outputs);
		}
	}
	return $result;

}
function findOwnUseOutputByInventoryType($inv_types) {
	$inv_mgr = new InventoryOutputManager();
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();
	foreach ($inv_types as $key => $value) {
		$outputs = $inv_mgr->findOwnUseByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if (($outputs)) {
			$result = array_merge($result, $outputs);
		}
	}
	return $result;

}

function findLossesOutputByInventoryType($inv_types) {
		
	
    $input_type = @ $_REQUEST["type"];
	$rs_mgr = new RealStockManager();
	
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();

	foreach ($inv_types as $key => $value) {

		$total_real_stock = $rs_mgr->findByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);

		if (($total_real_stock)) {
			$result = array_merge($result, $total_real_stock);
		}
	}
	
	
	
	return $result;

}

function findAllGas() {
	$inv_mgr = new InventoryTypeManager();
	$result = $inv_mgr->findByProductType("BBM", $_SESSION["station_id"]);
	return $result;
}
function findAllLubricants() {
	$inv_mgr = new InventoryTypeManager();
	$result = $inv_mgr->findByProductType("LUB", $_SESSION["station_id"]);
	return $result;
}
function findAllMarginByInventoryType($inv_types) {
	$inv_margin = new InventoryMarginManager();

	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}

	$result = array ();
	foreach ($inv_types as $key => $value) {
		$total_margins = $inv_margin->findByInventoryType($value->getInvType(), $_SESSION["station_id"]);
		if (($total_margins)) {
		    $result = array_merge($result, array ($value->getInvType() => $total_margins));	
		}
		

	}
	return $result;
}

function findAllCustomer() {
	$inv_mgr = new InventoryCustomerManager();
	$result = $inv_mgr->findAll(NULL,NULL, $_SESSION["station_id"]);
	return $result;
}
function findAllOverheadCost($tpl_engine) {
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) @$_POST["StartDate_Day"], (int) @$_POST["StartDate_Year"]));
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}

	$ovh_mgr = new OverheadCostManager();
	$tpl_engine->assign("total_overhead_cost", $ovh_mgr->findTotalOverheadCost($START_DATE, $END_DATE, $_SESSION["station_id"]));
}

function _findStockLossesByInventoryPrice($inv_types, $inv_prices) {
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();
	$rs_mgr = new RealStockManager();

	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];
	$aDay = 60 * 60 * 24;
	if (!empty ($input_type)) {

		if ($input_type == 'MONTHLY') {
			$smt = mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y"));
			$START_DATE = date("Y-m-d", $smt);
		}
		if ($input_type == 'YEARLY') {
			$smt = mktime(0, 0, 0, (int) date("m"), (int) date("d"), ((int) date("Y")) - 1);
			$START_DATE = date("Y-m-d", $smt);
		}
		if ($input_type == 'SEARCH') {
			$start_day = (int) @$_POST["StartDate_Day"];
			$smt = mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], $start_day , (int) @$_POST["StartDate_Year"]);
			$START_DATE = date("Y-m-d", $smt);
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();
	$own_use_price = 0;

	$lastMonthStockArr = _findLastMonthStockLossesByInventoryPrice($inv_types, $inv_prices);
	foreach ($inv_types as $key => $value) {

             foreach ($inv_prices as $k => $v) {
		        if ($v->getCategory() == 'OWN_USE' && $v->getInvType() == $value->getInvType()) {
			        $own_use_price = $v->getUnitPrice();
                }
             }

			$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
			$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
			$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);

			$losses = $rs_mgr->findTotalQuantityByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);


			//echo("REAL STOCK :"); print_r($losses); echo("<br/>");
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
			
			$last_month_stock = 0.00;
			foreach ($lastMonthStockArr as $k => $v) {
				if ($k == $value->getInvType()) {
					foreach ($v as $a => $b) {
						//LogManager :: LOG('Last month stock : value='.$a.', in Rp= '.$b);
						$last_month_stock = $a;
					}
				}
			}

			$esupply = bcadd($supply, $last_month_stock);
			$last_stock_calc = 0;
			if ($losses >0) {
			  $last_stock_calc = bcsub($esupply, bcadd($outputs, bcadd($ownuse, $losses)));	
			}
			
			$px = $last_stock_calc * $own_use_price;
			
			$result = array_merge($result, array ($value->getInvType() => array($last_stock_calc => $px)));
		}
	

	return $result;
}

function _findLastMonthStockLossesByInventoryPrice($inv_types, $inv_prices) {
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();
	//$rs_mgr = new RealStockManager();

	$input_type = @ $_REQUEST["type"];

	$aDay = 60 * 60 * 24;

	$timeEnd = mktime(0, 0, 0, ((int) date("m")), (int) date("d"), (int) date("Y"));
	$LAST_MONTH_END_DATE = date("Y-m-d", $timeEnd - $aDay);
	$LAST_MONTH_START_DATE = "";

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$smt = mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y"));
			$LAST_MONTH_END_DATE = date("Y-m-d", $smt - $aDay);
			$LAST_MONTH_START_DATE = "";
		}
		if ($input_type == 'YEARLY') {
			$smt = mktime(0, 0, 0, (int) date("m"), (int) date("d"), ((int) date("Y")) - 1);
			$LAST_MONTH_END_DATE = date("Y-m-d", $smt -$aDay);
			$LAST_MONTH_START_DATE = "";
		}
		if ($input_type == 'SEARCH') {
			$start_day = (int) @$_POST["StartDate_Day"];
			$smt = mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], $start_day, (int) @$_POST["StartDate_Year"]);
			$LAST_MONTH_END_DATE = date("Y-m-d", $smt - $aDay);
			$LAST_MONTH_START_DATE = "";
		}
	}
	$result = array ();
	$own_use_price = 0;

	$px = 0;
	foreach ($inv_types as $key => $value) {
			
			foreach ($inv_prices as $k => $v) {
		       if ($v->getCategory() == 'OWN_USE' && $v->getInvType() == $value->getInvType()) {
		    	  $own_use_price = $v->getUnitPrice();
			   }
			}

			$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
			$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
			$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
			
			if (empty($supply) ) {
				$supply = 0;
			}
			if (empty($outputs) ) {
				$outputs = 0;
			}
			if (empty($ownuse) ) {
				$ownuse = 0;
			}
			
			$losses = 0;
			
			$last_month_stock_value = bcsub($supply, bcadd($outputs, bcadd($ownuse, $losses)));
	
			$px = $last_month_stock_value * $own_use_price;
	
			$result = array_merge($result, array ($value->getInvType() => array($last_month_stock_value => $px)));
		

	}

	return $result;
}
?>
