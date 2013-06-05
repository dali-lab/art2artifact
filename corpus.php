<?php session_start(); 
if (!isset($_SESSION['email'])) {
	header("Location: login.php?test=fail");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Art2Artifact - View All</title>

<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>

<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">

	<?php include('Includes/header.php'); ?>
	
	

<div class="hero-unit" style="height: 100%; background-color: rgba(250, 250, 250, 0.75); padding: 30px 30px 30px 30px; width: 100%; border-color: black;">

	<?php
	   mb_internal_encoding('UTF-8');
       mb_http_output('UTF-8');
		
       include 'phpfunctions.php';
       $db = new SunapeeDB();
       $db->connect();
	   
	   //echo '<h1>IDcorpus='.$_GET["idcorpus"].'</h1>';
	   $db->display_corpus($_GET["idcorpus"]);
	   
	   $db->disconnect();
	   
	   
	 ?>

</div>
</body>
</html>