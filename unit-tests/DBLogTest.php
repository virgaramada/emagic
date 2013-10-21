<?php
require_once 'Log-1.9.11/Log.php';
require_once 'DB.php';
$datePattern = "d-m-Y-H:i:s";
$today = date($datePattern);
$db = &DB::connect('mysql://root:adaaja@localhost/sikopis');

$conf['db'] = $db;
$logger = &Log::singleton('sql', 'log_table', "object", $conf);

$logger->log("Log entry on $today");
$logger->close();

?>