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
require_once 'DBManager.class.php';
require_once 'UserRoleEnum.class.php';
require_once 'vo/UserRole.class.php';
require_once 'LogManager.class.php';
class UserManager {

	public function create(UserRole $input) {
		$q = "INSERT INTO INV_MGT_USER_ROLE (USER_NAME, USER_PASSWORD, USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED) "
		." VALUES (?1, ?2, ?3, ?4, ?5, ?6, ?7, ?8)";
		$insert_id = 0;
		try {
			if (empty($input) ) {
				die("Invalid UserRole parameter.");
			}
			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6", "?7", "?8");
			$input_var = array ("'".$input->getUsername()."'",
			                    "'".hash("sha256", $input->getUserPassword())."'", 
			                    "'".$input->getUserRole()."'", "'".$input->getFirstName()."'", 
			                    "'".$input->getLastName()."'", "'".$input->getStationId()."'",
			                    "'".$input->getEmailAddress()."'", 
			                    "'".($input->isAccountActivated() == "true" ? "Y" : "N")."'");
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$insert_id = mysql_insert_id();
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while inserting data into database : ".$e);
		}

		return $insert_id;
	}
	public function findByPrimaryKey($user_id) {
		$result = NULL;
		try {
			$q = "SELECT ID, USER_NAME, "
			." USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED FROM INV_MGT_USER_ROLE WHERE ID = ?1";
			$q = str_replace("?1", $user_id, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$vo = new UserRole();
				$vo->setUserId($row['ID']);
				$vo->setUsername($row['USER_NAME']);
				
				$vo->setUserRole($row['USER_ROLE']);
				$vo->setFirstName($row['FIRST_NAME']);
				$vo->setLastName($row['LAST_NAME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setEmailAddress($row['EMAIL_ADDRESS']);
				$vo->setAccountActivated(($row['ACCOUNT_ACTIVATED'] == "Y" ? "true" : "false"));
				
				$result = $vo;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find User by its id : ".$e);
		}

		return $result;
	}


	public function userLogin($user_name, $user_password, $station_id=NULL) {
		$result = NULL;
		try {
			if (empty($user_name)) {
				die("User name must be specified");
			}
			if (empty($user_password)){
				die("User password must be specified");
			}

			$q = "SELECT ID, USER_NAME, "
			." USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED FROM INV_MGT_USER_ROLE WHERE USER_NAME = ?1 AND USER_PASSWORD = ?2 AND ACCOUNT_ACTIVATED = 'Y'";
			$q_pr = array ("?1", "?2");
			$input_var = array ("'".$user_name."'", "'".hash("sha256", $user_password)."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}

			$q = $q ." ORDER BY ID DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$vo = new UserRole();
				$vo->setUserId($row['ID']);
				$vo->setUsername($row['USER_NAME']);
				
				$vo->setUserRole($row['USER_ROLE']);
				$vo->setFirstName($row['FIRST_NAME']);
				$vo->setLastName($row['LAST_NAME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setEmailAddress($row['EMAIL_ADDRESS']);
				$vo->setAccountActivated(($row['ACCOUNT_ACTIVATED'] == "Y" ? "true" : "false"));
				
				$result = $vo;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find User by login name : ".$e);
		}
		return $result;
	}
	public function findByUserName($user_name, $user_password=NULL, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT ID, USER_NAME, "
			." USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED FROM INV_MGT_USER_ROLE WHERE USER_NAME = ?1";
			$q_pr = array ("?1");
			$input_var = array ("'".$user_name."'");
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($user_password)) {
				$q = "SELECT ID, USER_NAME, "
				." USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED FROM INV_MGT_USER_ROLE WHERE USER_NAME = ?1 AND USER_PASSWORD = ?2";
				$q_pr = array ("?1", "?2");
				$input_var = array ("'".$user_name."'", "'".hash("sha256", $user_password)."'");
				$q = str_replace($q_pr, $input_var, $q);
			}

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q ." ORDER BY ID DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$vo = new UserRole();
				$vo->setUserId($row['ID']);
				$vo->setUsername($row['USER_NAME']);
				
				$vo->setUserRole($row['USER_ROLE']);
				$vo->setFirstName($row['FIRST_NAME']);
				$vo->setLastName($row['LAST_NAME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setEmailAddress($row['EMAIL_ADDRESS']);
				
				$vo->setAccountActivated(($row['ACCOUNT_ACTIVATED'] == "Y" ? "true" : "false"));
				
				$result = $vo;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find User by login name : ".$e);
		}
		return $result;
	}
	public function findByUserNameAndRole($user_name, $user_role, $station_id=NULL) {
		$result = NULL;
		try {
			$q = "SELECT ID, USER_NAME, "
			." USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED FROM INV_MGT_USER_ROLE WHERE USER_NAME = ?1 AND USER_ROLE = ?2 ";
			$q_pr = array ("?1", "?2");
			$input_var = array ("'".$user_name."'", "'".$user_role."'");
			$q = str_replace($q_pr, $input_var, $q);
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY ID DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$vo = new UserRole();
				$vo->setUserId($row['ID']);
				$vo->setUsername($row['USER_NAME']);
				
				$vo->setUserRole($row['USER_ROLE']);
				$vo->setFirstName($row['FIRST_NAME']);
				$vo->setLastName($row['LAST_NAME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setEmailAddress($row['EMAIL_ADDRESS']);
				$vo->setAccountActivated(($row['ACCOUNT_ACTIVATED'] == "Y" ? "true" : "false"));
				
				$result = $vo;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find User by login and role : ".$e);
		}
		return $result;
	}
	public function findByUserRole($user_role, $station_id=NULL) {
		$result = NULL;
		try {
		    if (empty($user_role)) {
				die("User Role must be specified");
			}
			$q = "SELECT ID, USER_NAME, " 
			." USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED FROM INV_MGT_USER_ROLE WHERE USER_ROLE = ?1 ";
			$q = str_replace("?1", "'".$user_role."'", $q);

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY ID DESC";
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();
			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			if ($row) {
				$vo = new UserRole();
				$vo->setUserId($row['ID']);
				$vo->setUsername($row['USER_NAME']);
				
				$vo->setUserRole($row['USER_ROLE']);
				$vo->setFirstName($row['FIRST_NAME']);
				$vo->setLastName($row['LAST_NAME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setEmailAddress($row['EMAIL_ADDRESS']);
				$vo->setAccountActivated(($row['ACCOUNT_ACTIVATED'] == "Y" ? "true" : "false"));
				
				$result = $vo;
			}

			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find User by role : ".$e);
		}
		return $result;
	}
	public function findAll($pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT ID, USER_NAME, " 
			." USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED FROM INV_MGT_USER_ROLE WHERE 1=1" 
			." AND USER_ROLE <> '".UserRoleEnum::SUPERUSER."'"
			." AND USER_ROLE <> '".UserRoleEnum::POWER_USER."'"
			." AND USER_ROLE <> '".UserRoleEnum::DEPOT."'"
			." AND USER_ROLE <> '".UserRoleEnum::BPH_MIGAS."'"
			." AND USER_ROLE <> '".UserRoleEnum::PERTAMINA."'";

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY ID DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new UserRole();
				$vo->setUserId($row['ID']);
				$vo->setUsername($row['USER_NAME']);
				
				$vo->setUserRole($row['USER_ROLE']);
				$vo->setFirstName($row['FIRST_NAME']);
				$vo->setLastName($row['LAST_NAME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setEmailAddress($row['EMAIL_ADDRESS']);
				$vo->setAccountActivated(($row['ACCOUNT_ACTIVATED'] == "Y" ? "true" : "false"));
				$results[$count] = $vo;
				$count ++;
			}
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Users : ".$e);
		}
		return $results;
	}
	
	
  public function _findAllUsersNoSuperuser($pageIndex=NULL, $linePerPage=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT ID, USER_NAME, " 
			." USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED FROM INV_MGT_USER_ROLE WHERE 1=1"
			." AND USER_ROLE <> '".UserRoleEnum::SUPERUSER."'";

		
			$q = $q . " ORDER BY ID DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new UserRole();
				$vo->setUserId($row['ID']);
				$vo->setUsername($row['USER_NAME']);
				
				$vo->setUserRole($row['USER_ROLE']);
				$vo->setFirstName($row['FIRST_NAME']);
				$vo->setLastName($row['LAST_NAME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setEmailAddress($row['EMAIL_ADDRESS']);
				$vo->setAccountActivated(($row['ACCOUNT_ACTIVATED'] == "Y" ? "true" : "false"));
				$results[$count] = $vo;
				$count ++;
			}
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Users : ".$e);
		}
		return $results;
	}
	
 public function _findAllUsers($pageIndex=NULL, $linePerPage=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT ID, USER_NAME, " 
			." USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED FROM INV_MGT_USER_ROLE WHERE 1=1";

		
			$q = $q . " ORDER BY ID DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new UserRole();
				$vo->setUserId($row['ID']);
				$vo->setUsername($row['USER_NAME']);
				
				$vo->setUserRole($row['USER_ROLE']);
				$vo->setFirstName($row['FIRST_NAME']);
				$vo->setLastName($row['LAST_NAME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setEmailAddress($row['EMAIL_ADDRESS']);
				$vo->setAccountActivated(($row['ACCOUNT_ACTIVATED'] == "Y" ? "true" : "false"));
				$results[$count] = $vo;
				$count ++;
			}
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Users : ".$e);
		}
		return $results;
	}

	public function countAll($station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_USER_ROLE WHERE 1=1"
			." AND USER_ROLE <> '".UserRoleEnum::SUPERUSER."'"
			." AND USER_ROLE <> '".UserRoleEnum::POWER_USER."'"
			." AND USER_ROLE <> '".UserRoleEnum::DEPOT."'"
			." AND USER_ROLE <> '".UserRoleEnum::BPH_MIGAS."'"
			." AND USER_ROLE <> '".UserRoleEnum::PERTAMINA."'";
			
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			$row = mysql_fetch_row($rs);
			if ($row) {
				$result = $row[0];
			}
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Users : ".$e);
		}
		return $result;
	}
    public function countAllUsersNoSuperuser() {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_USER_ROLE WHERE 1=1"
			." AND USER_ROLE <> '".UserRoleEnum::SUPERUSER."'";
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			$row = mysql_fetch_row($rs);
			if ($row) {
				$result = $row[0];
			}
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Users : ".$e);
		}
		return $result;
	}
    public function countAllUsers() {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_USER_ROLE WHERE 1=1";
			
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			$row = mysql_fetch_row($rs);
			if ($row) {
				$result = $row[0];
			}
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Users : ".$e);
		}
		return $result;
	}
	public function update(UserRole $input) {
		$q = "UPDATE INV_MGT_USER_ROLE SET USER_NAME = ?1, " 
		. " USER_ROLE = ?2, FIRST_NAME = ?3, LAST_NAME = ?4, EMAIL_ADDRESS = ?5 WHERE ID = ?6";

		try {
			if (!$input->getUserId()) {
				die("Invalid User Id.");
			}

			$q_pr = array ("?1", "?2", "?3", "?4", "?5", "?6");
			$input_var = array ("'".$input->getUserName()."'",
			                    "'".$input->getUserRole()."'", 
			                    "'".$input->getFirstName()."'", 
			                    "'".$input->getLastName()."'", 
			                    "'".$input->getEmailAddress()."'",
			                        $input->getUserId());
			
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while updating data in database : ".$e);
		}
	}
	public function delete($user_id) {
		$q = "DELETE FROM INV_MGT_USER_ROLE WHERE ID = ?1";

		try {
			if (empty($user_id)) {
				die("Invalid User Id.");
			}

			$q_pr = array ("?1");
			$input_var = array ($user_id);
			$q = str_replace($q_pr, $input_var, $q);
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}
	public function deleteAll($station_id=NULL) {
		$q = "DELETE FROM INV_MGT_USER_ROLE WHERE 1=1";

		try {
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while deleting data in database : ".$e);
		}
	}

	public function changePassword($user_id, $user_name, $old_passwd, $new_passwd, $station_id=NULL) {
		if (empty($user_id)) {
			die("User id must be specified");
		}
		if (empty($user_name)) {
			die("User name must be specified");
		}
		if (empty($old_passwd)) {
			die("Please specified old password");
		}
		if (empty($new_passwd)) {
			die("Please specified new password");
		}
		try {
				
			$by_id = self::findByPrimaryKey($user_id);
			if (empty($by_id)) {
				die("User not found");
			}
			$res = self::findByUserName($user_name, NULL, $station_id);
			if (empty($res)) {
				die("User name not found");
			}
				
			$q = "UPDATE INV_MGT_USER_ROLE SET USER_PASSWORD = ?1 WHERE ID = ?2";

			$q_pr = array ("?1", "?2");
			$input_var = array ("'".hash("sha256", $new_passwd)."'",
			$user_id);
			$q = str_replace($q_pr, $input_var, $q);

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while updating data in database : ".$e);
		}
	}
    public function activateAccount($user_id, $station_id=NULL) {
		if (empty($user_id)) {
			die("User id must be specified");
		}
		
		try {
				
			$by_id = self::findByPrimaryKey($user_id);
			if (empty($by_id)) {
				die("User not found");
			}
			
				
			$q = "UPDATE INV_MGT_USER_ROLE SET ACCOUNT_ACTIVATED = ?1 WHERE ID = ?2";

			$q_pr = array ("?1", "?2");
			$input_var = array ("'Y'", $user_id);
			$q = str_replace($q_pr, $input_var, $q);
		    if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while updating data in database : ".$e);
		}
	}
    public function passivateAccount($user_id, $station_id=NULL) {
		if (empty($user_id)) {
			die("User id must be specified");
		}
		
		try {
				
			$by_id = self::findByPrimaryKey($user_id);
			if (empty($by_id)) {
				die("User not found");
			}
			
				
			$q = "UPDATE INV_MGT_USER_ROLE SET ACCOUNT_ACTIVATED = ?1 WHERE ID = ?2";

			$q_pr = array ("?1", "?2");
			$input_var = array ("'N'", $user_id);
			$q = str_replace($q_pr, $input_var, $q);
		    if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			mysql_query("COMMIT");
			mysql_close($conn);
		} catch (Exception $e) {
			die("Exception occured while updating data in database : ".$e);
		}
	}
	public function getPowerUserEmail() {
		$email = NULL;
		try {
			$results = array ();
			$q = "SELECT EMAIL_ADDRESS FROM INV_MGT_USER_ROLE WHERE ACCOUNT_ACTIVATED='Y' AND USER_ROLE='PUS'";
			
			
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$e = $row['EMAIL_ADDRESS'];
				$results[$count] = $e;
				$count ++;
			}
			mysql_free_result($rs);
			mysql_close($conn);
			
			if ($results != NULL && sizeof($results) > 0) {
			    $email = $results[0];	
			}
			
		} catch (Exception $e) {
			die("Can't find Power user email : ".$e);
		}
		return $email;
	}
public function findAllNoSuperuserAndOwner($pageIndex=NULL, $linePerPage=NULL, $station_id=NULL) {
		$results = NULL;
		try {
			$results = array ();
			$q = "SELECT ID, USER_NAME, " 
			." USER_ROLE, FIRST_NAME, LAST_NAME, STATION_ID, EMAIL_ADDRESS, ACCOUNT_ACTIVATED FROM INV_MGT_USER_ROLE WHERE 1=1" 
			." AND USER_ROLE <> '".UserRoleEnum::SUPERUSER."'"
			." AND USER_ROLE <> '".UserRoleEnum::GAS_STATION_OWNER."'"
			." AND USER_ROLE <> '".UserRoleEnum::POWER_USER."'"
			." AND USER_ROLE <> '".UserRoleEnum::DEPOT."'"
			." AND USER_ROLE <> '".UserRoleEnum::BPH_MIGAS."'"
			." AND USER_ROLE <> '".UserRoleEnum::PERTAMINA."'";

			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			$q = $q . " ORDER BY ID DESC";
			if (!empty ($pageIndex) || !empty ($linePerPage)) {
				$q = $q." LIMIT ".$pageIndex.", ".$linePerPage;
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());
			$count = 0;
			while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
				$vo = new UserRole();
				$vo->setUserId($row['ID']);
				$vo->setUsername($row['USER_NAME']);
				
				$vo->setUserRole($row['USER_ROLE']);
				$vo->setFirstName($row['FIRST_NAME']);
				$vo->setLastName($row['LAST_NAME']);
				$vo->setStationId($row['STATION_ID']);
				$vo->setEmailAddress($row['EMAIL_ADDRESS']);
				$vo->setAccountActivated(($row['ACCOUNT_ACTIVATED'] == "Y" ? "true" : "false"));
				$results[$count] = $vo;
				$count ++;
			}
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Users : ".$e);
		}
		return $results;
	}
public function countAllNoSuperuserAndOwner($station_id=NULL) {
		$result = NULL;
		try {

			$q = "SELECT COUNT(ID) FROM INV_MGT_USER_ROLE WHERE 1=1"
			." AND USER_ROLE <> '".UserRoleEnum::SUPERUSER."'"
			." AND USER_ROLE <> '".UserRoleEnum::POWER_USER."'"
			." AND USER_ROLE <> '".UserRoleEnum::GAS_STATION_OWNER."'"
			." AND USER_ROLE <> '".UserRoleEnum::DEPOT."'"
			." AND USER_ROLE <> '".UserRoleEnum::BPH_MIGAS."'"
			." AND USER_ROLE <> '".UserRoleEnum::PERTAMINA."'";
			
			if (!empty ($station_id)) {
				$q = $q." AND STATION_ID = '".$station_id."'";
			}
			LogManager :: LOG(__METHOD__."() : ". $q);
			$conn = DBManager :: get_connection();

			$rs = mysql_query($q) or die("SQL query failed in method ".__METHOD__." of " .__CLASS__. " : ".mysql_error());

			$row = mysql_fetch_row($rs);
			if ($row) {
				$result = $row[0];
			}
			mysql_free_result($rs);
			mysql_close($conn);
		} catch (Exception $e) {
			die("Can't find All Users : ".$e);
		}
		return $result;
	}
}
?>