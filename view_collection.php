<!DOCTYPE html>
	<?php session_start(); 
if (!isset($_SESSION['email'])) {
	header("Location: login.php?test=fail");
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Art2Artifact - View All</title>
<style type="text/css" media="screen">
  .hide{
    display:none;
  }
</style>
<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>

<link rel="stylesheet" href="Content/bootstrap_navbar.css"/> 

<style type="text/css" media="all">@import "Content/master.css";</style>  <style type="text/css" media="all">@import "Content/master.css";</style>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 700px;}
	  #map-canvas img {
		max-width: none;
	  }
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
	$("#map_button").click(function() {
		google.maps.event.trigger(map, 'resize');
		map.setZoom( map.getZoom() );
		var center = new google.maps.LatLng(55.37911,-17.226562);
		map.setCenter(center);
	});
	$("#show_filter").click(function() {
		$("#filters").toggle();
		$("#show_filter").bind('click', function() {
    		$("#show_filters").text($("#show_filters").text() == 'Show Filters' ? 'Hide Filters' : 'Show Filters');
		});
	});
	$("#tag_group").click(function() {
		$("#tag_name").toggle();
	});
	$("#add_to_corpus").click(function() {
		$("#corpus_titles").toggle();
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
});
</script>
<script src="http://api.simile-widgets.org/timeline/2.3.1/timeline-api.js?bundle=true" type="text/javascript"></script>
<script>
    function onLoad(){
        var eventSource = new Timeline.DefaultEventSource();
        
        var bandInfos = [Timeline.createBandInfo({
            eventSource: eventSource,
            date: "0",
            width: "100%",
            intervalUnit: Timeline.DateTime.DECADE,
            intervalPixels: 100
        })];
        tl = Timeline.create(document.getElementById("my-timeline"), bandInfos);
        tl.loadJSON("load_coins.php", function(json, url){
            eventSource.loadJSON(json, url);
            tl.finishedEventLoading();
        });
        
    }
</script>
<style>
    .timeline-band-1 .timeline-ether-bg {
        background-color: #794044;
    }
</style>
<script src="Content/tagcanvas.min.js" type="text/javascript"></script>
<script type="text/javascript">
      window.onload = function() {
        try {
          TagCanvas.Start('myCanvas','tags',{
            textColour: 'navy',
            outlineColour: 'navy',
            reverse: true,
            depth: 0.8,
            maxSpeed: 0.05
          });
        } catch(e) {
          // something went wrong, hide the canvas container
          document.getElementById('myCanvasContainer').style.display = 'none';
        }
      };
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
		var tag_title = $('#tag_title').val();
		//alert (coins.toString() + "Tag title: " + tag_title);
		//$.post("tag_coin_set.php", {"tag_title": tag_title});
		window.location.href = "tag_coin_set.php?tag_title=" + tag_title + "&coins=" + coins.toString();
      }
      $('#tag_coins_button').click(yourfunction);
	});
	
    $(function(){
        function yourfunction2(event){
            var coins = [];
            $('.thumbnail-success').each(function(){
                coins.push(this.id);
            });
            var tag_title = $('#corpus_titles').find(":selected").text();
            
            window.location.href = "create_corpus.php?corpustitle=" + tag_title + "&coins=" + coins.toString();
        }
        $('#add_coins_corpus').click(yourfunction2);
    });
$(function(){
      function yourfunction3(event) {
	  	var coins = [];
	  	$('.thumbnail-success').each(function() {
			coins.push(this.id);
		});
		//var tag_title = $('#tag_title').val();
		//alert (coins.toString() + "Tag title: " + tag_title);
		//$.post("tag_coin_set.php", {"tag_title": tag_title});
		var $_GET = getParameterByName("searchby");
		window.location.href = "delete_tag.php?coins=" + coins.toString() + "&title=" + $_GET;
      }
      $('#delete_tag_from_coins_button').click(yourfunction3);
	});
	
</script>
</head>
<?php include('Includes/header.php'); ?>
<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">
	<div class="hero-unit" style="width: 100%; height: 100%; padding: 20px; background-color: rgba(150, 27, 25, 0.75); border-color: black;">
     	<div class="btn-toolbar" style="margin-bottom: 0;">
        <div class="btn-group" data-toggle-name="is_private" data-toggle="buttons-radio">
            <button type="button" name="view_finder" value="images" class="btn btn-primary active btn-custom-gray" style="border-color: #13132E; border-width: 1px;" data-toggle="button">
                <font class="navy-text">Images</font>
            </button>
            <button id="map_button" type="button" name="view_finder" value="map" class="btn btn-custom-gray" style="border-color: #13132E; border-width: 1px;" data-toggle="button">
                <font class="navy-text">Map</font>
            </button>
            <button type="button" name="view_finder" value="tag_list" class="btn btn-custom-gray" style="border-color: #13132E; border-width: 1px;" data-toggle="button">
                <font class="navy-text">Tag List</font>
            </button>
        </div>
		<div class="btn-group">
		<button class="btn btn-primary btn-custom-gray dropdown-toggle" data-toggle="dropdown" style="border-color: #13132E; border-width: 1px;" ><font class="navy-text">Tools</font></b></button>
			<ul class="dropdown-menu">
				<li id="show_filter"><a id="show_filters" href="#">Show/Hide Filters</a></li>
				<?php 
        			if (strcmp($_SESSION['status'], "Guest") != 0) {
						echo '<li id="tag_group"><a id="tag_group" href="#">Tag Group</a></li>';
						echo '<li id="add_to_corpus"><a id="add_to_corpus" href="#">Add Coins to Corpus</a></li>';
					}
				?>
			</ul>
		</div>
		</div>
		<div id="the_viewer" class="well" style="border-color: #13132E; background: rgba(192, 192, 192, 0.2); padding: 0px; position: relative; left: auto; right: auto; margin: 0 auto 20px; z-index: 1; max-width: 93%; height: 70%; overflow-y: scroll; margin-left: 0px; width: 100%; top: 0;">
            <?php
			   mb_internal_encoding('UTF-8');
		       mb_http_output('UTF-8');
				
		       include 'phpfunctions.php';
		       $db = new SunapeeDB();
		       $db->connect();
			   
			   $db->view_all_divs();
			   $db->disconnect();
			?>
		</div>
	
</div>
<?php include('Includes/footer.php'); ?>
</body>
</html>