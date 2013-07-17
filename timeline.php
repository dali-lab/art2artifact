<?php session_start(); ?>
 <!DOCTYPE html>
<html>
    <head>
        <title>Art2Artifact - Timeline</title>
        <link rel="stylesheet" href="Content/bootstrap.css"/>
        <link rel="stylesheet" href="Content/bootstrap-responsive.css"/>
        <link rel="stylesheet" href="Content/style.css" />
        <script type="text/javascript" src="Content/jquery.js">
        </script>
        <script type="text/javascript" src="Content/bootstrap.js">
        </script>
        <script src="http://api.simile-widgets.org/timeline/2.3.1/timeline-api.js?bundle=true" type="text/javascript">
        </script>
        <?php
	if (isset($_POST["start_date"])) {$_SESSION["start_date"] = $_POST["start_date"];}
	if (isset($_POST["start_era"])) {$_SESSION["start_era"] = $_POST["start_era"];}
	if (isset($_POST["end_date"])) {$_SESSION["end_date"] = $_POST["end_date"];}
	if (isset($_POST["end_era"])) {$_SESSION["end_era"] = $_POST["end_era"];}
	if (isset($_POST["mint_lat_long"])) {$_SESSION["mint_lat_long"] = $_POST["mint_lat_long"];}
	if (isset($_POST["find_lat_long"])) {$_SESSION["find_lat_long"] = $_POST["find_lat_long"];}
	if (isset($_POST["era_category"])) {$_SESSION["era_category"] = $_POST["era_category"];}
	if (isset($_POST["region_category"])) {$_SESSION["region_category"] = $_POST["region_category"];}
        ?>
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
    </head>
    <body style="background-image: url(Content/Login_map.jpg); background-size: 100%;" onload="onLoad();" onresize="onResize();">
        <?php include('Includes/header.php'); ?>
<div class="hero-unit" style="height: 100%; background-color: rgba(250, 250, 250, 0.75); padding: 30px 30px 30px 30px; width: 97%; border-color: black;">
             <?php include('Includes/search_filters_timeline.php'); ?>
            <div id="my-timeline" style="height: 450px; border: 1px solid #aaa"><script>
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
            </div>
            <noscript>
                This page uses Javascript to show you a Timeline. Please enable Javascript in your browser to see the full page. Thank you.
            </noscript>
        </div>
        <?php include("Includes/footer.php"); ?>
    </body>
</html>
