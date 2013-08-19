<?php session_start(); 
if ($_SESSION['status'] != "Admin") {
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Art2Artifact - All Corpora</title>

<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>
<script type="text/javascript" src="Content/validation.js"></script>
<style type="text/css" media="all">@import "Content/master.css";</style>  <style type="text/css" media="all">@import "Content/master.css";</style>

<link rel="stylesheet" href="Content/bootstrap_navbar.css"/> 

</head>

<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">

	<?php include('Includes/header.php'); ?>
	
	

<div style="width: 100%; height: 100%; padding: 20px; background-color: rgba(150, 27, 25, 0.75); border-color: black;">
 	<h3 style="color: #FACE8D;">All Current Corpora</h3>
<?php
	   mb_internal_encoding('UTF-8');
       mb_http_output('UTF-8');

       include 'phpfunctions.php';
       $db = new SunapeeDB();
       $db->connect();

		if (!isset($_SESSION['email'])) {
	   		$_SESSION['email'] = $_POST["email"];
	   		$_SESSION['password'] = $_POST["password"];
	   }

       $db->view_all_corpora();
   
       $db->disconnect();
?>

	
</div>


<?php include('Includes/footer.php'); ?>
</body>
</html>