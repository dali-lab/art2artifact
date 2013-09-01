<?php
	   mb_internal_encoding('UTF-8');
       mb_http_output('UTF-8');
		
       include 'phpfunctions.php';
       $db = new SunapeeDB();
       $db->connect();
	   
	   //echo '<h3>post coinid is '.$_POST["coinid"].'</h4>';
	   if (isset($_GET["coins"])) {
	   		$coinsArray = explode(',', $_GET['coins']);
	   		$db->delete_tag_from_coins($_GET["title"], $coinsArray);
	   }
	   else {
	   		$db->delete_tag($_GET["title"]);
	   }
       $db->disconnect();
	   echo '<a href="view_tags.php">Back</a>';
	   
	   
	   
	   
	 ?>