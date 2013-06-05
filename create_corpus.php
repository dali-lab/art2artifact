<?php
	echo "AS;DLFKJAS;DLFKJAS;DLFKJAS;DLFKJAS;DLKFJ";
	session_start();
	include "phpfunctions.php";
	$db = new SunapeeDB();
	$db->connect();
	echo 'createdby='.$_SESSION['email'].' title='.$_POST['title'].' description='.$_POST['description'];
	
	if (isset($_POST['title'])) {
		$db->create_corpus($_SESSION['email'], $_POST['title'], $_POST['description']);
	}
	if (isset($_GET['coins'])) {
		$coinsArray = explode(',', $_GET['coins']);
		$db->add_to_corpus($_GET['idcorpus'], $coinsArray);
	}
	$db->disconnect();
?>