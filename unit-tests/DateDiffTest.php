<?php

/**
$delivery_date = "01/02/2010";
$delivery_time = "01:05";
list($day, $month, $year) = explode("/" , $delivery_date);
list($hour, $minute) = explode( ":" , $delivery_time );


$dl_date =  mktime( (int) $hour, (int) $minute, 0, ((int) $month), (int) $day, (int) $year);

$today = time();
echo($day. "\n");
echo($month. "\n");
echo($year. "\n");
 echo(date("d/m/Y/H:i", $dl_date). "\n");
 echo(date("d/m/Y/H:i", $today) . "\n");
$diff = (($today - $dl_date) / 60);
echo number_format($diff, 0, ',','.');
*/
$receive_date = "10/02/2010 23:05:04";

list($day, $month, $year) = explode("/" , $receive_date);
$year_with_sep = explode(" ", $year);

list($hour, $minute, $second) = explode(":" , $year_with_sep[1]);

echo($day. "\n");
echo($month. "\n");
echo($year. "\n");
echo($hour. "\n");
echo($minute. "\n");
echo($second. "\n");
//echo(date("d/m/Y H:i:s", $receive_date));

?>