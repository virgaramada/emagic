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
require_once 'libs/log-1.9.11/Log.php';
class LogManager {

	public static function LOG($msg, $log_name='SIKOPIS') {
		$datePattern = "d-m-Y-H";
		$today = date($datePattern);
		$file_name = 'logs/sikopis_'.$today.'.log';


		if (!file_exists($file_name)) {
			touch($file_name);
			//file_put_contents($file_name, ""); 
			fopen($file_name, 'rw');
		}

		$conf = array('mode' => 0600, 'timeFormat' => '%b %d %H:%M:%S', 'lineFormat' => '%1$s %2$s [%3$s] %4$s');
		$logger = &Log::singleton('file', $file_name, $log_name, $conf);

		$logger->log($msg);
		$logger->close();
		$lastHour = date($datePattern, mktime(((int) date("H")) - 1, 0, 0, ((int) date("m")), date("d"), (int) date("Y")));
		$fn = 'logs/sikopis_'.$lastHour.'.log';
		if (file_exists($fn)){
			LogManager::gzipFile($fn,9, false);
			unlink($fn);
		}
		

	}

	public static function gzipFile($src, $level = 5, $dest = false){
		if($dest == false){
			$dest = $src.".gz";
		}
		if(file_exists($src)){
			$filesize = filesize($src);
			$src_handle = fopen($src, "r");
			if(!file_exists($dest)){
				$dst_handle = gzopen($dest, "w$level");
				while(!feof($src_handle)){
					$chunk = fread($src_handle, 2048);
					gzwrite($dst_handle, $chunk);
				}
				fclose($src_handle);
				gzclose($dst_handle);
				return true;
			} else {
				//error_log("$dest already exists");
			}
		} else {
			//error_log("$src doesn't exist");
		}
		return false;
	}
}
?>
