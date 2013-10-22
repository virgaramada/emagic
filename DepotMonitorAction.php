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

require_once 'classes/DeliveryRealisationManager.class.php';
require_once 'classes/StationManager.class.php';
require_once 'classes/InventoryTypeManager.class.php';
require_once 'classes/DistributionLocationManager.class.php';
require_once 'classes/ControllerUtils.class.php';
require_once 'classes/TemplateEngine.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/PaginateIt.class.php';
require_once 'Spreadsheet/Excel/Writer.php';

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

	if (!isset ($_SESSION['user_role'])) {

		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak memiliki role yang memadai untuk mengakses"));
		$tpl_engine->display('login.tpl');

	}
	else if (!empty ($_SESSION['user_role']) && $_SESSION['user_role'] != UserRoleEnum::SUPERUSER && $_SESSION['user_role'] != UserRoleEnum::BPH_MIGAS) {
		$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("errors", array ("user_role" => "Anda tidak punya wewenang untuk melihat depot monitor"));
		$tpl_engine->display('login.tpl');

	}  else {
		$method_type = @ $_REQUEST["method"];
		if ($method_type == "excel_export") {
			exportToExcel();
		} else {
			prepare();
		}

	}
}

function prepare() {
	$tpl_engine = TemplateEngine::getEngine();
	//$tpl_engine->caching = IS_CACHING;
	//$tpl_engine->debugging = IS_DEBUG;
	$dr_mgr = new DeliveryRealisationManager();

	// search params
	$selected_inv_type = @$_REQUEST['inventory_type'];
	$selected_dist_loc_id = @$_REQUEST['dist_loc_id'];

	$dist_loc_list = $dr_mgr->findAllRealisedDistLoc();
	$errors = array ();

	if (isset($selected_dist_loc_id)) {
			
		$dist_mgr =  new DistributionLocationManager();
		$sel_dist_list = $dist_mgr->findByPrimaryKey($selected_dist_loc_id);
			
		if ($sel_dist_list) {
				$dist_loc_list = array();
				$dist_loc_list = array_merge($dist_loc_list, array($sel_dist_list));
		}
	}

	if ($dist_loc_list == NULL || sizeof($dist_loc_list)==0){
		$errors = array_merge($errors, array ("dist_loc_list" => "Belum ada pengiriman untuk wilayah penyaluran yang dipilih"));
	} else {
		$dist_loc_code_list = array();
	    foreach ($dist_loc_list as $key=>$value) {
				$dist_loc_code_list = array_merge($dist_loc_code_list, array($value->getLocationCode()));
		}
		
		 if (empty ($_REQUEST["type"]) && !empty ($_REQUEST['deliveryRealisationPage']) && isset($_SESSION['dist_loc_list']) ) {
			$dist_loc_list = $_SESSION['dist_loc_list'];
		} else  {
			  $_SESSION['dist_loc_list'] = $dist_loc_list;
			}
		
		$tpl_engine->assign("dist_loc_list", $dist_loc_list);
		
		
		
	}

	$dist_locations =  ControllerUtils::findAllDistLocation();
	$tpl_engine->assign("dist_locations", $dist_locations);

	$gas_stations = $dr_mgr->findAllRealisedGasStation();
    $valid_gas_station_by_inv_list = array();
		
    foreach ($gas_stations as $key => $value) {
    	if (in_array($value->getLocationCode(), $dist_loc_code_list)) {
    		$valid_gas_station_by_inv_list =
    		array_merge($valid_gas_station_by_inv_list, array($key=>$value));
    			
    	}
    }

    if (($valid_gas_station_by_inv_list == NULL || sizeof($valid_gas_station_by_inv_list) == 0)) {
    	$errors = array_merge($errors, array ("station_id" => "Tidak ditemukan SPBU yang sesuai dengan kriteria pencarian"));
    		
    } else {
    	
    	
    	 if (empty ($_REQUEST["type"]) && !empty ($_REQUEST['deliveryRealisationPage']) && isset($_SESSION['gas_stations']) ) {
			$valid_gas_station_by_inv_list = $_SESSION['gas_stations'];
		} else  {
			  $_SESSION['gas_stations'] = $valid_gas_station_by_inv_list;
			}
			$tpl_engine->assign("gas_stations", $valid_gas_station_by_inv_list);
    }
		
	$inv_types = ControllerUtils::findAllInventoryType();
	$tpl_engine->assign("inv_types", $inv_types);
	
	$inv_type_list = array();
	if ($valid_gas_station_by_inv_list != NULL && sizeof($valid_gas_station_by_inv_list) > 0) {
		$inv_type_list = $dr_mgr->findAllRealisedInventoryType();
	
		if (isset($selected_inv_type) && !empty($selected_inv_type)) {
				
			$inv_type_mgr = new InventoryTypeManager();
			$selected_inv_list = $inv_type_mgr->findByInventoryType($selected_inv_type);
			
			if ($selected_inv_list != NULL && sizeof($selected_inv_list) > 0) {
	
				$inv_type_list = array();
				$inv_type_list = array_merge($inv_type_list, $selected_inv_list);
			}
		}
	
		if ($inv_type_list == NULL || sizeof($inv_type_list) == 0){
			$errors = array_merge($errors, array ("inv_type_list" => "Belum ada pengiriman untuk tipe inventory yang dipilih"));
		} else {
		     if (empty ($_REQUEST["type"]) && !empty ($_REQUEST['deliveryRealisationPage']) && isset($_SESSION['inv_type_list']) ) {
			    $inv_type_list = $_SESSION['inv_type_list'];
		    } else  {
			    $_SESSION['inv_type_list'] = $inv_type_list;
			}
			$tpl_engine->assign("inv_type_list", $inv_type_list);
			
			
		}
	}
	if ($inv_type_list != NULL && sizeof($inv_type_list) > 0 && $dist_loc_list != NULL && sizeof($dist_loc_list) > 0 ) {

		$deliveryRealisationPageNumber = @ $_REQUEST['deliveryRealisationPage'];

		$END_DATE = date("Y-m-d");
		$START_DATE = date("Y-m-d");
		$input_type = @ $_REQUEST["type"];
		$aDay = 60 * 60 * 24;
		if (!empty ($input_type) && $input_type == 'SEARCH') {

			
				$start_day = (int) @$_POST["Delivery_StartDate__Day"];
				$smt = mktime(0, 0, 0, (int) @$_POST["Delivery_StartDate__Month"], $start_day, (int) @$_POST["Delivery_StartDate__Year"]);
				$START_DATE = date("Y-m-d", $smt);
				$END_DATE = date("Y-m-d", mktime(0, 0, 0, (int) @$_POST["Delivery_EndDate_Month"], (int) @$_POST["Delivery_EndDate_Day"], (int) @$_POST["Delivery_EndDate_Year"]));
			
				
			$delivery_realisation_list = $dr_mgr->findByDeliveryDate(NULL, NULL, $START_DATE, $END_DATE);
		} else if (empty ($deliveryRealisationPageNumber) ){
			$delivery_realisation_list = $dr_mgr->findAll();
		} else {
			$delivery_realisation_list = $_SESSION['delivery_realisation_list'];
		}
		
         $delivery_realisation_list_new  = array();  
         foreach ($valid_gas_station_by_inv_list as $dkey=>$dvalue) {
			  foreach ($inv_type_list as $ikey=>$ivalue) {
			     foreach ($delivery_realisation_list as $lkey=>$lvalue) {
					 
					     if ($ivalue->getInvType() == $lvalue->getInvType() && $dvalue->getStationId() == $lvalue->getStationId()) {
							   $delivery_realisation_list_new =
    		                   array_merge($delivery_realisation_list_new, array($lkey=>$lvalue));
					      }
					 }
			  }
		}
		
		$_SESSION['delivery_realisation_list'] = $delivery_realisation_list_new;
		$_SESSION['session_delivery_realisation_list'] = $delivery_realisation_list_new;
		$totalDeliveryRealisation = sizeof($delivery_realisation_list_new);
		
		if (empty ($deliveryRealisationPageNumber)) {
			$deliveryRealisationPageNumber = 1;
		}
		$dr_itemsPerPage = 10;
		$dr_PaginateIt = new PaginateIt();
		$dr_PaginateIt->SetItemsPerPage($dr_itemsPerPage);
		$dr_PaginateIt->SetItemCount($totalDeliveryRealisation);
		$dr_PaginateIt->SetQueryStringVar('deliveryRealisationPage');

		$dr_pageIndex = ((int) $deliveryRealisationPageNumber * $dr_itemsPerPage) - $dr_itemsPerPage;
		if ($dr_pageIndex > $totalDeliveryRealisation) {
			$dr_pageIndex = 0;
		}
		
		// sub array
		$delivery_realisation_list_sub = array();
		if (sizeof($delivery_realisation_list_new) > 0) {
			$idx=0;
			foreach ($delivery_realisation_list_new as $ky=>$vl) {
				
				if ((int)$idx >= $dr_pageIndex && (int)$idx <= $dr_itemsPerPage) {
					 $delivery_realisation_list_sub =
								   array_merge($delivery_realisation_list_sub, array($ky=>$vl));
					}
			    $idx++;
			 }
        }
         
		if (sizeof($delivery_realisation_list_sub) > 0) {
			 $tpl_engine->assign("delivery_realisation_list", $delivery_realisation_list_sub);
			 //$_SESSION['session_delivery_realisation_list'] = $delivery_realisation_list_sub;
		} else {
				$tpl_engine->assign("delivery_realisation_list", $delivery_realisation_list_new);
		}
		

		$tpl_engine->assign("paginatedDeliveryRealisationList", $dr_PaginateIt->GetPageLinks());
	}
	if ($errors != NULL && sizeof($errors) > 0) {
		$tpl_engine->assign("errors", $errors);
	}

	$tpl_engine->display('depot_monitor.tpl');

}


function exportToExcel() {
	$dr_mgr = new DeliveryRealisationManager();
	$st_mgr = new StationManager();
	$inv_mgr = new InventoryTypeManager();
	$dist_mgr = new DistributionLocationManager();
	
	
	$delivery_realisation_list =  $_SESSION['session_delivery_realisation_list'];
	if ($delivery_realisation_list == NULL || sizeof($delivery_realisation_list) <=0) {
	    $delivery_realisation_list = $dr_mgr->findAll();
	}
	
	// Creating a workbook
	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->send('depot_monitor.xls');
	$worksheet1 =& $workbook->addWorksheet('depot_monitor');
	// Set header formating for Sheet 1
	$header =& $workbook->addFormat();
	$header->setBold();		// Make it bold
	$header->setColor('white');	// Make foreground color black
	$header->setFgColor("green");	// Set background color to green
	$header->setHAlign('center');	// Align text to center

	$total_quantity = 0;
	$row = 0;
	$col = 0;

	// Write some data on Sheet 1
	$worksheet1->write($row, 0, 'No SPBU', $header);

	$worksheet1->write($row, 1, 'No SO', $header);

	$worksheet1->write($row, 2, 'Alamat SPBU', $header);

	$worksheet1->write($row, 3, 'Jumlah (Ltr)', $header);

	$worksheet1->write($row, 4, 'No Mobil', $header);

	$worksheet1->write($row, 5, 'Nama Driver', $header);

	$worksheet1->write($row, 6, 'Tgl Kirim', $header);

	$worksheet1->write($row, 7, 'Shift', $header);

	$worksheet1->write($row, 8, 'Type BBM', $header);

	$worksheet1->write($row, 9, 'Wilayah Penyaluran', $header);

	$worksheet1->write($row, 10, 'Keterangan', $header);


	foreach($delivery_realisation_list as $key=>$value) {
		$station = $st_mgr->findByPrimaryKey($value->getStationId());
		$inv = $inv_mgr->findByInventoryType($value->getInvType());
		$dist_loc = $dist_mgr->findByCode($station->getLocationCode());

		$row++;
		$col = 0;
		$worksheet1->write($row, $col, $value->getStationId());
		$col++;
		$worksheet1->write($row, $col, $value->getSalesOrderNumber());
		$col++;
		$worksheet1->write($row, $col, $station->getStationAddress());
		$col++;
		$worksheet1->write($row, $col, $value->getQuantity());
		$col++;
		$worksheet1->write($row, $col, $value->getPlateNumber());
		$col++;
		$worksheet1->write($row, $col, $value->getDriverName());
		$col++;
		$worksheet1->write($row, $col, $value->getDeliveryDate() .", ". $value->getDeliveryTime());
		$col++;
		$worksheet1->write($row, $col, $value->getDeliveryShiftNumber());

		$total_quantity = bcadd($total_quantity, $value->getQuantity());

		$inv_desc = "";
		foreach ($inv as $k=>$v) {
			$inv_desc = $v;
		}
		$col++;
		$worksheet1->write($row, $col, $inv_desc->getInvDesc());
		$col++;
		$worksheet1->write($row, $col, $dist_loc->getLocationName());
		$col++;
		$worksheet1->write($row, $col, $value->getDeliveryMessage());

	}
	$hdr =& $workbook->addFormat();
	$hdr->setBold();		// Make it bold
	$worksheet1->write($row + 1, 0, "TOTAL", $hdr);
	$worksheet1->write($row + 1, 3, number_format($total_quantity, 2, ',','.'), $hdr);

	// Send the file to the browser
	$workbook->close();
}

?>
