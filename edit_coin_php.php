<?php
session_start(); 
	include "phpfunctions.php";
	$db = new SunapeeDB();
	$db->connect();

	echo "idcoin=".$_SESSION['idcoin'];
	echo 'date_start='.$_POST["date_start"];
	// submit to database
	$db->edit_coin($_SESSION['idcoin'], $_POST["date_start"], $_POST["era_start"], $_POST["date_end"], $_POST["era_end"], $_POST["mint_lat_long"], $_POST["find_lat_long"], $_POST["denomination"], $_POST["mint_authority"], $_POST["obverse_legend"], $_POST["reverse_legend"], $_POST["bibliography"], $_POST["era_category"], $_POST["region_category"]);
					

	// disconnect from db
	$db->disconnect();
?>