<?php session_start(); 
if (!isset($_SESSION['email'])) {
	header("Location: login.php?test=fail");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Art2Artifact - View Corpus</title>

<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>
<style type="text/css" media="all">@import "Content/master.css";</style>  <style type="text/css" media="all">@import "Content/master.css";</style>


<link rel="stylesheet" href="Content/bootstrap_navbar.css"/> 

<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 700px;}
	  #map-canvas img {
		max-width: none;
	  }
	  /* Fix Google Maps canvas
	 *
	 * Wrap your Google Maps embed in a `.google-map-canvas` to reset Bootstrap's
	 * global `box-sizing` changes. You may optionally need to reset the `max-width`
	 * on images in case you've applied that anywhere else. (That shouldn't be as
	 * necessary with Bootstrap 3 though as that behavior is relegated to the
	 * `.img-responsive` class.)
	 */
	
	.google-map-canvas,
	.google-map-canvas * { .box-sizing(content-box); }
	
	/* Optional responsive image override */
	img { max-width: none; }
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUGO7amceEOOtnYLa7lVeDeTJlbg3tenE&sensor=false">
    </script>
    <script type="text/javascript">
      var map;
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(-34.397, 150.644),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
<script type="text/javascript">

$(document).ready(function() {
    $("button[name$='view_finder']").click(function() {
        var test = $(this).val();

        $("div.desc").hide();
        $("#view_finder_" + test).show();
    });
	$("#delete_group").click(function() {
		$("#delete_from_corpus_bar").toggle();
	});
	$(".thumbnail").click(function(){
            
			if ($(this).hasClass("thumbnail-success")) {
				$(this).removeClass("thumbnail-success");
			}
			else {
				//$(this).removeClass("thumbnail");
				$(this).addClass("thumbnail-success");
			}
    });
    $("#map_button").click(function() {
    	google.maps.event.trigger(map, "resize");
    });
});
</script>
<script>
function getParameterByName(name) {
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}
	$(function(){
      function yourfunction(event) {
	  	var coins = [];
	  	$('.thumbnail-success').each(function() {
			coins.push(this.id);
		});
		//var tag_title = $('#tag_title').val();
		//alert (coins.toString() + "Tag title: " + tag_title);
		//$.post("tag_coin_set.php", {"tag_title": tag_title});
		var $_GET = getParameterByName("idcorpus");
		window.location.href = "delete_coin_set.php?coins=" + coins.toString() + "&idcorpus=" + $_GET;
      }
      $('#delete_coins_button').click(yourfunction);
	});
	
	
</script>
</head>

<?php include('Includes/header.php'); ?>
<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">
	<div class="hero-unit" style="width: 100%; height: 100%; padding: 20px; background-color: rgba(150, 27, 25, 0.75); border-color: black;">
     	
	   
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
<?php include('Includes/footer.php'); ?>
</div>

<div class="modal hide fade" id="deleteCorpusModal" style="display: block;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Sure you want to delete?</h3>
	</div>

	<div class="modal-body">
		<center>	
		<h5>This action cannot be undone</h5>
		<a href="delete_corpus.php?idcorpus=<?php echo $_GET["idcorpus"]; ?>" class="btn btn-danger">I'm Sure, delete it!</a>
		</center>
	</div>
</div>

<div class="modal hide fade" id="publishCorpusModal" style="display: block;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Sure you want to publish this corpus to all Art2Artifact members?</h3>
	</div>

	<div class="modal-body">
		<center>	
		<h5>This action cannot be undone</h5>
		<a href="publish_corpus.php?idcorpus=<?php echo $_GET["idcorpus"]; ?>" class="btn btn-danger">I'm Sure, publish it!</a>
		</center>
	</div>
</div>
</body>
</html>