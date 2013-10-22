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
class UserRole {

	private $user_id = NULL;
	private $user_name = '';
	private $user_password = '';
	private $user_role = '';
	private $first_name = '';
	private $last_name = '';
	private $station_id = NULL;
	private $email_address = NULL;
	private $account_activated = "true";
	public function __construct() {
	}

	public final function getUserId() {
		return (int) $this->user_id;
	}
	public final function setUserId($user_id) {
		$this->user_id = (int) $user_id;
	}

	public final function getUsername() {
		return (string) $this->user_name;
	}
	public final function setUsername($user_name) {
		$this->user_name = (string) $user_name;
	}

	public final function getUserPassword() {
		return (string) $this->user_password;
	}
	public final function setUserPassword($user_password) {
		$this->user_password = (string) $user_password;
	}

	public final function getUserRole() {
		return (string) $this->user_role;
	}
	public final function setUserRole($user_role) {
		$this->user_role = (string) $user_role;
	}

	public final function getFirstName() {
		return (string) $this->first_name;
	}
	public final function setFirstName($first_name) {
		$this->first_name = (string) $first_name;
	}

	public final function getLastName() {
		return (string) $this->last_name;
	}
	public final function setLastName($last_name) {
		$this->last_name = (string) $last_name;
	}
	public final function setStationId($station_id) {
		$this->station_id = (string) $station_id;
	}
	public final function getStationId() {
		return (string) $this->station_id;
	}

	public final function getEmailAddress() {
		return (string) $this->email_address;
	}
	public final function setEmailAddress($email_address) {
		$this->email_address = (string) $email_address;
	}
	
    public final function isAccountActivated() {
		return (string) $this->account_activated;
	}
	public final function setAccountActivated($account_activated) {
		$this->account_activated = (string) $account_activated;
	}
	public final function toString() {
		$buffer = 'UserRole[user_id='.$this->user_id
		.', user_name='.$this->user_name
		.', user_role='.$this->user_role
		.', first_name='.$this->first_name
		.', last_name='.$this->last_name
		.', station_id='.$this->station_id
		.', email_address='.$this->email_address
		.']';
		return $buffer;
	}
}
?>
