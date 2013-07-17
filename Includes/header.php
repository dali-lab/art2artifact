
<div class="navbar navbar-inverse" style="margin-bottom: 0px;">
    <div class="navbar-inner">
    	<a class="brand" href="#">Art 2 Artifact</a>
    	<ul class="nav">
			<?php
				session_start();
				
				if ($_SESSION['status'] == "Student") {
			   		echo '<li><a href="index.php">Home</a></li>';
				}
				
		       	if ($_SESSION['status'] == "Admin") {
					echo '<ul class="nav pull-left"><li class="dropdown">';
					echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin Tools<b class="caret"></b></a>';
					echo '<ul class="dropdown-menu">';
					
			   		echo '<li><a href="index.php">Home</a></li>';
					echo '<li><a href="add_coin.php">Add Coin</a></li>';
					echo '<li><a href="pending_requests.php">Approve Requests</a></li>';
					echo '</ul></li></ul>';
				
				}
				
				echo '<li><a href="view_collection.php">View Collection</a></li>';
				echo '<li><a href="timeline.php">Timeline</a></li>';
				//echo '<li><a href="view_tags.php">View Search Tags</a></li>';
				//echo '<li><a href="map.php">Plot Coins</a></li>';
		    	echo '<li><a href="search.php">Search</a></li>';
				
				echo '</ul>';
				
				
				echo '<ul class="nav pull-right"><li class="dropdown">';
				echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Logged in as '.$_SESSION['email'].'<b class="caret"></b></a>';
				echo '<ul class="dropdown-menu">';
				echo '<li><a href="edit_user.php">Edit Personal Info</a></li>';
				echo '<li><a href="login.php">Logout</a></li>';
				echo '</ul></li></ul>';
			?>
    </div>
</div>