<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Art2Artifact - Tutorial</title>

<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>
<script type="text/javascript" src="Content/validation.js"></script>
<style type="text/css" media="all">@import "Content/master.css";</style>  <style type="text/css" media="all">@import "Content/master.css";</style>

<link rel="stylesheet" href="Content/bootstrap_navbar.css"/> 
<script>
  $(document).ready(function(){
    $('.carousel').carousel();
  });
</script>
</head>

<style>
	.tut {
		height: 800px;
		width: 800px;
	}
</style>

<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">

	<?php include('Includes/header.php'); ?>
	
	

<div style="width: 100%; height: 125%; padding: 20px; background-color: rgba(150, 27, 25, 0.75); border-color: black;">
 	<center><h1 style="color: #FACE8D; font-size: 50px;">About</h1></center>

<div class="well" style="width: 90%;">
	<h3>Background:</h3>
	<p>
		Art2Artifact was begun in January 2013 by Prof. Roberta Stewart, who saw a potential for the enhancement of Classical Studies through the use of technology.  Instead of painstakingly collecting data by hand, using physical paper resources, Stewart felt that there was an opportunity to use the power of computers to organize and search data online.
	</p>
	<h3>Functionality:</h3>
	<p>
		Art2Artifact was designed to perform two basic functions:
	</p>
	<p>
	1. To store coin images in an online database and allow users to perform basic searches on the coins with several attributes, including Date, Location, Mint Authority, etc.  This database should be simple, easy to use, and easy for users (with proper privileges) to upload, edit, and delete entries.<br>
	2. To allow users to save specific searches into “Corpora” for study, and to view corpora of other users once they have published them.
	</p>
	<h3>Future Use:</h3>
	<p>Prof. Stewart hopes to incorporate the Art2Artifact Portal into the education plans of the Classics Department, specifically for senior year research papers and seminars.</p>
	<h3>Design/Implementation:</h3>
	<p>The Art2Artifact Portal was built and designed by <a href="http://www.cs.dartmouth.edu/~salsbury">Diana Salsbury</a>,
		 a Neukom Scholar and member of the 
		Dali Lab at Dartmouth College.  Diana Salsbury is a current Computer Science student at Dartmouth, 
		and will graduate in 2015.  The site is built using a SQL Database, and a PHP/HTML/CSS/JavaScript 
		front end.  The styling of the site uses the popular Twitter Bootstrap CSS library, and implements 
		the GoogleMaps v3 API and Simile Timeline Widget.  Some minor JSON was used in populating the 
		Simile Timeline.  Art2Artifact is hosted on Heroku.  All PHP functionality was coded by 
		Diana Salsbury.  The code for Art2Artifact is public, and can be found on 
		<a href="http://www.github.com/dsalsbury/art2artifact">www.github.com/dsalsbury/art2artifact</a>.  
		Please keep in mind that the site is currently undergoing construction, and report and issues to: 
		diana.l.salsbury.15@dartmouth.edu.
	</p>
	<h3>Funding:</h3>
	<p>
		The Art2Artifact Portal was designed by the Classics Department of Dartmouth College in conjunction 
		with the Digital Arts Department of Dartmouth College.  Funding for the project was graciously donated 
		by the Neukom Institute of Dartmouth College.

	</p>
</div>

<?php include('Includes/footer.php'); ?>
</body>
</html>