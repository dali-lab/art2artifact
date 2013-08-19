<?php
	   mb_internal_encoding('UTF-8');
       mb_http_output('UTF-8');
		
       include 'phpfunctions.php';
       $db = new SunapeeDB();
       $db->connect();
	   
	   //echo '<h3>post coinid is '.$_POST["coinid"].'</h4>';
	   $db->delete_corpus($_GET["idcorpus"]);
	   
       $db->disconnect();
	   
	   //header("Location: view_all.php");
	   
	   
	 ?>