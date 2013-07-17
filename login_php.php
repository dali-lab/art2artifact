<?php
	   session_start();
	   mb_internal_encoding('UTF-8');
       mb_http_output('UTF-8');
		
       include 'phpfunctions.php';
       $db = new SunapeeDB();
       $db->connect();
	   
		if (!isset($_SESSION['email'])) {
	   		$_SESSION['email'] = $_POST["email"];
	   		$_SESSION['password'] = $_POST["password"];
	   }
	   
       $db->check_login($_SESSION['email'], $_SESSION['password']);
   
       $db->disconnect();

?>