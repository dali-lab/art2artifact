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
<script>
	$(function(){
      function yourfunction(event) {
	  	var coins = [];
	  	$('.success').each(function() {
			coins.push(this.id);
		});
		var tag_title = $('#tag_selector').find(":selected").text();
		//alert (coins.toString() + "Tag title: " + tag_title);
		//$.post("tag_coin_set.php", {"tag_title": tag_title});
		window.location.href = "tag_coin_set.php?tag_title=" + tag_title + "&coins=" + coins.toString();
      }
      $('#tag_coins').click(yourfunction);
	});
	
    $(function(){
        function yourfunction2(event){
            var coins = [];
            $('.success').each(function(){
                coins.push(this.id);
            });
            function getUrlVars(){
                var vars = [], hash;
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for (var i = 0; i < hashes.length; i++) {
                    hash = hashes[i].split('=');
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                return vars;
            }
            
            window.location.href = "create_corpus.php?idcorpus=" + getUrlVars()["idcorpus"] + "&coins=" + coins.toString();
        }
        $('#add_to_corpus').click(yourfunction2);
    });
		
    $(document).ready(function(){
        $("td").click(function(){
            
			if ($(this).hasClass("success")) {
				$(this).removeClass("success");
			}
			else {
				$(this).addClass("success");
			}
        });
    });
</script>
</script>
<style>
    .table tbody td.success {
        background-color: #dff0d8;
    }
</style>
</head>

<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">

	<?php include('Includes/header.php'); ?>
	
	

<div class="hero-unit" style="height: 100%; background-color: rgba(250, 250, 250, 0.75); padding: 30px 30px 30px 30px; width: 97%; border-color: black;">
         
<?php
	   mb_internal_encoding('UTF-8');
       mb_http_output('UTF-8');
		
       include 'phpfunctions.php';
       $db = new SunapeeDB();
       $db->connect();
	   
	   
	   
	   
	   
	   
	   
	   if (isset($_POST["start_date"])) {
			if (isset($_POST["start_date"])) {$_SESSION["start_date"] = $_POST["start_date"];}
			if (isset($_POST["start_era"])) {$_SESSION["start_era"] = $_POST["start_era"];}
			if (isset($_POST["end_date"])) {$_SESSION["end_date"] = $_POST["end_date"];}
			if (isset($_POST["end_era"])) {$_SESSION["end_era"] = $_POST["end_era"];}
			if (isset($_POST["mint_lat_long"])) {$_SESSION["mint_lat_long"] = $_POST["mint_lat_long"];}
			if (isset($_POST["find_lat_long"])) {$_SESSION["find_lat_long"] = $_POST["find_lat_long"];}
		   	$db->filter_options();
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
		   		echo ("<div class=\"row\"><h2>Search Results: ".$_GET["searchby"]."</h2>");
		   		$tag = $_GET["searchby"];
				echo ("<a href=\"delete_tag.php?title=".$tag."\" class=\"btn btn-primary\">Delete Tag</a></div><br>");
				$db->filter_options();
				$db->get_tagged_coins($tag);
		   }
		   else if (isset($_GET["idcorpus"])) {
		   		print ("<h4>Select the Coins to add to your corpus: </h4>");
				echo '<div style="margin-left: 0px;">Select the coins to you wish to add from the table (they will turn green), then click ->';
				echo '<button class="btn" style="margin-left: 10px; margin-bottom: 10px;" id="add_to_corpus">+</button></div>';
				$db->filter_options();
				$db->getpics();
		   }
		   else {
		   		print("<h2>All Coins</h2>");
				echo '<div style="margin-left: 0px;">To tag coins, select the coins in the table (they will turn green), then select the tag to add, and click \'TAG!\'<br>';
	   			$db->get_tag_select();
	  			echo '<button class="btn" style="margin-left:10px; margin-bottom: 10px;" id="tag_coins">TAG!</button></div>';
				$db->filter_options();
	       		$db->getpics();
	   	   }
	   }
	   
       $db->disconnect();
?>

	</well>
</div>
</body>
</html>