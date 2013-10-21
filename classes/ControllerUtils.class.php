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

/**
 * Utility action class. Defines common methods/functions use in XXXAction.php.
 *
 */
require_once 'classes/InventoryTypeManager.class.php';
require_once 'classes/InventoryCustomerManager.class.php';
require_once 'classes/LogManager.class.php';
require_once 'classes/DistributionLocationManager.class.php';
require_once 'classes/StationManager.class.php';
require_once 'classes/Constants.class.php';

class ControllerUtils {

	/**
	 * finds all inventory type (Gas/BBM).
	 *
	 * @return array of inventory type
	 */
	public static function findAllInventoryType($product_type="BBM") {
		LogManager::LOG("Find all inventory of product type ".$product_type);
		$inv_mgr = new InventoryTypeManager();
		$inv_types = $inv_mgr->findByProductType($product_type);
		return $inv_types;
	}
	/**
	 * finds all distribution location.
	 *
	 * @return array of distibution location
	 */
	public static function findAllDistLocation() {
		LogManager::LOG("Find all distribution location");
		$dist_mgr = new DistributionLocationManager();
		return $dist_mgr->findAll();
	}
	/**
	 * finds all customers.
	 *
	 * @return array of customers
	 */
	public static function findAllCustomer() {
		LogManager::LOG("Find all customers");
		$inv_mgr = new InventoryCustomerManager();
		return $inv_mgr->findAll();
	}
		
    /**
	  * finds all station.
	  *
	  * @return array of distibution location
	  */
	 public static function findAllStation() {
	 	LogManager::LOG("Find all station");
		$station_mgr = new StationManager();
		return $station_mgr->findAll();
	}

    public static function findGasStationByInventoryType($inv_types) {
		$result = NULL;
		$station_mgr = new StationManager();
		if (($inv_types != NULL && sizeof($inv_types) > 0)) {
			$result = array ();
			foreach ($inv_types as $key => $value) {
				$list_of_station = $station_mgr->findByInventoryType($value->getInvType());
				if (($list_of_station != NULL && sizeof($list_of_station) > 0)) {
					$result = array_merge($result, array ($value->getInvType() => $list_of_station));
				}
			}
		}

		return $result;
	}
	/**
	public static function findGasStationByAllInventoryType() {
		$result = NULL;
		$station_mgr = new StationManager();

		$result = array ();
			
		$list_of_station = $station_mgr->findByAllInventoryType();
		
		if (($list_of_station != NULL && sizeof($list_of_station) > 0)) {
			//$result = array_merge($result, $list_of_station);
			return $list_of_station;
		}
			
		return $result;
	} */
	public static function getInventoryTypeGasStationKey($gas_station_by_inv_type_list) {
		$result = NULL;
		if (($gas_station_by_inv_type_list != NULL && sizeof($gas_station_by_inv_type_list) > 0)) {
			$result = array ();
			foreach ($gas_station_by_inv_type_list as $key => $value) {
				for ($ii=0; $ii < sizeof($value); $ii++) {
					// create inventory type, gas station key list (result =  array of $invType_$gasStationId)
					$result = array_merge($result, array ($key .Constants::_UNDERSCODE_SYMBOL .$value[$ii]->getStationId()));
				}

			}
		}

		return $result;
	}
	public static function checkArray($array_f, $array_l) {
		foreach ($array_f as $key=>$value) {
			foreach($array_l as $k=>$v) {
				if ($value == $v) {
					return TRUE;
				}
			}
		}

		return FALSE;
	}
	
}
?>