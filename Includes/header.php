
<div class="navbar" style="margin-bottom: 0px;">
    <div class="navbar-inner">
    	<a class="brand" href="about.php">Art 2 Artifact</a>
    	<ul class="nav">
			<?php
				session_start();
				
		       		echo '<li><a href="splash.php">Home</a></li>';
				if ($_SESSION['status'] == "Student") {
					echo '<li><a href="index.php?new_corpora=true">Build new Corpus</a></li>';
				}
				
		       	if ($_SESSION['status'] == "Admin") {
					echo '<li><a href="index.php?new_corpus=true">Build new Corpus</a></li>';
					echo '<ul class="nav pull-left"><li class="dropdown">';
					echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin Tools<b class="caret"></b></a>';
					echo '<ul class="dropdown-menu">';
					echo '<li><a href="view_all_corpora.php">View All Corpora</a></li>';
					echo '<li><a href="add_coin.php">Add Coin</a></li>';
					echo '<li><a href="pending_requests.php">Approve Requests</a></li>';
					echo '</ul></li>';
				
				}
				
				echo '<ul class="nav pull-left"><li class="dropdown">';
				echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">View Collection<b class="caret"></b></a>';
				echo '<ul class="dropdown-menu">';
				echo '<li><a href="view_collection.php">View all</a></li>';
				echo '<li><a href="timeline.php">Timeline</a></li>';
				echo '<li><a href="view_published_corpora.php">View Published Corpora</a></li>';
				echo '</ul></li></ul>';
				//echo '<li><a href="view_tags.php">View Search Tags</a></li>';
				//echo '<li><a href="map.php">Plot Coins</a></li>';
		    	//echo '<li><a href="search.php">Search</a></li>';
				echo '<li>';
				
				echo '<form class="navbar-form" name="search_bar" method="post" action="search_php.php">';
        		echo '<input autocomplete="off" id="coin_search" name="search_val" type="text" >';
				echo '</form></li>';
				
				echo '</ul>';
				
				
				echo '<ul class="nav pull-right"><li class="dropdown">';
				echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$_SESSION['email'].'<b class="caret"></b></a>';
				echo '<ul class="dropdown-menu">';
				echo '<li><a href="edit_user.php">Edit Personal Info</a></li>';
				echo '<li><a href="tutorial.php">Tutorial</a></li>';
				echo '<li><a href="login.php">Logout</a></li>';
				echo '</ul></li></ul>';
			?>	
    </div>
</div>