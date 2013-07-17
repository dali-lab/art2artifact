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
	   
	   if (isset($_POST["status_change"])) {
       		$db->request_change($_POST["status_change"], $_SESSION['email']);
			echo 'post status_change isset';
	   }
	   
	   if (isset($_GET["email"]) && isset($_GET["status"])) {
	   		echo 'get email and get status are set';
			$db->change_status($_GET["status"], $_GET["email"]);
	   }
   
       $db->disconnect();

?>