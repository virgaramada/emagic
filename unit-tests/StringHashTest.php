<?php

 $str = "masteryoda";
 echo("Plain text : ".$str.", MD5 : ".md5($str) .", SHA1 : " .sha1($str) 
 .", SHA256 : ". hash("sha256", $str));
?>