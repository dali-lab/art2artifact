<?php
class SunapeeDB
{
    const HOST = "us-cdbr-east-04.cleardb.com";
    const USER = "bdad21dac711b9";
    const PASS = "5d77a9ce";
    const DB   = "heroku_cbef9007d9ba07d"; 
	/*
	const HOST = "mysql.cs.dartmouth.edu";
    const USER = "salsbury";
    const PASS = "foaziW37C";
    const DB   = "salsbury15";
    private $con = NULL;*/
	
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
			echo '<div class="row" >';
			echo '<div class="span2" style="height: 100px; width: 100px;">';
			echo '<img src="'.$row["file_path"].'" style="width: 100px; height:auto; max-width: 100px;"/></div>';
			echo '<div class="span8">';
			print("<h2 style='position: relative; color: #FACE8D;'>Welcome ".$username.",</h2>");
			$_SESSION['status'] = $row["status"];
			echo '<h6 style="color: #FACE8D;">Your status: '.$_SESSION['status'].'</h6></div></div>';
			if ($row["status"] == "Student" || $row["status"] == "Admin") {
				echo '<a class="btn btn-large pull-right" data-toggle="modal" href="#add_corpus_modal" style="margin-right: 50px;">+</a>';
				echo '<h4 style="color: #FACE8D;">Your Corpora:</h4>';
				$this->get_user_corpora($email);
			}
			
			
			if (!is_null($row["requested_status"])) {
				echo '<h4>Requested status: '.$row["requested_status"].'</h4>';
			}
			
			if ( ($row["status"] == "Guest") || ($row["status"] == "Student") ){
				echo '<a class="btn" data-toggle="modal" href="#change_status_modal">Request Student/Admin status</a>';
			}
			
		} 
		else{
  			header("Location: login.php?test=fail");
		}
		
		
		mysql_free_result($result);
	}
	
	public function request_change($status, $email) {
		echo 'Status='.$status;
		echo 'Email='.$email;
		$query = "UPDATE user SET requested_status = '".$status."' WHERE email = '".$email."';";
		$result = mysql_query($query);
		echo 'Query='.$query;
		header("Location: index.php");
	}
	
	public function change_status($status, $email) {
		$query = "UPDATE user SET status = '".$status."' WHERE email = '".$email."';";
		echo 'Query='.$query;
		$result = mysql_query($query);
		
		$query = "UPDATE user SET requested_status = null WHERE email = '".$email."';";
		$result = mysql_query($query);
		header("Location: pending_requests.php");
	}
	
	
	public function check_login($email, $password) {
		if($this->con === NULL) { return; }
		$encrypted_password = md5($password);
		$query = "SELECT * FROM user WHERE email = \"$email\" AND password = \"$encrypted_password\";";
		$result = mysql_query($query);
		if (mysql_num_rows($result) != 0) {		
			if(!$result) { die("SQL Error: " . mysql_error()); }
		
			$row = mysql_fetch_assoc($result);
			$username = $row["name"];
			$_SESSION['status'] = $row["status"];
			header("Location: splash.php");
		} 
		else{
  			header("Location: login.php?test=fail");
		}
		
		
		mysql_free_result($result);
	}
	
	public function delete_user($email) {
		//$query = "
	}
	
	public function edit_user_info($email, $password) {
	
		$result = mysql_query("SELECT * FROM user WHERE email = '".$email."';");
		$row = mysql_fetch_assoc($result);
		
		
		echo '<div class="control-group"><label class="control-label" for="email">Email:</label><div class="controls">';
		echo '<p style="margin-top:5px;">'.$email.'</p></div></div>';
		echo '<div class="control-group" style="margin-bottom: 0px;"><label class="control-label" for="file">';
		echo 'Profile Picture</label><div class="controls">';
		echo '<input type="file" name="file" id="file"> <p style="width: 206px;"><p style="font-size: 12px;">(*If you do not upload a file your profile picture will remain unchanged)</p></p>';
		echo '</div></div><input type="hidden" name="uploaded" value="1">';
		echo '<div class="control-group"><label class="control-label" for="email">Name:</label>';
        echo '<div class="controls"><input type="text" value="'.$row["name"].'" name="name"></div></div>';
		echo '<div class="control-group" style="margin-bottom: 0px;"><label class="control-label" for="email">Password:</label>';
        echo '<div class="controls"><input type="password" name="password" id="password_input_1">';
		echo '<p style="width: 206px;"><p style="font-size: 12px;">(*If you do not enter a password here your password will remain unchanged)</p></p></div></div>';
		echo '<div class="control-group" style="margin-bottom: 0px;"><label class="control-label" for="email">Input Password Again:</label>';
        echo '<div class="controls"><input type="password" name="password2"></div></div>';
		echo '<div class="control-group" style="margin-bottom: 0px;"><label class="control-label" for="email">University Affiliation:</label>';
        echo '<div class="controls"><input type="text" value="'.$row["college_affiliation"].'" name="affiliation"></div></div>';
		echo '<center><input class="btn btn-primary btn-large" type="submit" value="Edit Account"></center>';

	
	}

	public function edit_coin_info($idcoin) {
		$result = mysql_query("SELECT * FROM coin WHERE idcoin = ".$idcoin.";");
		$row = mysql_fetch_assoc($result);
		
	
		
		echo '<form action="add_coin_php.php" method="post" ENCTYPE="multipart/form-data" class="form-horizontal" id="add-coin">';
        
        echo '<div class="control-group" style="margin-bottom: 0px;">';
        echo '<label class="control-label" for="era_category">';
        echo 'Era Category:';
        echo '</label>';
        echo '<div class="controls">';
      
			$dropdown = '<select name="era_category">
				<option value="Republican">REPUBLICAN</option>
				<option value="Imperial">IMPERIAL</option>
				<option value="Archaic">ARCHAIC</option>
 				<option value="Classical">CLASSICAL</option>
        		<option value="Hellenistic">HELLENISTIC</option>
        		</select>';
			$dropdown = str_replace($row["era_category"], $row['era_category']."\" selected=\"selected",$dropdown);
        echo $dropdown;
        echo '</div>';
        echo '</div>';
        echo '<div class="control-group" style="margin-bottom: 0px;">';
        echo '<label class="control-label" for="region_category">';
        echo ' Region Category:';
        echo '</label>';
        echo '<div class="controls">';
		$dropdown = '<select name="region_category"><option value="Greek">GREEK</option><option value="Roman">ROMAN</option></select>';
			$dropdown = str_replace($row["region_category"], $row['region_category']."\" selected=\"selected",$dropdown);
        echo $dropdown;
        echo '</div>';
        echo '</div>';
        echo ' <div class="control-group" style="margin-bottom: 0px;"> <label class="control-label" for="dates_div"> Date Range: </label>';
		echo '<div class="controls">';
		echo '<div name="dates_div">';
			
			$erastart = strpos($row["date_start"], '-');
			$datestart = trim($row["date_start"], '-');
		echo '<input style="width: 100px;" type="text" name="date_start"  value="'.$datestart.'" >';
		echo '<select name="era_start" style="width: 60px;">';
		
			if ($erastart == true) {				
				echo '	<option value="-">BCE</option>';
				echo '	<option value="" selected>AD</option>';
			}
			else {
				echo '<option value="-" selected>BCE</option>';
				echo '<option value="">AD</option>';	
			}
		echo '</select>';
		echo '-';
		
			$eraend = strpos($row["date_end"], '-');
			$dateend = trim($row["date_end"], '-');
		echo '<input type="text" style="width: 100px;" name="date_end" value="'.$dateend.'">';
		echo '<select name="era_end" style="width: 60px;">';
		if ($eraend == true) {				
				echo '	<option value="-">BCE</option>';
				echo '	<option value="" selected>AD</option>';
			}
			else {
				echo '<option value="-" selected>BCE</option>';
				echo '<option value="">AD</option>';	
			}
		echo '</select>';
		echo '</div>';
		echo '</div>';

		echo '<p style="margin-left: 30px;">';
		echo '*(If you have a specific date enter it for both the start and end dates)';
		echo '</p>';
		echo '</div>';
		$this->get_locations(1);
		
						
        echo '<div class="control-group" style="margin-bottom: 0px;">';
        echo '   <label class="control-label" for="denomination">';
        echo '     Denomination:';
        echo '  </label>';
        echo '<div class="controls">';
        echo '  <input type="text" name="denomination" value="'.$row["denomination"].'">';
        echo ' </div>';
        echo '</div>';
        echo '<div class="control-group" style="margin-bottom: 0px;">';
        echo '  <label class="control-label" for="mint_authority">';
        echo '     Mint Authority:';
        echo '  </label>';
        echo '  <div class="controls">';
        echo '     <input type="text" name="mint_authority" value="'.$row["mint_authority"].'">';
        echo ' </div>';
		echo '  </div>';
        echo '  <div class="control-group" style="margin-bottom: 0px;">';
        echo '     <label class="control-label" for="obverse_legend">';
        echo '         Obverse Legend:';
        echo '      </label>';
        echo '      <div class="controls">';
        echo '         <input type="text" name="obverse_legend" value="'.$row["obverse_legend"].'">';
        echo '      </div>';
        echo '   </div>';
        echo '   <div class="control-group" style="margin-bottom: 0px;">';
        echo '       <label class="control-label" for="reverse_legend">';
        echo '          Reverse Legend:';
        echo '      </label>';
        echo '      <div class="controls">';
        echo '          <input type="text" name="reverse_legend" value="'.$row["reverse_legend"].'">';
        echo '      </div>';
        echo '   </div>';
        echo '    <div class="control-group" style="margin-bottom: 0px;">';
        echo '        <label class="control-label" for="bibliography">';
        echo '           Bibliography:';
        echo '        </label>';
        echo '         <div class="controls">';
        echo '             <input type="text" name="bibliography" value="'.$row["bibliography"].'">';
        echo '         </div>';
		
		
		echo '<p style="margin-left: 30px; font-size: 10px;">';
		echo'*If you do not change the locations they will remain unedited.';
		echo '</p>';
		
        echo '      </div><center><input class="btn btn-primary" type="submit" value="Submit Changes"></center>';
        echo ' </form>';
		
	}
	
	public function get_header($status) {
	
		if ($status == "Admin") {
			echo '<li>Only for admins</li>';
		}
		if ( ($status == "Student") || ($status == "Admin") ) {
	   		echo '<li><a href="index.php">Home</a></li>';
		}
		
		echo '<li><a href="view_all.php">View All</a></li>';
		echo '<li><a href="timeline.php">Timeline</a></li>';
		echo '<li><a href="view_tags.php">View Search Tags</a></li>';
		echo '<li><a href="map.php">Plot Coins</a></li>';
    	echo '<li><a href="search.php">Search</a></li>';
		echo '<li><a href="login.php">Logout</a></li>';
		
		
			
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
		$query = "select idcorpus as ID, title as Title, description as Description, date_created as Date, published as 'Published/Private' from corpus where created_by = \"" . $email . "\";";
		$result = mysql_query($query);
		 
		echo '<div class="well" style="width: 70%;">';
		print("<table class=\"table table-hover\">\n<thead><tr>");
		
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
		echo '</div>'; 
		//$this->print_table($result);
	}

	public function view_all_corpora() {
		$query = "select created_by as 'Created By', idcorpus as ID, title as Title, description as Description, date_created as Date, published as 'Published/Private' from corpus;";
		$result = mysql_query($query);
		 
		echo '<div class="well" style="width: 90%;">';
		print("<table class=\"table table-hover\">\n<thead><tr>");
		
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
		echo '</div>'; 
		//$this->print_table($result);
	}
	
	public function view_all_published_corpora() {
		$query = "select created_by as 'Created By', idcorpus as ID, title as Title, description as Description, date_created as Date from corpus where published = 'Published';";
		$result = mysql_query($query);
		 
		echo '<div class="well" style="width: 90%;">';
		print("<table class=\"table table-hover\">\n<thead><tr>");
		
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
		echo '</div>'; 
	}
	
	
	public function get_pending_requests() {
		$result = mysql_query("SELECT email as Email, college_affiliation as Affiliation, requested_status as 'Requested Status' FROM user WHERE requested_status IS NOT NULL;");
		echo '<div class="well" style="width: 90%;">';
		print("<table class=\"table table-hover\">\n<thead><tr>");
		
		for($i=0; $i < mysql_num_fields($result); $i++) {
	    	print("<th>" . mysql_field_name($result, $i) . "</th>");
		}
		
		print("</tr></thead>\n");
	
		while ($row = mysql_fetch_assoc($result)) {
    	      print("\t<tr>\n");
    	      foreach ($row as $col) {
       	          print("\t\t<td>$col</td>\n");
    	      }
			  print ("\t\t<td><a href=\"request_change.php?email=".$row["Email"]."&&status=".$row["Requested Status"]."\">Approve</a></td>\n");
    	      print("\t</tr>\n");
		}
		print("</table>\n"); 
		echo '</div>';   
	}
	
	public function display_corpus($idcorpus) {
		$i = 0;
		$query = mysql_query("SELECT * FROM corpus WHERE idcorpus = ".$idcorpus);
		$data = mysql_fetch_assoc($query);
	
		echo '<h1 style="color: #FACE8D;">'.$data["title"].'</h1>';
		echo '<h4 class="yellow-text">'.$data["description"].'</h4>';
		$query = mysql_query("SELECT * FROM in_corpus WHERE corpus_idcorpus = ".$idcorpus);
		
		
		
		echo '<div class="row">';
			echo '<div class="span8">';
			echo '<div class="btn-toolbar" style="margin-bottom: 0;">';
        	echo '<div class="btn-group" data-toggle-name="is_private" data-toggle="buttons-radio">';
            echo '<button type="button" name="view_finder" value="images" class="btn btn-primary active btn-custom-gray" style="border-color: #13132E; border-width: 1px;" data-toggle="button">';
            echo '<font class="navy-text">Images</font>';
            echo '</button>';
            echo '<button id="map_button" type="button" name="view_finder" value="map" class="btn btn-custom-gray" style="border-color: #13132E; border-width: 1px;" data-toggle="button">';
            echo '<font class="navy-text">Map</font>';
            echo '</button>';
			echo '</div>';
			if (strcmp($_SESSION["email"],$data["created_by"]) == 0) {
					echo '<div class="btn-group">';
						echo '<button class="btn btn-primary btn-custom-gray dropdown-toggle" data-toggle="dropdown" style="border-color: #13132E; border-width: 1px;" ><font class="navy-text">Tools</font></button>';
						echo '<ul class="dropdown-menu">';
							echo '<li><a data-toggle="modal" href="#deleteCorpusModal">Delete Corpus</a></li>';
				if (strcmp($data["published"], "Published") != 0) {
							echo '<li><a data-toggle="modal" href="#publishCorpusModal">Publish Corpus</a></li>';
							echo '<li id="delete_group"><a id="delete_group" href="#">Delete Group</a></li>';
				}

						echo '</ul>';
					echo '</div>';
			}
		echo '</div>';
			echo '<div id="the_viewer" class="well" style="border-color: #13132E; background: ';
				echo 'rgba(192, 192, 192, 0.2); height: 475px; padding: 0px;">';
				
				$this->delete_from_corpus_bar();
				echo '<div id="view_finder_images" class="desc">';
					echo '<div style="padding: 10px;">';
					if (!isset($_POST["start_date"])) {
						$this->get_corpus_thumbnails($idcorpus);				
					}
					echo '</div>';
				echo '</div>';
		
			    echo '<div id="view_finder_map" class="desc" style="display: none;">';
					if (!isset($_POST["start_date"])) {
						$this->add_markers_corpus($idcorpus);
					}
					
				   
					
					echo '<div id="map-canvas" style="border-width:5px; height: 474px;"></div>';
			    echo '</div>';

				echo '<div id="view_finder_tag_list" class="desc" style="display: none;">';
					$this->get_tags();
				echo '</div>';	
					
			echo '</div>';
			echo '</div>';
			
			echo '<div class="span6">';
			
			$result = mysql_query("select published from corpus where idcorpus = ".$idcorpus.";");
			$data = mysql_fetch_assoc($result);
			
				echo '<form method="post" action="save_notes.php" style="margin-bottom: 0px; margin-top: 0px;" id="update_notes">';
			echo '<p style="color: #FACE8D; margin-top: 12px; margin-left: 30px; margin-bottom: 0px;">Notes:';
			if (strcmp($data["published"], "Unpublished") == 0) {
				echo '<button style="border-color: #13132E;" class="btn btn-mini btn-custom-gray pull-right">';
				echo '<font class="navy-text">Save Notes</font></button></p>';
				
				echo '<input name="idcorpus" style="display: none;" value="'.$idcorpus.'" />';
				
				echo '<textarea class="field" style="height:470px;width: 90%;margin-left: 30px;" name="notes">';
				$this->print_notes($idcorpus);
				echo '</textarea>';
			}
			else {
				echo '<div class="well" style="margin-top: 3px;">';
				echo '<p style="font-size: 14px; height: 425px;">';
				$this->print_notes($idcorpus);
				echo '</p>';
				echo '</div>';	
			}
			
			echo '</form>';
			echo '</div>';
		echo '</div>';
	
		
	}

	public function print_notes($idcorpus) {
		$query = "select * from corpus where idcorpus = ".$idcorpus.";";
		$result = mysql_query($query);
		$data = mysql_fetch_assoc($result);
		echo $data["notes"];
	}

	public function save_notes($idcorpus, $text) {
		$query = "update corpus set notes = '".$text."' where idcorpus = ".$idcorpus.";";
		echo $query;
		mysql_query($query);
		header("Location: corpus.php?idcorpus=".$idcorpus);
	}

	public function get_corpus_thumbnails($idcorpus) {
		
		$query = mysql_query("select * from in_corpus, coin, corpus where in_corpus.coin_idcoin = coin.idcoin and in_corpus.corpus_idcorpus = corpus.idcorpus and in_corpus.corpus_idcorpus = ".$idcorpus.";");
		$i = 0;
		//$query = mysql_query("SELECT * FROM coin");
		echo '<ul class="thumbnails">';
		while($data=mysql_fetch_assoc($query))
		{
			/*if ( ($i % 4) == 0) {
				echo '</tr><tr>';
				
				
			}*/
	  		$encoded = $data["img"];
			//<div id='.$data["idcoin"].'>
			echo '<li class="span2"><div class="thumbnail" style="overflow: hidden;" id="'.$data["idcoin"].'">';
	 		echo '<img style="display: block; height:75px; width:auto;  overflow: hidden;"';
			echo 'src="'.$data["file_path"].'"/>';
			echo '<div class="caption">';
			echo '<p><a class= "btn btn-primary btn-custom" href="http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$data["idcoin"].'">View</a></p>';
			echo '</div></div></li>';
			$i++;
			
		}
		echo '</ul>';
	
	}
	
	public function register_user($email, $password, $name, $college_affiliation, $status, $file_path) {
		echo "I'm in register_user!";
		$encrypted_pass = md5($password);
		$query = "INSERT INTO user (email, password, name, college_affiliation, status, file_path, administrator) VALUES ('".$email."', '".$encrypted_pass."', '".$name."', '".$college_affiliation."', '".$status."', '".$file_path."', 'false');";
		mysql_query($query);
		$iduser = mysql_insert_id();
		echo $query;
		$_SESSION["email"] = $email;
		$_SESSION["password"] = $password;
		$_SESSION["status"] = $status;
		header("Location: index.php");
	}
	
	public function edit_user($email, $password, $name, $college_affiliation, $file_path) {
		$encrypted_pass = md5($password);
		$query = "UPDATE user SET name = \"".$name."\", college_affiliation = \"".$college_affiliation."\"";
		if ($password != "blank") {
			$query .= ", password = \"".$encrypted_pass."\"";
		}
		
		if ($file_path != "blank") {
			$query .= ", file_path = ";
			
			$query .= "\"".$file_path."\"";
		}
		
		
		$query .= " WHERE email = \"".$email."\";";
		
		if ($_FILES["file"]["name"] == UPLOAD_ERR_OK) {
			echo 'file ok<br>';
		}
		else {
			echo 'file not ok<br>';
		}
		mysql_query ($query);
		echo $query;
		header ("Location: index.php");
	}

	public function edit_coin($idcoin, $date_start, $era_start, $date_end, $era_end, $mint_lat_long, $find_lat_long, $denomination, $minting_authority, $ob_legend, $reverse_legend, $bibliography, $era_category, $region_category) {
		echo 'SUPPPPP BETCHES';
		$start = $era_start.$date_start;
		$end = $era_end.$date_end;
		$query = "UPDATE coin SET date_start = ".$start.", date_end = ".$end;
			echo 'mint_lat_long='.$mint_lat_long;
			echo 'find_lat_long='.$find_lat_long;
			if (strcmp($mint_lat_long, "mint_lat, mint_long") != 0) {
				$mint = explode(",", $mint_lat_long);
				$mint_lat = $mint[0];
				$mint_long = $mint[1];
				$query .= ", mint_lat = ".$mint_lat.", mint_long = ".$mint_long;
			}
			if (strcmp($find_lat_long, "find_lat, find_long") != 0) {		
				$find = explode(",", $find_lat_long);
				$find_lat = $find[0];
				$find_long = $find[1];
				$query .= ", find_lat = ".$find_lat.", find_long = ".$find_long;
			}
		$query .= ", denomination = \"".$denomination."\"";
		$query .= ", minting_authority = \"".$minting_authority."\"";
		$query .= ", obverse_legend = \"".$ob_legend."\"";
		$query .= ", reverse_legend = \"".$reverse_legend."\"";
		$query .= ", bibliography = \"".$bibliography."\"";
		$query .= ", era_category = \"".$era_category."\"";
		$query .= ", region_category = \"".$region_category."\"";
		$query .= " WHERE idcoin = ".$idcoin.";";
		
		print("ob_legend=".$ob_legend."\n");
		
		echo $query;
		mysql_query($query);
		
		header("Location: coin.php?idcoin=".$idcoin);
	}
	
	public function insertCoin($date_start, $era_start, $date_end, $era_end, $mint_lat_long, $find_lat_long, $denomination, $minting_authority, $ob_legend, $reverse_legend, $bibliography, $inserted_by, $file, $era_category, $region_category) {
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
		$query = "INSERT INTO corpus (created_by, title, description, published) values ('".$created_by."', '".$title."', '".$description."', 'Unpublished');";
		mysql_query($query);
				
		header("Location: view_collection.php");
	}
	
	public function add_to_corpus($corpustitle, $coinsArray) {
		foreach ($coinsArray as $coin) {
			$query = "select idcorpus from corpus where title = '".$corpustitle."';";
			
			$result = mysql_query($query);
			$idcorpus = mysql_fetch_assoc($result)["idcorpus"];
			$query = "INSERT INTO in_corpus (corpus_idcorpus, coin_idcoin) VALUES(".$idcorpus.", ".$coin.");";
			echo 'insert query = '.$query;
			mysql_query($query);
		}
		header("Location: corpus.php?idcorpus=".$idcorpus);
	}
	
	public function tag_coin_set($tag_title, $coinsArray) {
		$query = "SELECT idtag FROM tag WHERE title = \"$tag_title\";";
		echo 'tag id search query = '.$query;
		$result = mysql_query($query);
		if (mysql_num_rows($result) == 0) {
			//insert tag
			mysql_query("insert into tag (title) values ('$tag_title');");
			$idtag = mysql_insert_id();
		}
		else {
			$data=mysql_fetch_assoc($result);
			$idtag = $data['idtag'];
		}
		
			
		foreach ($coinsArray as $coin) {
			$query = "INSERT INTO coin_has_tag (coin_idcoin, tag_idtag) VALUES (".$coin.", ".$idtag.");";
			echo 'insert query = '.$query;
			mysql_query($query);
		}
		header("Location: view_collection.php");
	}
	
	
	public function delete_coin_set($idcorpus, $coins) {
		echo "idcorpus=".$idcorpus;
		foreach ($coins as $coin) {
			$query = "DELETE from in_corpus where coin_idcoin = ".$coin." and corpus_idcorpus = ".$idcorpus.";";
			echo $query."\n";
			mysql_query($query);
		}
		header("Location: corpus.php?idcorpus=".$idcorpus);
	}
	
	public function delete_corpus($idcorpus) {
		$query = "DELETE from in_corpus WHERE corpus_idcorpus = ".$idcorpus.";";
		echo $query."\n";
		mysql_query($query);
		$query = "DELETE from corpus WHERE idcorpus = ".$idcorpus.";";
		echo $query."\n";
		mysql_query($query);
		header("Location: index.php");
	}
	
	public function publish_corpus($idcorpus) {
		$query = "UPDATE corpus set published = 'Published' where idcorpus = ".$idcorpus.";";
		echo $query;
		
		mysql_query($query);
		header("Location: index.php");
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
	
	public function view_all_divs(){
		$this->search_filter_bar();
		$this->tag_selector_bar();
		$this->add_to_corpus_bar();
	
		echo '<div id="view_finder_images" class="desc">';
			echo '<div style="padding: 20px;">';
			if (isset($_GET["searchby"])) {
				echo '<p style="color: #FACE8D;">Coins with search tag: '.$_GET["searchby"].'</p>';
				$this->get_tagged_coins($_GET["searchby"]);
			}
			else {
				if (!isset($_POST["start_date"])) {
					$this->get_thumbnails();					
				}
				else {
					if (isset($_POST["start_date"])) {$_SESSION["start_date"] = $_POST["start_date"];}
					if (isset($_POST["start_era"])) {$_SESSION["start_era"] = $_POST["start_era"];}
					if (isset($_POST["end_date"])) {$_SESSION["end_date"] = $_POST["end_date"];}
					if (isset($_POST["end_era"])) {$_SESSION["end_era"] = $_POST["end_era"];}
					if (isset($_POST["mint_lat_long"])) {$_SESSION["mint_lat_long"] = $_POST["mint_lat_long"];}
					if (isset($_POST["find_lat_long"])) {$_SESSION["find_lat_long"] = $_POST["find_lat_long"];}
				   	$this->view_all_filtered($_SESSION["start_date"], $_SESSION["start_era"], $_SESSION["end_date"], $_SESSION["end_era"], $_SESSION["mint_lat_long"], $_SESSION["find_lat_long"]);
							unset($_SESSION["start_date"]);
							unset($_SESSION["start_era"]);
							unset($_SESSION["end_date"]);
							unset($_SESSION["end_era"]);
							unset($_SESSION["mint_lat_long"]);
							unset($_SESSION["find_lat_long"]);
							session_write_close();
				}
			}
		echo '</div></div>';
		
	    echo '<div id="view_finder_map" class="desc" style="display: none;">';
			if (!isset($_POST["start_date"])) {
				$this->add_markers();
			}
		   
			else {
				if (isset($_POST["start_date"])) {$_SESSION["start_date"] = $_POST["start_date"];}
				if (isset($_POST["start_era"])) {$_SESSION["start_era"] = $_POST["start_era"];}
				if (isset($_POST["end_date"])) {$_SESSION["end_date"] = $_POST["end_date"];}
				if (isset($_POST["end_era"])) {$_SESSION["end_era"] = $_POST["end_era"];}
				if (isset($_POST["mint_lat_long"])) {$_SESSION["mint_lat_long"] = $_POST["mint_lat_long"];}
				if (isset($_POST["find_lat_long"])) {$_SESSION["find_lat_long"] = $_POST["find_lat_long"];}
			   	$this->add_markers_filtered($_SESSION["start_date"], $_SESSION["start_era"], $_SESSION["end_date"], $_SESSION["end_era"], $_SESSION["mint_lat_long"], $_SESSION["find_lat_long"]);
						unset($_SESSION["start_date"]);
						unset($_SESSION["start_era"]);
						unset($_SESSION["end_date"]);
						unset($_SESSION["end_era"]);
						unset($_SESSION["mint_lat_long"]);
						unset($_SESSION["find_lat_long"]);
						session_write_close();
			}
			echo '<div id="map-canvas" style="border-width:10px;"></div>';
	    echo '</div>';
		
		echo '<div id="view_finder_timeline" class="desc" style="display: none;">';
				echo '<div id="my-timeline" style="height: 450px; width: 90%;border: 1px solid #aaa"><script>';
	            echo 'function onLoad(){';
	                echo 'var eventSource = new Timeline.DefaultEventSource();';
					
	                echo 'var bandInfos = [Timeline.createBandInfo({';
	                    echo 'eventSource: eventSource,';
	                    echo 'date: "0",';
	                    echo 'width: "100%",';
	                    echo 'intervalUnit: Timeline.DateTime.DECADE,';
	                    echo 'intervalPixels: 100';
	               echo ' })];';
	                echo 'tl = Timeline.create(document.getElementById("my-timeline"), bandInfos);';
	                echo 'tl.loadJSON("load_coins.php", function(json, url){';
	                    echo 'eventSource.loadJSON(json, url);';
						echo 'tl.finishedEventLoading();';
	                echo '});';
					
	            echo '}';
	        echo '</script>';
	            echo '</div>';
	            echo '<noscript>';
	            echo 'This page uses Javascript to show you a Timeline. Please enable Javascript in your browser to see the full page. Thank you.';
	            echo '</noscript>';
			echo '</div>';
		
	    echo '<div id="view_finder_tag_cloud" class="desc" style="display: none;">';
			echo '<div id="myCanvasContainer">';
      		echo '<canvas width="1000%" height="500" id="myCanvas">';
        	echo '<p>Your browser does not support the tag cloud.  Please try updating your browser, it is severely out of date!</p>';
      		echo '</canvas></div><div id="tags"><ul>';
			$this->tag_cloud();
			echo '</ul></div>';
	    echo '</div>';
		
		echo '<div id="view_finder_tag_list" class="desc" style="display: none;">';
			$this->get_tags();
		echo '</div>';
		
		
		
	}

	// get coins with tag
	public function get_tagged_coins($tagname)
	{
		$query = mysql_query("SELECT * FROM coin, coin_has_tag, tag WHERE idcoin = coin_idcoin AND idtag = tag_idtag AND title = \"$tagname\";");
		echo '<ul class="thumbnails">';
		while($data=mysql_fetch_assoc($query))
		{
			/*if ( ($i % 4) == 0) {
				echo '</tr><tr>';
				
				
			}*/
	  		$encoded = $data["img"];
			//<div id='.$data["idcoin"].'>
			echo '<li class="span3"><div class="thumbnail" style="overflow: hidden;" id="'.$data["idcoin"].'">';
	 		echo '<img style="display: block; height:100px; width:auto;  overflow: hidden;"';
			echo 'src="'.$data["file_path"].'"/>';
			echo '<div class="caption">';
			echo '<p><a class= "btn btn-primary btn-custom" href="http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$data["idcoin"].'">View</a></p>';
			echo '</div></div></li>';
			$i++;
			
		}
		echo '</ul>';
	}
	
	
	public function get_thumbnails() {

		$i = 0;
		$query = mysql_query("SELECT * FROM coin");
		echo '<ul class="thumbnails">';
		while($data=mysql_fetch_assoc($query))
		{
			/*if ( ($i % 4) == 0) {
				echo '</tr><tr>';
				
				
			}*/
	  		$encoded = $data["img"];
			//<div id='.$data["idcoin"].'>
			echo '<li class="span3"><div class="thumbnail" style="overflow: hidden;" id="'.$data["idcoin"].'">';
	 		echo '<img style="display: block; height:100px; width:auto;  overflow: hidden;"';
			echo 'src="'.$data["file_path"].'"/>';
			echo '<div class="caption">';
			echo '<p><a class= "btn btn-primary btn-custom" href="http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$data["idcoin"].'">View</a></p>';
			echo '</div></div></li>';
			$i++;
			
		}
		echo '</ul>';
	}
	
	public function tag_cloud() {
		// select tag.title, count(*) from tag, coin_has_tag where coin_has_tag.tag_idtag = tag.idtag group by title;
		$result = mysql_query("SELECT DISTINCT title as Name FROM tag");
		while ($row = mysql_fetch_assoc($result)) {
    	   foreach ($row as $col) {
       	      print("<li><a href=\"http://www.cs.dartmouth.edu/~salsbury/art2artifact/view_all.php?searchby=$col\">$col</a></li>");
    	   }
    	   
		} 
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
		
		$i = 0;
		echo '<ul class="thumbnails">';
		while($data=mysql_fetch_assoc($result))
		{
			/*if ( ($i % 4) == 0) {
				echo '</tr><tr>';
				
				
			}*/
	  		$encoded = $data["img"];
			//<div id='.$data["idcoin"].'>
			echo '<li class="span3"><div class="thumbnail" style="background: rgba(255,255,255,1); overflow: hidden;">';
	 		echo '<img style="display: block; height:150px; width:auto;  overflow: hidden;"';
			echo 'src="'.$data["file_path"].'"/>';
			echo '<div class="caption">';
			echo '<p><a class= "btn btn-primary btn-custom" href="http://www.cs.dartmouth.edu/~salsbury/art2artifact/coin.php?idcoin='.$data["idcoin"].'">View</a></p>';
			echo '</div></div></li>';
			$i++;
			
		}
		echo '</ul>';
		
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
	
	
	public function search_filter_bar() {
		echo '<div class="navbar" style="margin-bottom: 0px; display: none;" id="filters"><div class="navbar-inner"><form class="navbar-form pull-left" style=" max-width: 93.8%; width: 100%;" name="search_filters" method="post" action="view_collection
		.php">';
	   	echo '<font color="#FACE8D">From: </font><input type="text" name="start_date" value="Start" style="width:75px;"/>';
	   	echo '<select name="start_era" style="width:60px;"><option value="">AD</option><option value="-">BCE</option></select>';
	   	echo '<font color="#FACE8D">To: </font> <input type="text" name="end_date" value="End" style="width:75px;"/><select name="end_era" style="width:60px;">';
	   	echo '<option value="">AD</option><option value="-">BCE</option></select>|'; 
   	   	
		$this->get_locations(0);
	   	
		echo '<button type="submit" class="btn">Submit</button></form></div></div>';
	}
	
	public function tag_selector_bar() {
		$tags = mysql_query("SELECT title FROM tag;");
		
		$autocompletes = '["'.mysql_fetch_assoc($tags)["title"].'"';
		while ($row = mysql_fetch_assoc($tags)) {
			$autocompletes .= ', "'.$row["title"].'"';
		}
		
		
		$autocompletes = $autocompletes.']';
		
		echo '<div id="tag_name" style="display:none; height: 50px; margin-left: 30px; margin-bottom: 0px; padding-bottom: 0px;" class="row">';
		echo '<form class="navbar-search pull-left">';
  		echo '<input autocomplete="off" id="tag_title" name="search_val" type="text" data-provide="typeahead" data-source=\''.$autocompletes.'\'>';
		echo '</form>';
		echo '<button class="btn btn-small" style="margin-top: 7px; margin-left: 10px;" id="tag_coins_button">Tag Selected Coins</button>';
		echo '</div>';
	}
	
	public function add_to_corpus_bar() {
		$query = 'select title from corpus, user where user.email = corpus.created_by and user.email = "'.$_SESSION["email"].'";';
		$result = mysql_query($query);
		echo '<div id="corpus_titles" style="display: none; height: 50px; margin-left: 23px; margin-bottom: 0px; margin-top: 10px;padding-bottom:0px; class="row">';
		echo '<select id="selected_corpus" name="selected_corpous_name">';
		while ($row = mysql_fetch_assoc($result)) {
			echo '<option>'.$row["title"].'</option>';
		}
		
		echo '</select>';
		echo '<button class="btn btn-small" style="margin-left: 10px; margin-top: -7px;" id="add_coins_corpus">Add Selected Coins to Corpus</button>';
		echo '</div>';
	}
	
	public function delete_from_corpus_bar() {
		echo '<div id="delete_from_corpus_bar" style="display: none; margin-left: 10px;" class="row">';
		echo '<button class="btn btn-small" style="margin-top: 7px;" id="delete_coins_button">Delete Selected Coins From Corpus</button>';
		echo '</div>';
	}
	
	
	// get all available search tags
	public function get_tags() 
	{
		$result = mysql_query("SELECT DISTINCT title as Name FROM tag");
		echo '<div class="well" style="width: 100%;">';
		print("<table class=\"table table-hover\">\n<thead><tr>");
		for($i=0; $i < mysql_num_fields($result); $i++) {
	    	print("<th>" . mysql_field_name($result, $i) . "</th>");
		}
		
		print("</tr></thead>\n");
	
		while ($row = mysql_fetch_assoc($result)) {
    	      print("\t<tr>\n");
    	      foreach ($row as $col) {
       	          print("\t\t<td><a style=\"color: navy;\" href=\"http://www.cs.dartmouth.edu/~salsbury/art2artifact/view_collection.php?searchby=$col\">$col</a></td>\n");
    	      }
    	      print("\t</tr>\n");
		}
		print("</table>\n");  
		echo '</div>';
	}
	

	
	public function delete_coin($idcoin)
	{
		$query = mysql_query("DELETE FROM coin_has_tag WHERE coin_idcoin = $idcoin;");
		$query = mysql_query("DELETE FROM in_corpus WHERE coin_idcoin = $idcoin;");
		$query = mysql_query("DELETE FROM coin WHERE idcoin = $idcoin;");
		
		header("Location: view_all.php");
	}
	
	public function add_location($name, $lat, $long) {
		$query = mysql_query("INSERT INTO location (location_name, latitude, longitude) VALUES (\"$name\", $lat, $long);");
		header("Location: add_coin.php");
	}
	
	public function get_locations($b) {
		$bool = $b;
		if ($bool == 1) {
			echo '<div class="control-group" style="margin-bottom: 0px;"><label class="control-label" for="mint_lat_long">Mint Location</label><div class="controls">';
			echo '<select name="mint_lat_long"><option value="mint_lat, mint_long">Mint Location</option>';
			
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
			echo '</div></div>';
			echo '<div class="control-group" style="margin-bottom: 0px;"><label class="control-label" for "find_lat_long">Find Location</label><div class="controls">';
			echo '<select name="find_lat_long"><option value="find_lat, find_long">Find Location</option>';
			echo '</div>';
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
			echo '</div>';
			echo '<p style="margin-left: 50px; margin-bottom: 0px;">*(If your location does not appear on the list, you must add it <a href="#addLocationModal" data-toggle="modal">here</a>)<p>';
			echo '</div>';		
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
	
	public function coin_image($idcoin) {
		global $currentidcoin;
		$currentidcoin = $idcoin;
		$query = mysql_query("SELECT * FROM coin WHERE idcoin = $idcoin");
		
		$data=mysql_fetch_assoc($query);
		
		
		//place image as the background of a well
		echo '<div style="border-color: #13132E; border-width: 2px; border-radius: 10px; background-size: contain;';
			  echo 'background: url('.$data["file_path"].') no-repeat center center; ';
			  echo 'margin-left: auto; margin-right: auto; height: 100%;">';
		
		echo '</div>';
		
		
		
	}

	public function coin_info($idcoin) {
		$query = mysql_query("SELECT * FROM coin WHERE idcoin = $idcoin");
		
		$data=mysql_fetch_assoc($query);
		
		
		$start_no_dash = trim($data["date_start"], "-");
		$end_no_dash = trim($data["date_end"], "-");
		
		echo '<div class="well" style="overflow-y: scroll; font-size: 10px; padding-top: 3px; background-color: rgba(255,255,255,0.8); height: 100%;" ><h3 style="font-size: 14px; margin-bottom: 0px;">Coin Information</h3>';
		
		echo '<p style="margin-bottom: 0px;"><strong>Date:</strong> '.$start_no_dash;
		if ($data["date_start"] < 0) { echo 'BCE '; }
		else {echo 'AD ';}
		echo  '- '.$end_no_dash;
		if($data["date_end"] < 0) { echo 'BCE '; }
		else {echo 'AD ';}
		echo '</p>';
		echo '<p style="margin-bottom: 0px;"><strong>Region:</strong> '.$data["region_category"].'</p>';
		echo '<p style="margin-bottom: 0px;"><strong>Era:</strong> '.$data["era_category"].'</p>';
		echo '<p style="margin-bottom: 0px;"><strong>Denomination:</strong> '.$data["denomination"].'</p>';
		echo '<p style="margin-bottom: 0px;"><strong>Mint Authority:</strong> '.$data["minting_authority"].'</p>';
		echo '<p style="margin-bottom: 0px;"><strong>Obverse Legend:</strong> '.$data["obverse_legend"].'</p>';
		echo '<p style="margin-bottom: 0px;"><strong>Reverse Legend:</strong> '.$data["reverse_legend"].'</p>';
		echo '<p style="margin-bottom: 0px;"><strong>Bibliographic Information:</strong> '.$data["bibliography"].'</p>';
		echo '<p style="margin-bottom: 0px;"><strong>Inserted by:</strong> '.$data["inserted_by"].'</p>';
		echo '<p style="margin-bottom: 0px;"><strong>Date Inserted:</strong> '.$data["time_stamp"].'</p>';
		echo '<p style="margin-bottom: 0px;"><strong>Associated Tags:</strong> ';
		
		$result = mysql_query("SELECT title FROM tag, coin_has_tag WHERE tag_idtag = idtag AND coin_idcoin = $idcoin");
		$num_rows = mysql_num_rows($result);
		$i = 1;
		while ($row = mysql_fetch_assoc($result)) {
			foreach ($row as $col) {
				print("<a href=\"http://www.cs.dartmouth.edu/~salsbury/art2artifact/view_collection.php?searchby=".$col."\">");
				print($col."</a>");
			}
			if ($i != $num_rows) {
				print(", ");
			}
			$i++;
		}
		print("</p>");
		echo '<a class="btn btn-primary" data-toggle="modal" href="#addTagModal">Add Tag</a></div>';
		
	}
	
	public function search_in_header() {
		$tags = mysql_query("SELECT title FROM tag;");
		
		//$autocompletes = '["'.mysql_fetch_assoc($tags)["title"].'"';
		while ($row = mysql_fetch_assoc($tags)) {
			$autocompletes .= ', "'.$row["title"].'"';
		}
		
		
		$autocompletes = $autocompletes.']';
		//echo '<p>'.$autocompletes.'</p>';
		
		echo '<form class="navbar-search pull-right" name="search_bar" method="post" action="search_php.php">';
        echo '<input class="search-query" autocomplete="off" id="coin_search" name="search_val" type="text" data-provide="typeahead" data-source=\''.$autocompletes.'\'>';
		echo '</form>';
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
	
	public function tag_bar() {
		$tags = mysql_query("SELECT title FROM tag;");
		
		//$autocompletes = '["'.mysql_fetch_assoc($tags)["title"].'"';
		while ($row = mysql_fetch_assoc($tags)) {
			$autocompletes .= ', "'.$row["title"].'"';
		}
		
		
		$autocompletes = $autocompletes.']';
		return $autocompletes;
	}
	
	public function search($tagname) {
		$result_tags = mysql_query("SELECT title FROM tag WHERE title = \"".$tagname."\";");
		$result_location = mysql_query("SELECT location_name FROM location WHERE location_name = \"".$tagname."\";");
		
			header("Location: view_collection.php?searchby=".$tagname);
		
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

	public function add_markers_corpus($idcorpus) {
		$query = "SELECT mint_lat, mint_long, find_lat, find_long, idcoin FROM coin, in_corpus WHERE coin_idcoin = idcoin and corpus_idcorpus = ".$idcorpus.";";
		
		$result = mysql_query($query);
		//echo '<p>end_era='.$end_era.'</p>';
		//echo '<p>'.$query.'</p>';
		echo '<script type="text/javascript">';
      	echo 'function initialize() {';
        echo 'var mapOptions = {';
        echo 'center: new google.maps.LatLng(57.231503,-10.195313),';
        echo 'zoom: 4,';
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
        echo 'center: new google.maps.LatLng(52.749594,-15.380859),';
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
        echo 'center: new google.maps.LatLng(52.749594,-15.380859),';
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