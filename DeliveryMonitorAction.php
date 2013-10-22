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
//require_once 'Spreadsheet/Excel/Writer.php';

//define("IS_DEBUG", false);
//define("IS_CACHING", false);


monitor();
		

function monitor() {
	$tpl_engine = TemplateEngine::getEngine();
	//$tpl_engine->caching = IS_CACHING;
	//$tpl_engine->debugging = IS_DEBUG;
	$dr_mgr = new DeliveryRealisationManager();

	$dist_loc_list = $dr_mgr->findAllRealisedDistLoc();
	$errors = array ();


	if ($dist_loc_list == NULL || sizeof($dist_loc_list)==0){
		$errors = array_merge($errors, array ("dist_loc_list" => "Belum ada pengiriman untuk wilayah penyaluran yang dipilih"));
	} else {
		$tpl_engine->assign("dist_loc_list", $dist_loc_list);
	}

	$gas_stations = $dr_mgr->findAllRealisedGasStation();
	$tpl_engine->assign("gas_stations", $gas_stations);

	$inv_type_list = $dr_mgr->findAllRealisedInventoryType();

	
	if ($inv_type_list == NULL || sizeof($inv_type_list) == 0){
		$errors = array_merge($errors, array ("inv_type_list" => "Belum ada pengiriman untuk tipe inventory yang dipilih"));
	} else {
		$tpl_engine->assign("inv_type_list", $inv_type_list);
	}
	if ($inv_type_list != NULL && sizeof($inv_type_list) > 0 && $dist_loc_list != NULL && sizeof($dist_loc_list) > 0 ) {

		$deliveryRealisationPageNumber = @ $_REQUEST['deliveryRealisationPage'];

		$totalDeliveryRealisation = (int) $dr_mgr->countAll();
		if (empty ($deliveryRealisationPageNumber)) {
			$deliveryRealisationPageNumber = 1;
		}
		$dr_itemsPerPage = 10;
		$dr_PaginateIt = new PaginateIt();
		$dr_PaginateIt->SetItemsPerPage($dr_itemsPerPage);
		$dr_PaginateIt->SetItemCount($totalDeliveryRealisation);
		$dr_PaginateIt->SetQueryStringVar('deliveryRealisationPage');

		$dr_pageIndex = ((int) $deliveryRealisationPageNumber * $dr_itemsPerPage - $dr_itemsPerPage);
		if ($dr_pageIndex > $totalDeliveryRealisation) {
			$dr_pageIndex = 0;
		}

		$delivery_realisation_list = $dr_mgr->findByDeliveryDate($dr_pageIndex, $dr_itemsPerPage, NULL, date("Y-m-d"));
		
		$tpl_engine->assign("paginatedDeliveryRealisationList", $dr_PaginateIt->GetPageLinks());
		$tpl_engine->assign("delivery_realisation_list", $delivery_realisation_list);
		$tpl_engine->assign("totalDeliveryRealisation", $totalDeliveryRealisation);
		$tpl_engine->assign("numberOfItemPerPage", $dr_itemsPerPage);
	}
	if ($errors != NULL && sizeof($errors) > 0) {
		$tpl_engine->assign("errors", $errors);
	}

	$tpl_engine->display('delivery_monitor.tpl');

}

?>