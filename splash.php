<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<title>Art2Artifact - Welcome</title>
	
	<meta http-equiv="Content-Language" content="en-us" />		
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="MSSmartTagsPreventParsing" content="true" />		
	<meta name="description" content="Description" />
	<meta name="keywords" content="Keywords" />	
	<meta name="author" content="Enlighten Designs" />
		
		
	<link rel="stylesheet" href="Content/style.css" />
	<style type="text/css" media="all">@import "Content/master.css";</style>  <style type="text/css" media="all">@import "Content/master.css";</style>
	
	<script type="text/javascript" src="Content/jquery.js"></script>
</head>

<body>
	
<div id="page-container">

	<div id="bg-top" style="padding-top: 0px;">
		<div class="hero-unit" style="width: 100%; height: 100%; background-color: rgba(150, 27, 25, 0.0); border-color: black;">

		<div id="splash-top-text" style="padding-top: 60px;">
			
			<center>
				<h1 style="margin-top: 0px; font-size: 45px;" class="yellow-text" >
					Art 2 Artifact
				</h1>
			</center>
		</div>
		</div>
	</div>
	
	<div id="bg-middle">
		<center>
			<a href="about.php" class="navy-text">About</a>
			<a href="edit_user.php" class="navy-text" style=" padding-left: 100px; padding-right: 50px;">Account Information</a>
			<a href="index.php" class="navy-text" style="padding-left: 50px; padding-right: 100px;">Home</a>
			<a href="tutorial.php" class="navy-text">Tutorial</a>
		</center>
	</div>
	
	<div id="bg-bottom">
		<center>
			<a class="white" href="view_collection.php" style="font-size: 30px;">View Collection</a><br><br><br>
			<?php 
				if (strcmp($_SESSION["status"], "Guest") != 0) {
					echo '<a class="white" href="index.php" style="font-size:30px;">Build/Explore Corpora</a>';
				}
				else {
					echo '<a class="white" href="view_published_corpora.php" style="font-size: 30px;">Explore Published Corpora</a>';
				}
			?>
		</center>
	</div>

</div>

</body>
</html>