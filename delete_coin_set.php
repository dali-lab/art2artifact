<?php 
	include "phpfunctions.php";
	$db = new SunapeeDB();
	$db->connect();
	
	//echo 'coins = '.$_GET['coins'];
	$coinsArray = explode(',', $_GET['coins']);
	$db->delete_coin_set($_GET["idcorpus"], $coinsArray);
	
	
	$db->disconnect();
?>