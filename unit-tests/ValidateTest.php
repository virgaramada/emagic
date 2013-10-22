<?php
require_once 'utils/Validate.php';


if (Validate::email("test@testf.net.id")) {
	echo ("E-mail valid");
} else {
	echo ("E-mail tidak valid");
}
//$dirname = dirname($_SERVER["SCRIPT_FILENAME"]);
//echo($dirname);
?>