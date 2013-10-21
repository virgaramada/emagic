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
require_once 'classes/InventoryMarginManager.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'classes/InventoryOutputManager.class.php';
require_once 'classes/InventorySupplyManager.class.php';
require_once 'classes/LogManager.class.php';
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
		if ($_SESSION['user_role'] != 'ADM' && $_SESSION['user_role'] != 'SUP' && $_SESSION['user_role'] != 'OWN' && $_SESSION['user_role'] != 'USE' && $_SESSION['user_role'] != 'OPE') {
			$tpl_engine = TemplateEngine::getEngine();

			$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk melihat sisa stok"));
			$tpl_engine->display('login.tpl');
		} else {
			$input_type = @ $_REQUEST["type"];
			$tpl_engine = TemplateEngine::getEngine();

			findInventories($tpl_engine);
			findStockByInventoryType($tpl_engine);

			if ($input_type == 'SEARCH') {
				$tpl_engine->display('search_stock.tpl');
			} else {
				$tpl_engine->display('stock.tpl');
			}
		}
	} else {
		$tpl_engine = TemplateEngine::getEngine();

		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');
	}

}

function findStockByInventoryType($tpl_engine) {
	$inv_types = findAllInventoryType();
	$inv_supply = findTotalSupplyByInventoryType($inv_types);
	$last_stock = findLastStockByInventoryType($inv_types);
	$last_month_stock = findLastMonthStockByInventoryType($inv_types);

	$tpl_engine->assign("last_month_stock", $last_month_stock);
	$tpl_engine->assign("inv_supply", $inv_supply);
	$tpl_engine->assign("last_stock", $last_stock);
	$real_stock_list = findRealStockByInventoryType($inv_types);
	$tpl_engine->assign("real_stock_list", $real_stock_list);

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
	$tpl_engine->assign("lub_types", $lub_types);
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

function findAllInventoryType() {
	$inv_mgr = new InventoryTypeManager();
	$result = $inv_mgr->findAll(NULL, NULL, $_SESSION["station_id"]);
	return $result;
}

function findTotalSupplyByInventoryType($inv_types) {
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
	foreach ($inv_types as $key => $value) {
		$outputs = $inv_mgr->findTotalSupplyByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if (empty($outputs) ) {
			$outputs = 0;
		}
		$result = array_merge($result, array ($value->getInvType() => $outputs));

	}
	return $result;
}
function findLastMonthStockByInventoryType($inv_types) {
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
			$LAST_MONTH_END_DATE = date("Y-m-d", $smt - $aDay/**($start_day > 1 ? ($smt) : ($smt- $aDay)) */);
			$LAST_MONTH_START_DATE = "";
		}
	}
	$result = array ();
	foreach ($inv_types as $key => $value) {
			
		$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
		$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
		$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
		$losses = $inv_output_mgr->findTotalLossesOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
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
		//LogManager :: LOG('findLastMonthStockByInventoryType('.$value->getInvType().') = '
		//.$LAST_MONTH_START_DATE.'|'.$LAST_MONTH_END_DATE.', type='.$input_type.'->'.$supply.'-('. $outputs.'+'.$ownuse.'+'.$losses.')='.$last_month_stock);
		$result = array_merge($result, array ($value->getInvType() => $last_month_stock));

	}

	return $result;
}


function findLastStockByInventoryType($inv_types) {
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
			$smt = mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], $start_day, (int) @$_POST["StartDate_Year"]);
			$START_DATE = date("Y-m-d", $smt/** ($start_day > 1 ? ($smt + $aDay) : $smt) */);
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) @$_POST["EndDate_Day"], (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();
	$lastMonthStockArr = findLastMonthStockByInventoryType($inv_types);
	foreach ($inv_types as $key => $value) {

		// this month stock
		$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		$losses = $inv_output_mgr->findTotalLossesOutputByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
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

		$last_month_stock = $lastMonthStockArr[$value->getInvType()];

		$esupply =  bcadd($supply, $last_month_stock);
		//LogManager :: LOG('last month stock='.$last_month_stock);
		$last_stock_calc = bcsub($esupply, bcadd($outputs, bcadd($ownuse, $losses)));
		//LogManager :: LOG('findLastStockByInventoryType('.$value->getInvType().') = '.$START_DATE.'|'
		//.$END_DATE.', type='.$input_type.'->'
		//.$esupply.'-('. $outputs.'+'.$ownuse.'+'.$losses.')='.$last_stock_calc);
		$result = array_merge($result, array ($value->getInvType() => $last_stock_calc));
	}

	return $result;
}

function findRealStockByInventoryType($inv_types) {
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
		
		
		$total_real_stock = $rs_mgr->findTotalQuantityByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);

		if (empty ($total_real_stock)) {
			$total_real_stock = 0;
		}
		
		$result = array_merge($result, array ($value->getInvType() => $total_real_stock));

	}
	return $result;
}


?>