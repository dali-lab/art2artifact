<?php
class SunapeeDB
{
    const HOST = "mysql.cs.dartmouth.edu";
    const USER = "salsbury";
    const PASS = "foaziW37C";
    const DB   = "salsbury15";
    private $con = NULL;
	
	//$currentidcoin = "";

    public function connect()
    {
        $this->con = mysql_connect(self::HOST, self::USER, self::PASS);
		if(!$this->con) { die("SQL Error: " . mysql_error()); }
		mysql_select_db(self::DB, $this->con);
		mysql_set_charset("utf8mb4");
    }

    public function get_table($table)
    {
		if($this->con === NULL) { return; }
		$result = mysql_query("SELECT * FROM $table;");
		if(!$result) { die("SQL Error: " . mysql_error()); }
		$this->print_table($result);
		mysql_free_result($result);
    }
	
	public function login($email, $password) {
		if($this->con === NULL) { return; }
		$encrypted_password = md5($password);
		$query = "SELECT * FROM user WHERE email = \"$email\" AND password = \"$encrypted_password\";";
		$result = mysql_query($query);
		if (mysql_num_rows($result) != 0) {		
			if(!$result) { die("SQL Error: " . mysql_error()); }
		
			$row = mysql_fetch_assoc($result);
			$username = $row["name"];
			print("<h2>Welcome ".$username.",</h2>");
			echo '<img style="width: 175px;" ';
			echo 'src="'.$row["file_path"].'"/>';
			echo '<h4>Your Corpora:</h4>';
			$this->get_user_corpora($email);
		} 
		else{
  			header("Location: login.php?test=fail");
		}
		
		
		mysql_free_result($result);
	}
	
	public function filter_options() {
	  
	   echo '<div class="navbar" style="margin-bottom: 0px; margin-right: 30px; margin-left:0px; width: 850px;"><div class="navbar-inner" ><form class="navbar-form pull-left" name="map_options" method="post" action="view_all.php">';
	   echo 'From: <input type="text" name="start_date" value="Start" style="width:75px;"/>';
	   echo '<select name="start_era" style="width:60px;"><option value="">AD</option><option value="-">BCE</option></select>';
	   echo '| To: <input type="text" name="end_date" value="End" style="width:75px;"/><select name="end_era" style="width:60px;">';
	   echo '<option value="">AD</option><option value="-">BCE</option></select>|'; 
   	   $this->get_locations(0);
	   
	   echo '<button type="submit" class="btn pull-right">Submit</button></form></div></div>';
	}
	
	public function get_user_corpora($email) {
		$query = "select idcorpus as ID, title as Title, description as Description, date_created as Date from corpus where created_by = \"" . $email . "\";";
		$result = mysql_query($query);
		 
		
		print("<table class=\"table table-bordered table-hover table-striped\">\n<thead><tr>");
		
		for($i=0; $i < mysql_num_fields($result); $i++) {
	    	print("<th>" . mysql_field_name($result, $i) . "</th>");
		}
		print ("<th>Link</th>");
		
		print("</tr></thead>\n");
	
		while ($row = mysql_fetch_assoc($result)) {
    	      print("\t<tr>\n");
    	      foreach ($row as $col) {
       	          print("\t\t<td>$col</td>\n");
    	      }
			  print("\t\t<td><a href=\"corpus.php?idcorpus=".$row["ID"]."\">View</a></td>\n");
    	      print("\t</tr>\n");
		}
		print("</table>\n");    
		//$this->print_table($result);
	}
	
	public function display_corpus($idcorpus) {
		$i = 0;
		$query = mysql_query("SELECT * FROM corpus WHERE idcorpus = ".$idcorpus);
		$data = mysql_fetch_assoc($query);
		echo '<h1>'.$data["title"].'</h1>';
		echo '<h4>'.$data["description"].'</h4>';
		$query = mysql_query("SELECT * FROM in_corpus WHERE corpus_idcorpus = ".$idcorpus);
		echo '<table class="table table-bordered"><tr>';
		while($data=mysql_fetch_assoc($query))
		{
			 $coin = $data["coin_idcoin"];
			
				$result = mysql_query("SELECT * FROM coin WHERE idcoin = ".$coin.";");
				if ( ($i % 4) == 0) {
					echo '</tr><tr>';
				}
				$the_coin = mysql_fetch_assoc($result);
	  			$encoded = $the_coin["img"];
				echo '<td id='.$the_coin["idcoin"].'><a href="http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$the_coin["idcoin"].'">';
	 			echo '<img style="width: 175px;" ';
				echo 'src="'.$the_coin["file_path"].'"/></a></td>';
				$i++;
			
		}
		echo '</table>';
	
	}
	
	public function register_user($email, $password, $name, $college_affiliation, $status, $file_path) {
		echo "I'm in register_user!";
		$encrypted_pass = md5($password);
		$query = "INSERT INTO user (email, password, name, college_affiliation, status, file_path, administrator) VALUES ('".$email."', '".$encrypted_pass."', '".$name."', '".$college_affiliation."', '".$status."', '".$file_path."', 'false');";
		mysql_query($query);
		$iduser = mysql_insert_id();
		echo $query;
		header("Location: index.php");
		//header("Location: user.php?id=".$iduser);
	}
	
	public function insertCoin($date_start, $era_start, $date_end, $era_end, $mint_lat_long, $find_lat_long, $denomination, $minting_authority, $ob_legend, $reverse_legend, $bibliography, $inserted_by, $file, $era_category, $region_category) {
		//echo 'IM IN INSERTCOIN!!';
		$start = $era_start.$date_start;
		$end = $era_end.$date_end;
		$query = ("INSERT INTO coin (date_start, date_end, mint_lat, mint_long, find_lat, find_long, denomination, minting_authority, obverse_legend, reverse_legend, bibliography, inserted_by, file_path, era_category, region_category)");
		$query .= ("VALUES (".$start.",".$end.",". $mint_lat_long.",".$find_lat_long.",\"".$denomination."\",\"".$minting_authority."\",\"".$ob_legend."\",\"".$reverse_legend."\",\"".$bibliography."\",'"."diana.salsbury@gmail.com"."','".$file."','".$era_category."','".$region_category."');");
		mysql_query($query);
		
		echo $query;
		
		
		$idcoin = mysql_insert_id();
		
		
		$mint = explode(",", $mint_lat_long);
		$mint_lat = $mint[0];
		$mint_long = $mint[1];
		
		$result = mysql_query("SELECT location_name FROM location WHERE latitude = ".$mint_lat." AND longitude = ".$mint_long.";");
		$fetch = mysql_fetch_assoc($result);
		$mint_name = $fetch["location_name"];
		
		$this->add_location_tag($mint_name, $idcoin);
		
		$find = explode(",", $find_lat_long);
		$find_lat = $find[0];
		$find_long = $find[1];
			
		$result = mysql_query("SELECT location_name FROM location WHERE latitude = ".$find_lat." AND longitude = ".$find_long.";");
		$fetch = mysql_fetch_assoc($result);
		$find_name = $fetch["location_name"];
		
		//echo 'adding tagname: '.$find_name;
		
		$this->add_location_tag($find_name, $idcoin);
		$this->add_tag("Denomination-".$denomination, $idcoin);

		echo 'idcoin='.$idcoin;
		
		header("Location: coin.php?idcoin=".$idcoin);
	}
	
	public function create_corpus($created_by, $title, $description) {
		$query = "INSERT INTO corpus (created_by, title, description) values ('".$created_by."', '".$title."', '".$description."');";
		mysql_query($query);
				
		header("Location: view_all.php?idcorpus=".mysql_insert_id());
	}
	
	public function add_to_corpus($idcorpus, $coinsArray) {
		foreach ($coinsArray as $coin) {
			$query = "INSERT INTO in_corpus (corpus_idcorpus, coin_idcoin) VALUES(".$idcorpus.", ".$coin.");";
			echo 'insert query = '.$query;
			mysql_query($query);
		}
		header("Location: view_all.php");
	}
	
	public function tag_coin_set($tag_title, $coinsArray) {
		$query = "SELECT idtag FROM tag WHERE title = \"$tag_title\";";
		echo 'tag id search query = '.$query;
		$result = mysql_query($query);
		$data=mysql_fetch_assoc($result);
		foreach ($coinsArray as $coin) {
			$query = "INSERT INTO coin_has_tag (coin_idcoin, tag_idtag) VALUES (".$coin.", ".$data['idtag'].");";
			echo 'insert query = '.$query;
			mysql_query($query);
		}
		header("Location: view_all.php");
	}
	
	public function add_location_tag($locationName, $idcoin) {
		$check = mysql_query("SELECT title FROM tag where title = '".$locationName."';");
		
		if (mysql_num_rows($check) == 0) {
			$query = ("INSERT INTO tag (title) VALUES (\"$locationName\");");
			mysql_query($query);
		}
		
		
		$result = mysql_query("SELECT idtag FROM tag WHERE title = \"$locationName\";");
		$data=mysql_fetch_assoc($result);
			
		$query = ("INSERT INTO coin_has_tag (coin_idcoin, tag_idtag) VALUES (".$idcoin.", ".$data["idtag"].");");
		mysql_query($query);	
	}
	
	public function add_tag($tagName, $idcoin) {
		$query = ("INSERT INTO tag (title) VALUES (\"$tagName\");");
		mysql_query($query);
		
		$result = mysql_query("SELECT idtag FROM tag WHERE title = \"$tagName\";");
		$data=mysql_fetch_assoc($result);
		
		$query = ("INSERT INTO coin_has_tag (coin_idcoin, tag_idtag) VALUES (".$idcoin.", ".$data["idtag"].");");
		mysql_query($query);		
	}
	
	public function delete_tag($tagName) {
		$result = mysql_query("SELECT idtag FROM tag WHERE title = \"$tagName\";");
		$tagid = mysql_fetch_assoc($result);
		
		echo 'Tag name is: '.$tagName;
		echo 'Tag id is: '.$tagid["idtag"];
		$result = mysql_query("DELETE FROM coin_has_tag WHERE tag_idtag = ".$tagid["idtag"].";");
		$result = mysql_query("DELETE FROM tag WHERE title = \"".$tagName."\";");
	}

   	// Prints pictures
   	public function getpics()
   	{
		$i = 0;
		$query = mysql_query("SELECT * FROM coin");
		echo '<table class="table table-bordered"><tr>';
		while($data=mysql_fetch_assoc($query))
		{
			if ( ($i % 4) == 0) {
				echo '</tr><tr>';
			}
	  		$encoded = $data["img"];
			echo '<td id='.$data["idcoin"].'><a href="http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$data["idcoin"].'">';
	 		echo '<img style="width: 175px;" ';
			echo 'src="'.$data["file_path"].'"/></a></td>';
			$i++;
			
		}
		echo '</table>';
   	}
	
	public function view_all_filtered($start_date, $start_era, $end_date, $end_era, $mint_lat_long, $find_lat_long) {
		if ($start_date == "Start") {$start = " = date_start";	}
		else {$start = " > ".$start_era.$start_date;}
		
		if ($end_date == "End") {$end = " = date_end";}
		else {$end = " < ".$end_era.$end_date;}
		
		$mint = explode(",", $mint_lat_long);
		$mint_lat = $mint[0];
		$mint_long = $mint[1];
		
		$find = explode(",", $find_lat_long);
		$find_lat = $find[0];
		$find_long = $find[1];
		$query = "SELECT * FROM coin WHERE date_start $start AND date_end $end AND find_lat = $find_lat AND find_long = $find_long AND mint_lat = $mint_lat AND find_lat = $find_lat;";
		
		$result = mysql_query($query);
		
		echo '<table class="table table-bordered"><tr>';
		while($data=mysql_fetch_assoc($result))
		{
			if ( ($i % 4) == 0) {
				echo '</tr><tr>';
			}
	  		$encoded = $data["img"];
			echo '<td><a href="http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$data["idcoin"].'">';
	 		echo '<img style="width: 175px;" ';
			echo ' src="data:image/jpeg;base64,'.$encoded.'"></a></td>';
			$i++;
			
		}
		echo '</table>';
		
	}
	
	// create selector with all available tags
	public function get_tag_select() {
		$result = mysql_query("SELECT DISTINCT * FROM tag");
		print("<select name=\"tag_set_selector\" id=\"tag_selector\">");
		
		while ($row = mysql_fetch_assoc($result)) {
			echo '<option value="'.$row["idtag"].'">'.$row["title"].'</option>';
		}
		
			echo '</select>';
	}
	
	// get all available search tags
	public function get_tags() 
	{
		$result = mysql_query("SELECT DISTINCT title as Name FROM tag");
		print("<table class=\"table table-bordered\">\n<thead><tr>");
		
		for($i=0; $i < mysql_num_fields($result); $i++) {
	    	print("<th>" . mysql_field_name($result, $i) . "</th>");
		}
		
		print("</tr></thead>\n");
	
		while ($row = mysql_fetch_assoc($result)) {
    	      print("\t<tr>\n");
    	      foreach ($row as $col) {
       	          print("\t\t<td><a href=\"http://www.cs.dartmouth.edu/~salsbury/art2artifact/view_all.php?searchby=$col\">$col</a></td>\n");
    	      }
    	      print("\t</tr>\n");
		}
		print("</table>\n");  
	}
	
	// get coins with tag
	public function get_tagged_coins($tagname)
	{
		$query = mysql_query("SELECT * FROM coin, coin_has_tag, tag WHERE idcoin = coin_idcoin AND idtag = tag_idtag AND title = \"$tagname\";");
		echo '<table class="table table-bordered"><tr>';
		while($data=mysql_fetch_assoc($query))
		{
			if ( ($i % 4) == 0) {
				echo '</tr><tr>';
			}
	  		$encoded = $data["img"];
			echo '<td><a href="http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$data["idcoin"].'">';
	 		echo '<img style="width: 175px;" ';
			echo 'src="'.$data["file_path"].'"/></a></td>';
			$i++;
			
		}
	}
	
	public function delete_coin($idcoin)
	{
		$query = mysql_query("DELETE FROM coin_has_tag WHERE coin_idcoin = $idcoin;");
		$query = mysql_query("DELETE FROM coin WHERE idcoin = $idcoin;");
		
		header("Location: view_all.php");
		echo '<h3>Coin '.$idcoin.' deleted!</h3>';
	}
	
	public function add_location($name, $lat, $long) {
		$query = mysql_query("INSERT INTO location (location_name, latitude, longitude) VALUES (\"$name\", $lat, $long);");
		header("Location: add_coin.php");
	}
	
	public function get_locations($b) {
		$bool = $b;
		if ($bool == 1) {
			echo 'Mint Location: <select name="mint_lat_long" style="margin-left: 103px;">';
		}
		if ($bool == 0) {
			echo '<select name="mint_lat_long" style="width: 125px; margin-right: 10px;"><option value="mint_lat, mint_long">Mint Location</option>';
		}
		
		$result = mysql_query("SELECT location_name, latitude, longitude FROM location;");
		//echo '<option value="12, 45">Rome</option>';
		while ($row = mysql_fetch_assoc($result)) {
			echo '<option value="'.$row["latitude"].', '.$row["longitude"].'">'.$row["location_name"].'</option>';
		}
		echo '</select>';
		if ($bool == 1) {
			echo '*(If your location does not appear on the list, you must add it <a href="#addLocationModal" data-toggle="modal">here</a>)<br>';
			echo 'Find Location: <select name="find_lat_long" style="margin-left: 103px;">';
		}
		if ($bool == 0) {
			echo '| <select name="find_lat_long" style="width: 125px; margin-right: 10px;"><option value="find_lat, find_long"">Find Location</option>';
		}
		$result = mysql_query("SELECT location_name, latitude, longitude FROM location;");
		while ($row = mysql_fetch_assoc($result)) {
			echo '<option value="'.$row["latitude"].', '.$row["longitude"].'">'.$row["location_name"].'</option>';
		}
		echo '</select>';
		if ($bool == 1) {
 			echo '<br>';
		}
	}
	
	public function filter_query($start_date, $start_era, $end_date, $end_era, $mint_lat_long, $find_lat_long) {
		$start = $start_era.$start_date;
		$end = $end_era.$end_date;
		
		$mint = explode(",", $mint_lat_long);
		$mint_lat = $mint[0];
		$mint_long = $mint[1];
		
		$find = explode(",", $find_lat_long);
		$find_lat = $find[0];
		$find_long = $find[1];
		
		echo 'SELECT * FROM coin WHERE date_start = $start AND end_date = $end AND find_lat = $find_lat AND find_long = $find_long AND mint_lat = $mint_lat AND mint_long = $mint_long;';
		
		$query = mysql_query("SELECT * FROM coin WHERE date_start = $start AND end_date = $end AND find_lat = $find_lat AND find_long = $find_long AND mint_lat = $mint_lat AND mint_long = $mint_long;");
	}
	
	public function individual_coin($idcoin) {
		global $currentidcoin;
		$currentidcoin = $idcoin;
		$query = mysql_query("SELECT * FROM coin WHERE idcoin = $idcoin");
		
		$data=mysql_fetch_assoc($query);
		print("<div class=\"row\"><div class=\"span5\">");
		
		$start_no_dash = trim($data["date_start"], "-");
		$end_no_dash = trim($data["date_end"], "-");
		
		
		echo '<img id="coin_img" src="'.$data["file_path"].'"/></div>';
		//echo '<input class="btn" type="button" onclick="initMagnifier()" value="Use Magnifier"> </div>';
		
		echo '<div class=\"span3\" style="width: 25%;"><h3>Coin Information</h3></p>';
		
		echo '<p>Date: '.$start_no_dash;
		if ($data["date_start"] < 0) { echo 'BCE '; }
		else {echo 'AD ';}
		echo  '- '.$end_no_dash;
		if($data["date_end"] < 0) { echo 'BCE '; }
		else {echo 'AD ';}
		echo '</p>';
		echo '<p>Region: '.$data["region_category"].'</p>';
		echo '<p>Era: '.$data["era_category"].'</p>';
		echo '<p>Denomination: '.$data["denomination"].'</p>';
		echo '<p>Mint Authority: '.$data["minting_authority"].'</p>';
		echo '<p>Obverse Legend: '.$data["obverse_legend"].'</p>';
		echo '<p>Reverse Legend: '.$data["reverse_legend"].'</p>';
		echo '<p>Bibliographic Information: '.$data["bibliography"].'</p>';
		echo '<p>Inserted by: '.$data["inserted_by"].'</p>';
		echo '<p>Date Inserted: '.$data["time_stamp"].'</p>';
		echo '<p>Associated Tags: ';
		
		$result = mysql_query("SELECT title FROM tag, coin_has_tag WHERE tag_idtag = idtag AND coin_idcoin = $idcoin");
		$num_rows = mysql_num_rows($result);
		$i = 1;
		while ($row = mysql_fetch_assoc($result)) {
			foreach ($row as $col) {
				print("<a href=\"http://www.cs.dartmouth.edu/~salsbury/art2artifact/view_all.php?searchby=".$col."\">");
				print($col."</a>");
			}
			if ($i != $num_rows) {
				print(", ");
			}
			$i++;
		}
		print("</p>");
		
	}
	
	public function search_bar() {
		$tags = mysql_query("SELECT title FROM tag;");
		
		$autocompletes = '["'.mysql_fetch_assoc($tags)["title"].'"';
		while ($row = mysql_fetch_assoc($tags)) {
			$autocompletes .= ', "'.$row["title"].'"';
		}
		
		
		$autocompletes = $autocompletes.']';
		//echo '<p>'.$autocompletes.'</p>';
		
		echo '<form style="text-align: center;" class="navbar-form" name="search_bar" method="post" action="search_php.php">';
        echo '<input autocomplete="off" id="coin_search" name="search_val" style="font-size: 44px; width: 400px; height: 60px;" type="text" data-provide="typeahead" data-source=\''.$autocompletes.'\'>';
		echo '</form>';
	}
	
	public function search($tagname) {
		$result_tags = mysql_query("SELECT title FROM tag WHERE title = \"".$tagname."\";");
		$result_location = mysql_query("SELECT location_name FROM location WHERE location_name = \"".$tagname."\";");
		
		if ( (mysql_num_rows($result_tags) == 0) && (mysql_num_rows($result_location) == 0)){
			print("<h3>Sorry, that search tag does not exist</h3>");
		}
		else {
			header("Location: view_all.php?searchby=".$tagname);
		}
	}
	
	public function plot_coin($idcoin) {
		echo '<script type="text/javascript">';
      	echo 'function initialize() {';
        echo 'var mapOptions = {';
		$result = mysql_query("SELECT mint_lat, mint_long, find_lat, find_long, idcoin FROM coin WHERE idcoin = ".$idcoin.";");
		
		while ($row = mysql_fetch_assoc($result)) {
	        echo 'center: new google.maps.LatLng( ' . $row["mint_lat"] . ', '. $row["mint_long"] .'),';
	        echo 'zoom: 5,';
	        echo 'mapTypeId: google.maps.MapTypeId.TERRAIN';
	        echo '};';
	        echo 'var map = new google.maps.Map(document.getElementById("map-canvas"),';
	        echo 'mapOptions);';
			echo 'marker = new google.maps.Marker({';
	        echo 'position: new google.maps.LatLng( ' . $row["mint_lat"] . ', '. $row["mint_long"] .'),';
	        echo 'map: map,';
			//echo 'title: "Coin ID: '.$row["idcoin"].'",';
			echo 'title: "Mint Location",';
			echo 'url: "http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$row["idcoin"].'"';
	        echo '});';
			echo 'google.maps.event.addListener(marker, "click", function() {';
  			echo 'window.location.href = marker.url;';
			echo '});';
			
			
			echo 'marker = new google.maps.Marker({';
	        echo 'position: new google.maps.LatLng( ' . $row["find_lat"] . ', '. $row["find_long"] .'),';
	        echo 'map: map,';
			//echo 'title: "Coin ID: '.$row["idcoin"].'",';
			echo 'title: "Find Location",';
			echo 'url: "http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$row["idcoin"].'"';
	        echo '});';
			echo 'iconFile = "http://maps.google.com/mapfiles/ms/icons/green-dot.png";';
			echo 'marker.setIcon(iconFile);';
			echo 'google.maps.event.addListener(marker, "click", function() {';
  			echo 'window.location.href = marker.url;';
			echo '});';
		}
		
	    echo '}';
	  
	  
        echo 'google.maps.event.addDomListener(window, "load", initialize);';
        echo '</script>';
		
	}
	
	public function add_markers_filtered($start_date, $start_era, $end_date, $end_era, $mint_lat_long, $find_lat_long) {
		if ($start_date == "Start") {$start = " = date_start";	}
		else {$start = " > ".$start_era.$start_date;}
		
		if ($end_date == "End") {$end = " = date_end";}
		else {$end = " < ".$end_era.$end_date;}
		
		$mint = explode(",", $mint_lat_long);
		$mint_lat = $mint[0];
		$mint_long = $mint[1];
		
		$find = explode(",", $find_lat_long);
		$find_lat = $find[0];
		$find_long = $find[1];
		$query = "SELECT mint_lat, mint_long, find_lat, find_long, idcoin FROM coin WHERE date_start $start AND date_end $end AND find_lat = $find_lat AND find_long = $find_long AND mint_lat = $mint_lat AND find_lat = $find_lat;";
		
		$result = mysql_query($query);
		//echo '<p>end_era='.$end_era.'</p>';
		//echo '<p>'.$query.'</p>';
		echo '<script type="text/javascript">';
      	echo 'function initialize() {';
        echo 'var mapOptions = {';
        echo 'center: new google.maps.LatLng(42, 12.5),';
        echo 'zoom: 5,';
        echo 'mapTypeId: google.maps.MapTypeId.TERRAIN';
        echo '};';
        echo 'var map = new google.maps.Map(document.getElementById("map-canvas"),';
        echo 'mapOptions);';
		
		while ($row = mysql_fetch_assoc($result)) {
			echo 'marker = new google.maps.Marker({';
	        echo 'position: new google.maps.LatLng( ' . $row["mint_lat"] . ', '. $row["mint_long"] .'),';
	        echo 'map: map,';
			//echo 'title: "Coin ID: '.$row["idcoin"].'",';
			echo 'title: "('.$row["mint_lat"].', '.$row["mint_long"].')",';
			echo 'url: "http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$row["idcoin"].'"';
	        echo '});';
			echo 'google.maps.event.addListener(marker, "click", function() {';
  			echo 'window.location.href = marker.url;';
			echo '});';
			
			
			echo 'marker = new google.maps.Marker({';
	        echo 'position: new google.maps.LatLng( ' . $row["find_lat"] . ', '. $row["find_long"] .'),';
	        echo 'map: map,';
			//echo 'title: "Coin ID: '.$row["idcoin"].'",';
			echo 'title: "('.$row["mint_lat"].', '.$row["mint_long"].')",';
			echo 'url: "http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$row["idcoin"].'"';
	        echo '});';
			echo 'iconFile = "http://maps.google.com/mapfiles/ms/icons/green-dot.png";';
			echo 'marker.setIcon(iconFile);';
			echo 'google.maps.event.addListener(marker, "click", function() {';
  			echo 'window.location.href = marker.url;';
			echo '});';
		}
		
	    echo '}';
	  
        echo 'google.maps.event.addDomListener(window, "load", initialize);';
        echo '</script>';
	
	}
	
	public function add_markers() {      
		echo '<script type="text/javascript">';
      	echo 'function initialize() {';
        echo 'var mapOptions = {';
        echo 'center: new google.maps.LatLng(42, 12.5),';
        echo 'zoom: 5,';
        echo 'mapTypeId: google.maps.MapTypeId.TERRAIN';
        echo '};';
        echo 'var map = new google.maps.Map(document.getElementById("map-canvas"),';
        echo 'mapOptions);';
		
		$result = mysql_query("SELECT mint_lat, mint_long, find_lat, find_long, idcoin FROM coin;");
		while ($row = mysql_fetch_assoc($result)) {
			echo 'marker = new google.maps.Marker({';
	        echo 'position: new google.maps.LatLng( ' . $row["mint_lat"] . ', '. $row["mint_long"] .'),';
	        echo 'map: map,';
			//echo 'title: "Coin ID: '.$row["idcoin"].'",';
			echo 'title: "('.$row["mint_lat"].', '.$row["mint_long"].')",';
			echo 'url: "http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$row["idcoin"].'"';
	        echo '});';
			echo 'google.maps.event.addListener(marker, "click", function() {';
  			echo 'window.location.href = marker.url;';
			echo '});';
			
			
			echo 'marker = new google.maps.Marker({';
	        echo 'position: new google.maps.LatLng( ' . $row["find_lat"] . ', '. $row["find_long"] .'),';
	        echo 'map: map,';
			//echo 'title: "Coin ID: '.$row["idcoin"].'",';
			echo 'title: "('.$row["mint_lat"].', '.$row["mint_long"].')",';
			echo 'url: "http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$row["idcoin"].'"';
	        echo '});';
			echo 'iconFile = "http://maps.google.com/mapfiles/ms/icons/green-dot.png";';
			echo 'marker.setIcon(iconFile);';
			echo 'google.maps.event.addListener(marker, "click", function() {';
  			echo 'window.location.href = marker.url;';
			echo '});';
		}
		
	    echo '}';
	  
	  	echo 'function setmarker(lat,lon)';
	    echo '{';
	    echo 'var latlongMarker = new google.maps.LatLng(lat,lon);';
	    echo 'var marker = new google.maps.Marker';
	    echo '({';
	    echo 'position: latlongMarker, ';
	    echo 'map: map,';
	    echo 'title:"Hello World!"';
	    echo '});'; 
	    echo '}';
	  
        echo 'google.maps.event.addDomListener(window, "load", initialize);';
        echo '</script>';
		
		
	}
	
	public function autocomplete_search() {
		$result = mysql_query("SELECT title FROM tag;");
		
		echo '<script>';
		echo '$(function() {var availableTags = [';
		while ($row = mysql_fetch_assoc($result)) {
			echo '"'.$row["title"].'",';
		}
		echo '];$( "#tags" ).autocomplete({source: availableTags});});';
		echo '</script>';
	}
	
	public function load_timeline() {
		$result = mysql_query("SELECT * FROM coin;");
		
		
		while ($row = mysql_fetch_assoc($result)) {
		
			print("\t\t{'start': '".$row["date_start"]."',\n");
			
			if ($row["date_start"] != $row["date_end"]) {print("\t\t'end': '".$row["date_end"]."',\n"); }
			print("\t\t'title': '".$row["obverse_legend"]."',\n");
			print("\t\t'description': 'Denomination: ".$row["denomination"]."',\n");
			print("\t\t'image': '".$row["file_path"]."',\n");
        	print("\t\t'link': 'coin.php?idcoin=".$row["idcoin"]."'\n");
			print("\t\t},\n");	
		}
	
	}
	
	public function load_timeline_filtered($start_date, $start_era, $end_date, $end_era, $mint_lat_long, $find_lat_long, $era_category, $region_category) {
		if ($start_date == "Start") {$start = " = date_start";	}
		else {$start = " > ".$start_era.$start_date;}
		
		if ($end_date == "End") {$end = " = date_end";}
		else {$end = " < ".$end_era.$end_date;}
		
		$mint = explode(",", $mint_lat_long);
		$mint_lat = $mint[0];
		$mint_long = $mint[1];
		
		$find = explode(",", $find_lat_long);
		$find_lat = $find[0];
		$find_long = $find[1];
		$query = "SELECT * FROM coin WHERE date_start $start AND date_end $end AND find_lat = $find_lat AND find_long = $find_long AND mint_lat = $mint_lat AND find_lat = $find_lat AND era_category = $era_category AND region_category = $region_category;";
		
		
		
		//echo $query;
		$result = mysql_query($query);
		
		while ($row = mysql_fetch_assoc($result)) {
		
			print("\t\t{'start': '".$row["date_start"]."',\n");
			
			if ($row["date_start"] != $row["date_end"]) {print("\t\t'end': '".$row["date_end"]."',\n"); }
			print("\t\t'title': '".$row["obverse_legend"]."',\n");
			print("\t\t'description': 'Denomination: ".$row["denomination"]."',\n");
			print("\t\t'image': '".$row["file_path"]."',\n");
        	print("\t\t'link': 'coin.php?idcoin=".$row["idcoin"]."'\n");
			print("\t\t},\n");	
		}
	
	}
		
	private function print_table($result)
    {
     	print("<table class=\"table table-bordered table-hover table-striped\">\n<thead><tr>");
		
		for($i=0; $i < mysql_num_fields($result); $i++) {
	    	print("<th>" . mysql_field_name($result, $i) . "</th>");
		}
		
		print("</tr></thead>\n");
	
		while ($row = mysql_fetch_assoc($result)) {
    	      print("\t<tr>\n");
    	      foreach ($row as $col) {
       	          print("\t\t<td>$col</td>\n");
    	      }
    	      print("\t</tr>\n");
		}
		print("</table>\n");    
    }	
	
	// Disconnects from the database
    public function disconnect()
    {
	 if($this->con != NULL) { mysql_close($this->con);}
    }
	
}
?>