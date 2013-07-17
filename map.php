<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 100% }
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUGO7amceEOOtnYLa7lVeDeTJlbg3tenE&sensor=false">
    </script>
    
	
<title>Art2Artifact - Map</title>

<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>
		
  	<?php
	   mb_internal_encoding('UTF-8');
       mb_http_output('UTF-8');
		
       include 'phpfunctions.php';
       $db = new SunapeeDB();
       $db->connect();
	   
	   if (!isset($_POST["start_date"])) {$db->add_markers();}
		   
	   else {
		if (isset($_POST["start_date"])) {$_SESSION["start_date"] = $_POST["start_date"];}
		if (isset($_POST["start_era"])) {$_SESSION["start_era"] = $_POST["start_era"];}
		if (isset($_POST["end_date"])) {$_SESSION["end_date"] = $_POST["end_date"];}
		if (isset($_POST["end_era"])) {$_SESSION["end_era"] = $_POST["end_era"];}
		if (isset($_POST["mint_lat_long"])) {$_SESSION["mint_lat_long"] = $_POST["mint_lat_long"];}
		if (isset($_POST["find_lat_long"])) {$_SESSION["find_lat_long"] = $_POST["find_lat_long"];}
	   	$db->add_markers_filtered($_SESSION["start_date"], $_SESSION["start_era"], $_SESSION["end_date"], $_SESSION["end_era"], $_SESSION["mint_lat_long"], $_SESSION["find_lat_long"]);
				unset($_SESSION["start_date"]);
				unset($_SESSION["start_era"]);
				unset($_SESSION["end_date"]);
				unset($_SESSION["end_era"]);
				unset($_SESSION["mint_lat_long"]);
				unset($_SESSION["find_lat_long"]);
				session_write_close();
	   }
	   
	   include('Includes/header.php');
	   
	   echo '<div class="navbar" style="margin-bottom: 0px;"><div class="navbar-inner"><form class="navbar-form pull-left" name="map_options" method="post" action="map.php">';
	   echo 'From: <input type="text" name="start_date" value="Start" style="width:75px;"/>';
	   echo '<select name="start_era" style="width:60px;"><option value="">AD</option><option value="-">BCE</option></select>';
	   echo '| To: <input type="text" name="end_date" value="End" style="width:75px;"/><select name="end_era" style="width:60px;">';
	   echo '<option value="">AD</option><option value="-">BCE</option></select>|'; 
   	   $db->get_locations(0);
	   
	   
	   
	   echo '<button type="submit" class="btn">Submit</button></form></div></div>';
	   $db->disconnect();
	?>
			
	  		
  </head>
<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">

	
    <div id="map-canvas"/>
	<?php include("Includes/footer.php"); ?>
  </body>
</html>