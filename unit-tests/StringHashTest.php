<?php

 $str = "masteryoda";
 echo("Plain text : ".$str.",\n MD5 : ".md5($str) .",\n SHA1 : " .sha1($str) 
 .", \nSHA256 : ". hash("sha256", $str) . "\n");
?>