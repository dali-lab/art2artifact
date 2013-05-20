<?php
	  

if (isset($_POST["lat"])) {
	include "phpfunctions.php";
	$db = new SunapeeDB();
	$db->connect();
	$db->add_location($_POST["loc_name"], $_POST["lat"], $_POST["long"]);
	$db->disconnect();
}
	   
	   
	 ?>