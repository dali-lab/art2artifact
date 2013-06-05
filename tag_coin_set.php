<?php 
	include "phpfunctions.php";
	$db = new SunapeeDB();
	$db->connect();
	
	echo 'tag title is: '.$_GET['tag_title'];
	echo 'coins = '.$_GET['coins'];
	$coinsArray = explode(',', $_GET['coins']);
	$db->tag_coin_set($_GET['tag_title'], $coinsArray);
	
	
	$db->disconnect();
?>