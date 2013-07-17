<?php
session_start(); 
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if($_POST["uploaded"]){
	// Display images stored in the database
	include "phpfunctions.php";
	$db = new SunapeeDB();
	$db->connect();
	
	// if uploading new file
	if (file_exists("profile_pictures/" . $_FILES["file"]["name"]))
	{
		echo $_FILES["file"]["name"] . " already exists. not uploading again<br>";
		$file_path="blank";
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
			
	}
	
	echo 'post password = \''.$_POST["password"].'\'<br>';
	echo 'post password length = \''.strlen($_POST["password"]).'\'<br>';

	
	// if the user is changing their password    
	if (strlen($_POST["password"]) > 0) {
		$password = $_POST["password"];
	}
	else {
		$password = "blank";
	}
	
	// submit to database
	$db->edit_user($_SESSION["email"], $password, $_POST["name"], $_POST["affiliation"], $file_path);

	// disconnect from db
	$db->disconnect();
	 
}

?>