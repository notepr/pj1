<?php  
	$pass = "bkacad17";
	$pass = sha1($pass);
	$pass = md5($pass)."check";
	$pass = sha1($pass);
	echo $pass;
?>