<?php session_start(); 
if (!isset($_SESSION['email'])) {
	header("Location: login.php?test=fail");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Art2Artifact - Coin</title>

<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<link rel="stylesheet" href="Content/validation.css"/> 
<link rel="stylesheet" href="Content/magnifier.css" />
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>
<script type="text/javascript" src="Content/validation.js"></script>
<script type="text/javascript" src="Content/magnifier.js"></script>



<script type="text/javascript">
$(document).ready(function(){

	// Validate
	// http://bassistance.de/jquery-plugins/jquery-plugin-validation/
	// http://docs.jquery.com/Plugins/Validation/
	// http://docs.jquery.com/Plugins/Validation/validate#toptions

		$('#add-tag-form').validate({
	    rules: {
	      tagname: {
	        required: true,
	      }
	    },
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });
	  
	
});
</script>
<script type="text/javascript">
	jQuery(document).ready(function($){
		
		
	$('#coin_img').addimagezoom({
		zoomrange: [3, 10], 
   		magnifiersize: [600,400], 
	}) // single image zoom with default options
	
});
</script>

    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUGO7amceEOOtnYLa7lVeDeTJlbg3tenE&sensor=false">
    </script>
</head>

<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">

	<?php include('Includes/header.php'); ?>
	                 
<div style="height: 100%; background-color: rgba(250, 250, 250, 0.75); padding: 30px 30px 30px 30px; width: 100%; border-color: black;">
 	<!--img src="images/images.jpeg" style="width:300px; height: 200px;" id="test_img" /-->
	<?php
	   mb_internal_encoding('UTF-8');
       mb_http_output('UTF-8');
		
       include 'phpfunctions.php';
       $db = new SunapeeDB();
       $db->connect();
	   
	   //if (!isset($_SESSION['currentcoin'])) {
	   if (isset($_GET["idcoin"])) {	
		$_SESSION['currentcoin'] = $_GET["idcoin"];
	   }
	   
	   if (isset($_POST["tagname"])) {
	      $db->add_tag($_POST["tagname"], $_SESSION['currentcoin']);
		  $db->individual_coin($_SESSION['currentcoin']);
	   }
	   else {
	   	  $db->individual_coin($_SESSION['currentcoin']);
	   }
	   
	   $currcoin = $_SESSION['currentcoin'];
	   
	   if ($_SESSION['status'] == "Admin") {
	   echo '<form action="delete.php" method="post">';
	   echo '<input name="coinid" type="text" value="'.$currcoin.'" style="display:none;" /><input type="submit" value="Delete" class="btn btn-primary" /></form>';
   	   }
	   //echo '</div><div class="span4">';
	   
	   $db->plot_coin($currcoin);
       //$db->add_markers();
	   
	   $tags = $db->tag_bar();
	   
	   
	   //echo '
	   $db->disconnect();
	   
	   
	 ?>
	 <a class="btn btn-primary" data-toggle="modal" href="#addTagModal">Add Tag</a>
	 </div>
	 <div class="span3">
	 	<div id="map-canvas" style="height: 400px; width: 400px;"/>	
   	 </div>
	 </div>
</div>

</div>

</div>

<div class="modal hide fade" id="addTagModal" style="display: block;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Add a Search Tag</h3>
	</div>
	<div class="modal-body">
		<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal" id="add-tag-form">
			Tag Title:<input autocomplete="off" name="tagname" id="tag_bar" type="text" data-provide="typeahead" data-source='<?php echo $tags; ?>'>
		
		
	</div>
	<div class="modal-footer">
		<input class="btn btn-primary" name="addtag" type="submit" value="Add tag" />
		</form>
  </div>
	</div>
</div>



</body>
</html>