<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Art2Artifact - View Search Tags</title>

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

		if (!isset($_SESSION['email'])) {
	   		$_SESSION['email'] = $_POST["email"];
	   		$_SESSION['password'] = $_POST["password"];
	   }
	   
       $db->get_tags();
   
       $db->disconnect();
?>


	</well>
</div>
<div class="modal hide fade" id="addNewTag" style="display: block;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Add a New Tag</h3>
	</div>
	<div class="modal-body">
		<form action="add_location.php" method="post" class="form-horizontal">
			Tag Name:<input type="text" name="tag_name"><br>
	</div>
	<div class="modal-footer">
		<input class="btn btn-primary" name="addloc" type="submit" value="Add Location" />
		</form>
  </div>
</div>
</body>
</html>