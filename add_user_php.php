<?php
session_start(); 
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if($_POST["uploaded"]){
	// Display images stored in the database
	include "phpfunctions.php";
	$db = new SunapeeDB();
	$db->connect();
	
	// upload photo to amazon s3 bucket
	include('image_check.php');
	$msg='';
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
	
	$name = $_FILES['file']['name'];
	$size = $_FILES['file']['size'];
	$tmp = $_FILES['file']['tmp_name'];
	$ext = getExtension($name);
	
	if(strlen($name) > 0)
	{
	
	if(in_array($ext,$valid_formats))
	{
	 
	if($size<(1024*1024))
	{
	include('s3_config_profilepics.php');
	//Rename image name. 
	$actual_image_name = time().".".$ext;
	if($s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ) )
	{
	$msg = "S3 Upload Successful.";	
	$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;
	echo "<img src='$s3file' style='max-width:400px'/><br/>";
	echo '<b>S3 File URL:</b>'.$s3file;

	$db->register_user($_POST["email"], $_POST["password"], $_POST["name"], $_POST["affiliation"], "Guest", $s3file);
	
	}
	
	else
	$msg = "S3 Upload Fail.";
	
	
	}
	else
	$msg = "Image size Max 1 MB";
	
	}
	else
	$msg = "Invalid file, please upload image file.";
	
	}
	else
	$msg = "Please select image file.";
	
	}
	
	// disconnect from db
	$db->disconnect();

	    
	  
	 
}

?>