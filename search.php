<?php session_start(); 
if (!isset($_SESSION['email'])) {
	header("Location: login.php?test=fail");
}?>
 <!DOCTYPE html>
<html>
    <head>
        <title>Art2Artifact - Search</title>
        <link rel="stylesheet" href="Content/bootstrap.css"/>
        <link rel="stylesheet" href="Content/bootstrap-responsive.css"/>
        <link rel="stylesheet" href="Content/style.css" />
        <script type="text/javascript" src="Content/jquery.js">
        </script>
        <script type="text/javascript" src="Content/bootstrap.js">
        </script>
    </head>
    <body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">
        <?php include('Includes/header.php'); ?>
        <div class="well" style="width: 80%; height: 40%; margin-left: 10%; margin-top: 50px; background-color: rgba(250, 250, 250, 0.75); border-color: black;">
        <center>
            <h1>Search!</h1>
            <?php
        			   mb_internal_encoding('UTF-8');
        		       mb_http_output('UTF-8');
        				
        		       include 'phpfunctions.php';
        		       $db = new SunapeeDB();
        		       $db->connect();
        		
        			   $db->search_bar();
        		   
        		       $db->disconnect();
                    ?>
            <p>
                Search by tag name, mint location, or find location.
            </p>
        </center>
        </div>
		<?php include('Includes/footer.php'); ?>
    </body>
</html>