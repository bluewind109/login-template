<?php
	$server = 'localhost';
	$username = 'root';
	$pw = '';
	$db = 'userlist';

	$DBcon = new  mysqli($server, $username, $pw, $db);

	if ($DBcon->connect_errno){
		die("ERROR: : -> ".$DBcon->connect_error);
	}
?>