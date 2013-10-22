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
require_once 'classes/SalesReportManager.class.php';
require_once 'classes/InventoryMarginManager.class.php';
require_once 'vo/InventoryMargin.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'vo/InventoryType.class.php';
require_once 'classes/InventoryOutputManager.class.php';
require_once 'vo/InventoryOutput.class.php';
require_once 'classes/InventorySupplyManager.class.php';
require_once 'classes/InventoryCustomerManager.class.php';
require_once 'classes/OverheadCostManager.class.php';
require_once 'vo/OverheadCost.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/RealStockManager.class.php';
require_once 'classes/InventoryPriceManager.class.php';

//define("IS_DEBUG", false);
//define("IS_CACHING", false);

if (empty ($_REQUEST['PHPSESSID'])) {
	$tpl_engine = TemplateEngine::getEngine();
	//$tpl_engine->caching = IS_CACHING;
	//$tpl_engine->debugging = IS_DEBUG;
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
	    //$tpl_engine->caching = IS_CACHING;
	    //$tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("station_id" => "SPBU tidak dikenal!"));
		$tpl_engine->display('login.tpl');
	}
	else if (isset ($_SESSION['user_role'])) {
		if ($_SESSION['user_role'] != 'ADM' && $_SESSION['user_role'] != 'SUP' && $_SESSION['user_role'] != 'SUP' && $_SESSION['user_role'] != 'OWN' && $_SESSION['user_role'] != 'USE' && $_SESSION['user_role'] != 'OPE') {
			$tpl_engine = TemplateEngine::getEngine();
	        //$tpl_engine->caching = IS_CACHING;
	        //$tpl_engine->debugging = IS_DEBUG;
			$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk melihat data pelaporan"));
			$tpl_engine->display('login.tpl');
		} else {
			$tpl_engine = TemplateEngine::getEngine();
	        //$tpl_engine->caching = IS_CACHING;
	        //$tpl_engine->debugging = IS_DEBUG;

			findTotalSales($tpl_engine);
			findSalesByInventoryType($tpl_engine);
			findTotalOwnUseOutput($tpl_engine);
			findTotalLossesOutput($tpl_engine);
			findAllOwnUseSales($tpl_engine);
			//findAllLosses($tpl_engine);
			findAllOverheadCost($tpl_engine);
			$input_type = @ $_REQUEST["type"];
			if ($input_type == 'SEARCH') {
				$tpl_engine->display('search_sales.tpl');
			} else {
				$tpl_engine->display('sales_report.tpl');
			}

		}
	} else {
		$tpl_engine = TemplateEngine::getEngine();
	        //$tpl_engine->caching = IS_CACHING;
	       // $tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');
	}

}
function findSalesByInventoryType($tpl_engine) {
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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}
	$sales_report = new SalesReportManager();
	$inv_types = findAllInventoryType();
	if ($inv_types != NULL && sizeof($inv_types) > 0) {
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
		if ($inv_margins != NULL && sizeof($inv_margins) > 0) {
		    $tpl_engine->assign("total_margin_inventory", $inv_margins);
		}
		$tpl_engine->assign("total_sales_inventory", $result);
		$inv_supply = findTotalSupplyByInventoryType($inv_types);

		$tpl_engine->assign("inv_supply", $inv_supply);
		$total_ownuse_sales_inventory = findOwnUseSalesByInventoryType($inv_types);
		$tpl_engine->assign("total_ownuse_sales_inventory", $total_ownuse_sales_inventory);
		$ownuse_outputs = findOwnUseOutputByInventoryType($inv_types);
		$tpl_engine->assign("total_ownuse_output_inventory", $ownuse_outputs);

		// Losses
		$total_losses_inventory = findLossesByInventoryType($inv_types);
		$tpl_engine->assign("total_losses_inventory", $total_losses_inventory);
		$losses_outputs = findLossesOutputByInventoryType($inv_types);
		$tpl_engine->assign("total_losses_output_inventory", $losses_outputs);

		$cust_types = findAllCustomer();
		$tpl_engine->assign("cust_types", $cust_types);

		$real_stock_list = findRealStockByInventoryType($inv_types);
		$tpl_engine->assign("real_stock_list", $real_stock_list);
	}
	

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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();

	foreach ($inv_types as $key => $value) {
		$total_sales = $sales_report->calculateOwnUseSalesByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if (!empty ($total_sales)) {
			$result = array_merge($result, array ($value->getInvType() => $total_sales));
		}
	}
	return $result;
}

function findLossesByInventoryType($inv_types) {
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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();

	foreach ($inv_types as $key => $value) {
		$total_sales = $sales_report->calculateLossesByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if (empty ($total_sales)) {
			$total_sales = 0;
		}
		$result = array_merge($result, array ($value->getInvType() => $total_sales));
	}
	return $result;
}

function findTotalSales($tpl_engine) {
	$input_type = @ $_REQUEST["type"];
	$sales_report = new SalesReportManager();
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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
			$ACTUAL_DATE = date("d/m/Y", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]))
			.'-' .date("d/m/Y", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}

	$total_sales = $sales_report->calculateAllSales($START_DATE, $END_DATE, $_SESSION["station_id"]);
	$tpl_engine->assign("total_sales", $total_sales);
	//if (empty($total_sales) && !empty ($input_type)) {
		//$tpl_engine->clear_all_assign();
		//$tpl_engine->assign("errors", array ("total_sales" => "Belum ada penjualan untuk ". $START_DATE." s.d. ".$END_DATE));
		
	//}
	$tpl_engine->assign("actual_date", $ACTUAL_DATE);
	$gas_types = findAllGas();
	$tpl_engine->assign("gas_types", $gas_types);

	$lub_types = findAllLubricants();
	$tpl_engine->assign("lub_types", $lub_types);
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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}
	$total_sales = $sales_report->calculateAllOwnUseSales($START_DATE, $END_DATE, $_SESSION["station_id"]);
	$tpl_engine->assign("total_ownuse_sales", $total_sales);
}

function findAllLosses($tpl_engine) {
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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}
	$total_sales = $sales_report->calculateAllLosses($START_DATE, $END_DATE, $_SESSION["station_id"]);
	$tpl_engine->assign("total_losses", $total_sales);
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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();
	foreach ($inv_types as $key => $value) {
		$outputs = $inv_mgr->findOwnUseByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if (!empty ($outputs)) {
			$result = array_merge($result, $outputs);
		}
	}
	return $result;

}

function findLossesOutputByInventoryType($inv_types) {
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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}
	$result = array ();
	foreach ($inv_types as $key => $value) {
		$outputs = $inv_mgr->findLossesByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if (!empty ($outputs)) {
			$result = array_merge($result, $outputs);
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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}

	$result = array ();
	foreach ($inv_types as $key => $value) {
		$total_margins = $inv_margin->findByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);

		if (($total_margins)) {
			$result = array_merge($result, array ($value->getInvType() => $total_margins));
		}
		
	}
	return $result;
}
function findAllInventoryType() {
	$inv_mgr = new InventoryTypeManager();
	$result = $inv_mgr->findAll(NULL, NULL, $_SESSION["station_id"]);
	return $result;
}

function findTotalSupplyByInventoryType($inv_types) {
	$inv_supply_mgr = new InventorySupplyManager();
	$inv_output_mgr = new InventoryOutputManager();
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];

	$LAST_MONTH_END_DATE = date("Y-m-d", mktime(0, 0, 0, ((int) date("m")), (int) date("d"), (int) date("Y")));
	$LAST_MONTH_START_DATE = date("Y-m-d", mktime(0, 0, 0, ((int) date("m")) - 1, 1, (int) date("Y")));

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
			$LAST_MONTH_END_DATE = date("Y-m-d", mktime(0, 0, 0, ((int) date("m")), (int) date("d") - 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$previous_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, 1, 1, (int) date("Y")));
			$LAST_MONTH_END_DATE = date("Y-m-d", mktime(0, 0, 0, 12, 31, $previous_year));
			$LAST_MONTH_START_DATE = date("Y-m-d", mktime(0, 0, 0, 1, 1, $previous_year));
		}
		if ($input_type == 'SEARCH') {
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));
			$LAST_MONTH_START_DATE = "";
			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
			$LAST_MONTH_END_DATE = $START_DATE;

		}
	}
	$result = array ();
	foreach ($inv_types as $key => $value) {

		$firstSupply = $inv_supply_mgr->findFirstSupply($value->getProductType(), $_SESSION["station_id"]);

		if ($firstSupply && $input_type != 'YEARLY' && $input_type != 'SEARCH') {
			$firstSupplyDate = $firstSupply->getSupplyDate();
			// "d/m/Y"
			list($firstDay, $firstMonth, $firstYear) = split('/', $firstSupplyDate);

			$LAST_MONTH_START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) $firstMonth, (int) $firstDay, (int) $firstYear));
		}

		$lsupply = $inv_supply_mgr->findTotalSupplyByInventoryType($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
		$loutputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
		$lownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
		$losses = $inv_output_mgr->findTotalLossesOutputByInventoryTypeAndDate($value->getInvType(), $LAST_MONTH_START_DATE, $LAST_MONTH_END_DATE, $_SESSION["station_id"]);
		if (empty($lsupply) ) {
			$lsupply = 0;
		}
		if (empty($loutputs) ) {
			$loutputs = 0;
		}
		if (empty($lownuse) ) {
			$lownuse = 0;
		}
		if (empty($losses) ) {
			$losses = 0;
		}

		$last_month_stock = (int) $lsupply - ((int) $loutputs + (int) $lownuse + (int) $losses);
		$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if (empty($supply) ) {
			$supply = 0;
		}
		LogManager :: LOG('findTotalSupplyByInventoryType('.$value->getInvType().') = '.$START_DATE.'|'
		.$END_DATE.' => '.$LAST_MONTH_START_DATE.'|'.$LAST_MONTH_END_DATE.', type='.$input_type);
		$total_supply_calc = (int) $supply + (int) $last_month_stock;
		$result = array_merge($result, array ($value->getInvType() => $total_supply_calc));

	}
	return $result;
}
function findTotalOwnUseOutput($tpl_engine) {
	$output_mgr = new InventoryOutputManager();
	$END_DATE = date("Y-m-d");
	$START_DATE = date("Y-m-d");
	$input_type = @ $_REQUEST["type"];
	$num = 1;
	$one_month = ((int) $num * 24 * 60 * 60);

	if (!empty ($input_type)) {
		if ($input_type == 'MONTHLY') {
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), 1, (int) date("Y")));
		}
		if ($input_type == 'YEARLY') {
			$this_year = ((int) date("Y")) - 1;
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) date("m"), (int) date("d"), $this_year));
		}
		if ($input_type == 'SEARCH') {
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}
	$total_output = $output_mgr->findAllOwnUseOutput($START_DATE, $END_DATE, $_SESSION["station_id"]);
	$tpl_engine->assign("total_ownuse_output", $total_output);
}

function findTotalLossesOutput($tpl_engine) {
	
	$inv_prices = findAllInventoryPrice();
	$inv_types = findAllInventoryType();
	
		
	if ( $inv_prices != NULL && sizeof($inv_prices) > 0 && $inv_types != NULL && sizeof($inv_types) > 0) {
	   $stock_losses = _findStockLossesByInventoryPrice($inv_types, $inv_prices);
	   $tpl_engine->assign("stock_losses", $stock_losses);
	}
	
}
function findAllCustomer() {
	$inv_mgr = new InventoryCustomerManager();
	$result = $inv_mgr->findAll(NULL, NULL, $_SESSION["station_id"]);
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
			$start_day = @$_POST["StartDate_Day"];
			if (strlen($start_day) == 1) {
				$start_day = '0'.$start_day;
			}
			$START_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["StartDate_Month"], (int) $start_day, (int) @$_POST["StartDate_Year"]));

			$end_day = @$_POST["EndDate_Day"];
			if (strlen($end_day) == 1) {
				$end_day = '0'.$end_day;
			}
			$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["EndDate_Month"], (int) $end_day, (int) @$_POST["EndDate_Year"]));
		}
	}

	$ovh_mgr = new OverheadCostManager();
	$result = $ovh_mgr->findAll($START_DATE, $END_DATE, NULL, NULL, $_SESSION["station_id"]);
	$tpl_engine->assign("overhead_cost_list", $result);
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
		$own_use_price = 0;
		$price_by_inv_type = $pr_mgr->findOwnUseByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
		if ($price_by_inv_type != NULL && sizeof($price_by_inv_type) > 0) {
			$own_use_price = $price_by_inv_type[0]->getUnitPrice();
		}
		$total_real_stock = $rs_mgr->findTotalQuantityByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);

		if (empty ($total_real_stock)) {
			$total_real_stock = 0;
		}
		$calculate_real_stock = $total_real_stock * $own_use_price;
		$result = array_merge($result, array ($value->getInvType() => array($total_real_stock => $calculate_real_stock)));

	}
	return $result;
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
					if ($v->getCategory() == 'OWN_USE' && $v->getInvType() == $value->getInvType() ) {
						$own_use_price = $v->getUnitPrice();
				   }
			}

			$supply = $inv_supply_mgr->findTotalSupplyByInventoryType($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
			$outputs = $inv_output_mgr->findTotalOutputByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);
			$ownuse = $inv_output_mgr->findTotalOwnUseOutputByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);

			$losses = $rs_mgr->findTotalQuantityByInventoryTypeAndDate($value->getInvType(), $START_DATE, $END_DATE, $_SESSION["station_id"]);

			
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
						LogManager :: LOG('Last month stock : value='.$a.', in Rp= '.$b);
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
	$rs_mgr = new RealStockManager();

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
		       if ($v->getCategory() == 'OWN_USE' && $v->getInvType() == $value->getInvType() ) {
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

function findAllInventoryPrice() {
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
	
	$inv_mgr = new InventoryPriceManager();
	$result = $inv_mgr->findAllByDate(NULL,NULL,NULL, $_SESSION["station_id"], $START_DATE, $END_DATE);
	return $result;
}
?>
