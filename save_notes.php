<?php
	   mb_internal_encoding('UTF-8');
       mb_http_output('UTF-8');
		
       include 'phpfunctions.php';
       $db = new SunapeeDB();
       $db->connect();
	   
	   //echo "idcorpus = ".$_POST["idcorpus"]."\n";
	   //echo nl2br($_POST["notes"]);
	   
	   //echo '<h3>post coinid is '.$_POST["coinid"].'</h4>';
	   $db->save_notes($_POST["idcorpus"], $_POST["notes"]);
	   
	   $db->print_notes($_POST["idcorpus"]);
	   
       $db->disconnect();
	   
	   //header("Location: view_all.php");
	   
	   
	 ?>