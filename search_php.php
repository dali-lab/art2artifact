<?php

	include "phpfunctions.php";
	$db = new SunapeeDB();
	$db->connect();

	$db->search($_POST["search_val"]);

	$db->disconnect();
	
?>