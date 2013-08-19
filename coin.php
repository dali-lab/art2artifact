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
<style type="text/css" media="all">@import "Content/master.css";</style>  <style type="text/css" media="all">@import "Content/master.css";</style>

<link rel="stylesheet" href="Content/bootstrap_navbar.css"/> 


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
	  
	 // var test = $(this).val();

        //$("div.desc").hide();
       // $("#view_finder_image").show();
	  
	  $("button[name$='view_finder']").click(function() {
        var test = $(this).val();

        $("div.desc").hide();
        $("#view_finder_" + test).show();
        
    });
	
});
</script>

    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUGO7amceEOOtnYLa7lVeDeTJlbg3tenE&sensor=false">
    </script>
    <style>
		#map-canvas img {
			max-width: none;
		}

		#map-canvas label {
			width: auto;
			display: inline;
		}
		</style>
</head>

<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">

	<?php include('Includes/header.php'); ?>
	                 
<div style="width: 100%; height: 100%; padding: 20px; background-color: rgba(150, 27, 25, 0.75); border-color: black;">
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
	   
	   
	   
	   $currcoin = $_SESSION['currentcoin'];
	   
	   echo '<div class="container-fluid">';
		   echo '<div class="row-fluid" style="height: 70%;">';
		   		echo '<div class="span3" style="margin-top: 45px;">';	   			
					$db->coin_info($currcoin);
				echo '</div>';
				echo '<div class="span9">';
			   		/*echo '<div class="row">';	   			
			   			//$db->coin_image($_SESSION['currentcoin']); 
			   		echo '</div>';
		   			echo '<div class="row">';
						echo '<div class="span4">';
		 					echo '<div id="map-canvas" style="height: 400px; width: 400px;"/>	';
	   	 				echo '</div>';
						//$db->plot_coin($currcoin);
					echo '</div>';*/
					echo '<div class="btn-toolbar" style="margin-bottom: 0;">';
			        echo '<div class="btn-group" data-toggle-name="is_private" data-toggle="buttons-radio">';
			            echo '<button type="button" name="view_finder" value="map_individual" class="btn btn-custom-gray active" style="border-color: #13132E; border-width: 1px;" data-toggle="button">';
			                echo '<font class="navy-text">Map</font>';
			            echo '</button>';
			            echo '<button type="button" name="view_finder" value="image" class="btn btn-primary  btn-custom-gray" style="border-color: #13132E; border-width: 1px;" data-toggle="button">';
			                echo '<font class="navy-text">Image</font>';
			            echo '</button>';
			        echo '</div>';
					if ($_SESSION["status"] == "Admin") {
						echo '<div class="btn-group">';
							echo '<button class="btn btn-primary btn-custom-gray dropdown-toggle" data-toggle="dropdown" style="border-color: #13132E; border-width: 1px;" ><font class="navy-text">Tools</font></b></button>';
							echo '<ul class="dropdown-menu">';
								echo '<li><a href="edit_coin.php?coinid='.$_GET["idcoin"].'">Edit Coin</a></li>';
								echo '<li><a data-toggle="modal" href="#deleteCoinModal">Delete Coin</a></li>';
							echo '</ul>';
						echo '</div>';
					}
					echo '<div id="the_viewer" class="well" style="border-color: #13132E; ';
						echo 'background: rgba(192, 192, 192, 0.2); padding: 0px;';
						echo 'max-width: 93%; height: 106%; margin-left: 0px; top: 0;">';
						
						echo '<div id="view_finder_image" class="desc"   style="display: none;">';
								$db->coin_image($currcoin);
						echo '</div>';

						echo '<div id="view_finder_map_individual" class="desc">';
							$db->plot_coin($currcoin);
							echo '<div id="map-canvas" style="height: 100%; width: auto; border-width:10px;"></div></div>';
						echo '</div>';
					
					echo '</div>';
        
				echo '</div>';
			echo '</div>';
		echo '</div>';
	   
	   
	   if ($_SESSION['status'] == "Admin") {
	   //echo '<form action="delete.php" method="post">';
	   //echo '<input name="coinid" type="text" value="'.$currcoin.'" style="display:none;" /><input type="submit" value="Delete" class="btn btn-primary" /></form>';
   	   }
	   //echo '</div><div class="span4">';
	   
	 	
   	 	
		if (isset($_POST["tagname"])) {
	      $db->add_tag($_POST["tagname"], $_SESSION['currentcoin']);
		  //$db->individual_coin($_SESSION['currentcoin']);
	   }
	   else {
	   	  //$db->individual_coin($_SESSION['currentcoin']);
	   }
	   //$db->coin_info($currcoin);
	   //$db->plot_coin($currcoin);
	   
	   /*<row>
	   	<span4>
	   		<row>
	   		<image>
	   		<map>
		<span8>
			<info>*/
       //$db->add_markers();
	   
	   $tags = $db->tag_bar();
	   
	   
	   //echo '
	   $db->disconnect();
	   
	   
	 ?>
	 
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

<div class="modal hide fade" id="deleteCoinModal" style="display: block;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Sure you want to delete?</h3>
	</div>

	<div class="modal-body">
		<center>	
		<h5>This action cannot be undone</h5>
		<a href="delete.php?coinid=<?php echo $_GET["idcoin"]; ?>" class="btn btn-danger">I'm Sure, delete it!</a>
		</center>
	</div>
</div>

<?php include('Includes/footer.php'); ?>

</body>
</html>