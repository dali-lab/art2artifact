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
	
	echo 'UMM WUT';
	$name = $_FILES['file']['name'];
	$size = $_FILES['file']['size'];
	$tmp = $_FILES['file']['tmp_name'];
	$ext = getExtension($name);
	echo 'asdf';
	if($size > 0)
	{
		if(in_array($ext,$valid_formats))
		{
		 
			if($size<(1024*1024))
			{
				include('s3_config_coins.php');
				//Rename image name. 
				$actual_image_name = time().".".$ext;
				if($s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ) )
				{
					$msg = "S3 Upload Successful.";	
					$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;
					echo "<img src='$s3file' style='max-width:400px'/><br/>";
					echo '<b>S3 File URL:</b>'.$s3file;
					
					// insert coin into db
					echo 'ASDF';
					//$db->insertCoin($_POST["date_start"], $_POST["era_start"], $_POST["date_end"], $_POST["era_end"], $_POST["mint_lat_long"], $_POST["find_lat_long"], $_POST["denomination"], $_POST["mint_authority"], $_POST["obverse_legend"], $_POST["reverse_legend"], $_POST["bibliography"], $_SESSION["email"] , $s3file, $_POST["era_category"], $_POST["region_category"]);
					
					
				}
				else {
					$msg = "S3 Upload Fail.";
					header("Location: add_coin.php?error=".$msg);
					echo $msg;
					
				}
			}
			else {
				$msg = "Image size Max 1 MB";
				header("Location: add_coin.php?error=".$msg);
				echo $msg;
			}
		}
		else {
			$msg = "Invalid file, please upload image file.";
			header("Location: add_coin.php?error=".$msg);
			echo $msg;
		}
	}
	else {
		$msg = "Please select image file.";
			header("Location: add_coin.php?error=".$msg);
		echo $msg;
	}
	
	
	
	
	// disconnect from db
	$db->disconnect();
	      
	
}
}

?>
