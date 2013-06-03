<?php
session_start(); 
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if($_POST["uploaded"]){
	// Display images stored in the database
	include "phpfunctions.php";
	$db = new SunapeeDB();
	$db->connect();
	$db->get_locations(0);
	
	
	
	 
	    
	    echo "Upload: " . uniqid() . "<br>";
	    echo "Type: " . $_FILES["file"]["type"] . "<br>";
	    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
	    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
	
	    if (file_exists("profile_pictures/" . $_FILES["file"]["name"]))
	      {
	      echo $_FILES["file"]["name"] . " already exists. ";
	      }
		else
	    {
		  $uniqname = uniqid().".jpeg";
	      move_uploaded_file($_FILES["file"]["tmp_name"], "profile_pictures/".$uniqname);
		  $file_path = "profile_pictures/".$uniqname;
	      echo "Stored in: " . "profile_pictures/" . $uniqname;
		  // upload file name
			$uploadFilename = "profile_pictures/" . $uniqname;	
			// insert drawing in db
			$db->register_user($_POST["email"], $_POST["password"], $_POST["name"], $_POST["affiliation"], $_POST["status"], $file_path);
			// close file
			// disconnect from db
			$db->disconnect();
	      }
	    
	  
	 
}

?>