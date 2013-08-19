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
	
	

<div style="width: 100%; height: 100%; padding: 20px; background-color: rgba(150, 27, 25, 0.75); border-color: black;">
 	<h3 style="color: #FACE8D;">Tutorial</h3>

<center>
<div class="row" style="height: 80%;">
<div class="span12 well" style="height: 500px;">
<!--  Carousel - consult the Twitter Bootstrap docs at
      http://twitter.github.com/bootstrap/javascript.html#carousel -->
<div id="tutorialCarousel" class="carousel slide"><!-- class of slide for animation -->
  <div class="carousel-inner">
    <div class="item active"><!-- class of active since it's the first item -->
      <div style="background-image: url('tutorial/tut_1.jpg'); background-size:100% 100%; height: 500px;" ></div>
      <div class="carousel-caption">
        <p>Art2Artifact allows you to view the coins by image, map, and timeline.  To select a view, simply click the appropriate button on the “View Collection” page.</p>
      </div>
    </div>
    <div class="item">
      <img src="http://placehold.it/1200x480" alt="" />
      <div class="carousel-caption">
        <p>Caption text here</p>
      </div>
    </div>

  </div><!-- /.carousel-inner -->
  <!--  Next and Previous controls below
        href values must reference the id for this carousel -->
    <a class="carousel-control left" href="#tutorialCarousel" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#tutorialCarousel" data-slide="next">&rsaquo;</a>
</div><!-- /.carousel -->
</div>
</div>
</div>
</center>


<?php include('Includes/footer.php'); ?>
</body>
</html>