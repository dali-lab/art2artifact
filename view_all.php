<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Art2Artifact - View All</title>

<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>
</head>

<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">

	<?php include('Includes/header.php'); ?>
	
	

<div class="well" style="width: 85%; margin-left: 70px; margin-top: 50px; background-color: rgba(250, 250, 250, 0.75); border-color: black;">

<?php
	   mb_internal_encoding('UTF-8');
       mb_http_output('UTF-8');
		
       include 'phpfunctions.php';
       $db = new SunapeeDB();
       $db->connect();
	   
	   
	   echo '<div class="navbar" style="margin-bottom: 0px;"><div class="navbar-inner"><form class="navbar-form pull-left" name="map_options" method="post" action="view_all.php">';
	   echo 'From: <input type="text" name="start_date" value="Start" style="width:75px;"/>';
	   echo '<select name="start_era" style="width:60px;"><option value="">AD</option><option value="-">BCE</option></select>';
	   echo '| To: <input type="text" name="end_date" value="End" style="width:75px;"/><select name="end_era" style="width:60px;">';
	   echo '<option value="">AD</option><option value="-">BCE</option></select>|'; 
   	   $db->get_locations(0);
	   
	   echo '<button type="submit" class="btn">Submit</button></form></div></div>';
	   
	   if (isset($_POST["start_date"])) {
			if (isset($_POST["start_date"])) {$_SESSION["start_date"] = $_POST["start_date"];}
			if (isset($_POST["start_era"])) {$_SESSION["start_era"] = $_POST["start_era"];}
			if (isset($_POST["end_date"])) {$_SESSION["end_date"] = $_POST["end_date"];}
			if (isset($_POST["end_era"])) {$_SESSION["end_era"] = $_POST["end_era"];}
			if (isset($_POST["mint_lat_long"])) {$_SESSION["mint_lat_long"] = $_POST["mint_lat_long"];}
			if (isset($_POST["find_lat_long"])) {$_SESSION["find_lat_long"] = $_POST["find_lat_long"];}
		   	$db->view_all_filtered($_SESSION["start_date"], $_SESSION["start_era"], $_SESSION["end_date"], $_SESSION["end_era"], $_SESSION["mint_lat_long"], $_SESSION["find_lat_long"]);
					unset($_SESSION["start_date"]);
					unset($_SESSION["start_era"]);
					unset($_SESSION["end_date"]);
					unset($_SESSION["end_era"]);
					unset($_SESSION["mint_lat_long"]);
					unset($_SESSION["find_lat_long"]);
					session_write_close();
	   }
	   else {
		   if (isset($_GET["searchby"])) {
		   		print("<h4>Search Results: ".$_GET["searchby"]."</h4>");
		   		$tag = $_GET["searchby"];
				print("<a href=\"delete_tag.php?title=".$tag."\" class=\"btn btn-primary\">Delete Tag</a>");
				$db->get_tagged_coins($tag);
		   }
		   else {
		   		print("<h4>All Coins</h4>");
	       		$db->getpics();
	   	   }
	   }
	   
       $db->disconnect();
?>

	</well>
</div>
</body>
</html>