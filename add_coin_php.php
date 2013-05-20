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
	
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	
	if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts))
	{
	  if ($_FILES["file"]["error"] > 0){echo "Return Code: " . $_FILES["file"]["error"] . "<br>";}
	  else
	    {
	    echo "Upload: " . uniqid() . "<br>";
	    echo "Type: " . $_FILES["file"]["type"] . "<br>";
	    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
	    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
	
	    if (file_exists("images/" . $_FILES["file"]["name"]))
	      {
	      echo $_FILES["file"]["name"] . " already exists. ";
	      }
		else
	    {
		  $uniqname = uniqid().".jpeg";
	      move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $uniqname);
	      echo "Stored in: " . "images/" . $uniqname;
		  // upload file name
			$uploadFilename = "images/" . $uniqname;	
			// insert drawing in db
			$db->insertCoin($_POST["date_start"], $_POST["era_start"], $_POST["date_end"], $_POST["era_end"], $_POST["mint_lat_long"], $_POST["find_lat_long"], $_POST["denomination"], $_POST["mint_authority"], $_POST["obverse_legend"], $_POST["reverse_legend"], $_POST["bibliography"], "diana.salsbury@gmail.com" , $uploadFilename, $_POST["era_category"], $_POST["region_category"]);
			// close file
			// disconnect from db
			$db->disconnect();
	      }
	    }
	  }
	else
	  {
	  echo "Invalid file";
	  echo "Type is: ".$_FILES["file"]["type"];
	  echo "Size is: ".$_FILES["file"]["size"];
	  }
	
}

?>
