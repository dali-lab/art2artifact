<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Art2Artifact - Add Coin</title>
        <link rel="stylesheet" href="Content/bootstrap.css"/>
        <link rel="stylesheet" href="Content/bootstrap-responsive.css"/>
        <link rel="stylesheet" href="Content/style.css" />
        <link rel="stylesheet" href="Content/validation.css"/>
        <script type="text/javascript" src="Content/jquery.js">
        </script>
        <script type="text/javascript" src="Content/bootstrap.js">
        </script>
        <script type="text/javascript" src="Content/validation.js">
        </script>
<style type="text/css" media="all">@import "Content/master.css";</style>  <style type="text/css" media="all">@import "Content/master.css";</style>

<link rel="stylesheet" href="Content/bootstrap_navbar.css"/> 
    </head>
    <body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">
        	
        	<?php include("Includes/header.php"); ?>
	<div style="width: 100%; height: 100%; padding: 20px; background-color: rgba(150, 27, 25, 0.75); border-color: black;">
     			
		    <center>
                <h1 style="color: #FACE8D;">Edit Coin Info:</h1>
			</center>	
			<div class="modal" style="position: relative; top: auto; left: auto; right: auto; margin: 0 auto 20px; z-index: 1; max-width: 100%;">
                <form action="edit_coin_php.php" method="post" ENCTYPE="multipart/form-data" class="form-horizontal" id="edit-coin" style="margin-top: 10px; margin-left: 10px; margin-bottom: 20px;">
					
					
					<?php
					   mb_internal_encoding('UTF-8');
				       mb_http_output('UTF-8');
						
				       include 'phpfunctions.php';
				       $db = new SunapeeDB();
				       $db->connect();
					   
						if (!isset($_SESSION['email'])) {
					   		$_SESSION['email'] = $_POST["email"];
					   		$_SESSION['password'] = $_POST["password"];
					   	}
					   
						$_SESSION["idcoin"] = $_GET["coinid"];
					   
				       $db->edit_coin_info($_GET["coinid"]);
				   
				       $db->disconnect();
					?>
				</form>
			</div>
        </div>
        
        <?php include("Includes/footer.php"); ?>
    </body>
</html>