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
    $('.carousel').carousel(
{
pause: true,
interval: false
});
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

<center>
	<h3 style="color: #FACE8D; font-size: 50px;">Tutorial</h3>
<!--  Carousel - consult the Twitter Bootstrap docs at
      http://twitter.github.com/bootstrap/javascript.html#carousel -->
<div id="tutorialCarousel" class="carousel" style="width: 60%;"><!-- class of slide for animation -->
  <div class="carousel-inner">
  	<?php
  		if ($_SESSION["status"] == "Guest") {
			echo '<div class="item active"><!-- class of active since its the first item -->';
	      	echo '<div style="background-image: url(\'tutorial/tut_1_1.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
	      	echo '<div class="carousel-caption">';
	       	echo ' <p>As a new user you are automatically assigned the "Guest" user privilege.  If you would like access to the student features of Art2Artifact (building
        	and saving corpora) or would like to request Administrator status, select the "Request Status Change" option from your homepage.  A registered Admin
        	will need to approve your request before you receive access to these capabilities.</p>';
	      	echo '</div>';
	    	echo '</div>';
			echo '<div class="item"><!-- class of active since it\'s the first item -->';
      		echo '<div style="background-image: url(\'tutorial/tut_1.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
    		
		}
		else {
			echo '<div class="item active"><!-- class of active since it\'s the first item -->';
      		echo '<div style="background-image: url(\'tutorial/tut_1.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
		}
  	?>
      <div class="carousel-caption">
        <p>Art2Artifact allows you to view the coins by image, map, and timeline.  To select a view, simply click the appropriate button on the “View Collection” page.</p>
      </div>
    </div>
    <div class="item"><!-- class of active since it's the first item -->
      <div style="background-image: url('tutorial/tut_2.jpg'); background-size:100% 100%; height: 500px;" ></div>
      <div class="carousel-caption">
        <p>To Search the coins, first select "Tools" and then "Show/Hide Filters."  Enter your search parameters and then select "Submit."</p>
      </div>
    </div>
    <div class="item"><!-- class of active since it's the first item -->
      <div style="background-image: url('tutorial/tut_2_1.jpg'); background-size:100% 100%; height: 500px;" ></div>
      <div class="carousel-caption">
        <p>To view an individual coin, simply select "View" from it's thumbnail image from anywhere on the site.  The coin's individual page has 
        several tools for viewing the coin's image, information, and mapped location.  You may also tag, edit or delete the coin from it's individual
        page, provided you have the proper privileges.</p>
      </div>
    </div>
    <div class="item"><!-- class of active since it's the first item -->
      <div style="background-image: url('tutorial/tut_3.jpg'); background-size:100% 100%; height: 500px;" ></div>
      <div class="carousel-caption">
        <p>To View Published Corpora select "View Collection" from the Menu Bar and then select "View Published Corpora" and select a corpus to study!</p>
      </div>
    </div>
    <div class="item"><!-- class of active since it's the first item -->
      <div style="background-image: url('tutorial/tut_4.jpg'); background-size:100% 100%; height: 500px;" ></div>
      <div class="carousel-caption">
        <p>The published corpus page contains a sandbox of images of the coins, a map view, as well as any added notes the author chose to include.</p>
      </div>
    </div>
    <?php
    	if ($_SESSION["status"] == "Student" || $_SESSION["status"] == "Admin") {
    		echo '<div class="item"><!-- class of active since its the first item -->';
      		echo '<div style="background-image: url(\'tutorial/tut_5.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
      		echo '<div class="carousel-caption">';
       		echo ' <p>To Create a new Corpus, select "Build New Corpus" from the Menu Bar.  Enter a Title and Description for your Corpus.</p>';
      		echo '</div>';
    		echo '</div>';
			
			echo '<div class="item"><!-- class of active since its the first item -->';
      		echo '<div style="background-image: url(\'tutorial/tut_6.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
      		echo '<div class="carousel-caption">';
       		echo ' <p>To add coins to your corpus, first go to the "View All" page under "View Collection" and select "Add coins to corpus" from 
       			the Tools menu.  To select a coin you wish to add, click on the coin so that it turns blue.  To deselect it, click it again so that
       			it turns white again.  Once you have selected all the coins you wish to add, select the corpus to add to and click "Add selected Coins
       			to Corpus."  You can add coins to working corpora at any time.
       			</p>';
      		echo '</div>';
    		echo '</div>';
			
			echo '<div class="item"><!-- class of active since its the first item -->';
      		echo '<div style="background-image: url(\'tutorial/tut_7.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
      		echo '<div class="carousel-caption">';
       		echo ' <p>Your unpublished Corpus Page has a space to add/save notes and a sandbox to view the coin images as well as plot them on the
       		map.  The tools menu allows you to delete groups of coins from the corpus, delete the corpus, and publish your corpus to be visible
       		to all registered users.</p>';
      		echo '</div>';
    		echo '</div>';
			
			echo '<div class="item"><!-- class of active since its the first item -->';
      		echo '<div style="background-image: url(\'tutorial/tut_8.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
      		echo '<div class="carousel-caption">';
       		echo ' <p>To add a search tag to a group of coins from the View Collection page, select the coins you wish to tag, then enter the tag
       		name and click "Tag Selected Coins."</p>';
      		echo '</div>';
    		echo '</div>';
			
			if ($_SESSION["status"] == "Admin") {
				echo '<div class="item"><!-- class of active since its the first item -->';
	      		echo '<div style="background-image: url(\'tutorial/tut_9.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
	      		echo '<div class="carousel-caption">';
	       		echo ' <p>To Add a coin, select the "Add Coin" tool from the Admin Tools menu on the menu bar.  Upload a photo and enter the proper
	       		information, then select "Add Coin."</p>';
	      		echo '</div>';
	    		echo '</div>';
				
				echo '<div class="item"><!-- class of active since its the first item -->';
	      		echo '<div style="background-image: url(\'tutorial/tut_10.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
	      		echo '<div class="carousel-caption">';
	       		echo ' <p>If, while adding a coin, the mint or find locations are not present on the dropdown lists, you can add a new location by 
	       		entering its name, latitude and longitude in the entry fields.</p>';
	      		echo '</div>';
	    		echo '</div>';
				
				echo '<div class="item"><!-- class of active since its the first item -->';
	      		echo '<div style="background-image: url(\'tutorial/tut_11.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
	      		echo '<div class="carousel-caption">';
	       		echo ' <p>If you wish to edit a coin, select the "Edit coin" option from the coin\'s individual page.  Alter any fields you wish, and 
	       		then save by clicking "Submit Changes."</p>';
	      		echo '</div>';
	    		echo '</div>';
				
				echo '<div class="item"><!-- class of active since its the first item -->';
	      		echo '<div style="background-image: url(\'tutorial/tut_12.jpg\'); background-size:100% 100%; height: 500px;" ></div>';
	      		echo '<div class="carousel-caption">';
	       		echo ' <p>One privilege that comes with the "Admin" status is the ability to approve requests from "Guest" status users to become
	       		"Student" or "Admin" status users, and to upgrade "Students" to "Admins" as well.  To approve any requests, simply select "Approve
	       		Requests" from the Admin Tools menu option and approve any pending requests.</p>';
	      		echo '</div>';
	    		echo '</div>';
			}
			
    	}

		
		
		echo '<div class="item"><!-- class of active since its the first item -->';
		echo '<div style="background-size:100% 100%; height: 500px; padding-top: 200px;" >';
		echo '<a href="view_collection.php" class="btn btn-large" style="margin-bottom: 50px;">View Collection</a><br>';
		if ($_SESSION["status"] == "Guest") {
			echo '<a href="view_published_corpora.php" class="btn btn-large">Explore Published Corpora</a>';
		}
		else {
			echo '<a href="index.php?new_corpus=true" class="btn btn-large">Start Building a Corpus</a>';
		}
		echo '</div>';
	    echo '</div>';
    ?>
  </div>

    <a class="carousel-control left" href="#tutorialCarousel" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#tutorialCarousel" data-slide="next">&rsaquo;</a>
  </div><!-- /.carousel-inner -->
  <!--  Next and Previous controls below
        href values must reference the id for this carousel -->
</div><!-- /.carousel -->
</div>
</center>


<?php include('Includes/footer.php'); ?>
</body>
</html>