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

//require_once 'LogManager.class.php';
class ConnectionManager {

	private $usr_name = '';

	private $usr_pwd = '';

	private $server_url = '';

	private $db_name = '';

	public function __construct($server_url, $db_name, $usr_name, $usr_pwd) {
		$this->usr_name = $usr_name;
		$this->usr_pwd = $usr_pwd;
		$this->server_url = $server_url;
		$this->db_name = $db_name;
	}

	public function connect() {
			//LogManager :: LOG('connecting to database server '.$this->server_url);
			$db_connect = @mysql_connect($this->server_url , $this->usr_name, $this->usr_pwd);
			//or die("Could not connect : ".mysql_error());
			// select database
			if ($db_connect) {
				//LogManager ::LOG('connected to server, selecting database '.$this->db_name);
				 $db_select = @mysql_select_db($this->db_name) or die("Could not select database ".$this->db_name);
			}
		return $db_connect;
	}
}

?>