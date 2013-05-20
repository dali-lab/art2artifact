{

'events' : [
		
		<?php
		   session_start();
		   mb_internal_encoding('UTF-8');
	       mb_http_output('UTF-8');
			
	       include 'phpfunctions.php';
	       $db = new SunapeeDB();
	       $db->connect();
		   if (isset($_SESSION["start_date"])) {
		   		$db->load_timeline_filtered($_SESSION["start_date"], $_SESSION["start_era"], $_SESSION["end_date"], $_SESSION["end_era"], $_SESSION["mint_lat_long"], $_SESSION["find_lat_long"], $_SESSION["era_category"], $_SESSION["region_category"]);
				unset($_SESSION["start_date"]);
				unset($_SESSION["start_era"]);
				unset($_SESSION["end_date"]);
				unset($_SESSION["end_era"]);
				unset($_SESSION["mint_lat_long"]);
				unset($_SESSION["find_lat_long"]);
				unset($_SESSION["era_category"]);
				unset($_SESSOIN["region_category"]);
				session_write_close();
		   }
		   else {
		   		$db->load_timeline();
	   	   }
	       $db->disconnect();
		?>
		
]
}
	  