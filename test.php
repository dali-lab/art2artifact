<!DOCTYPE html>
<html>
  <head>
    <title>TagCanvas example</title>
    <!--[if lt IE 9]><script type="text/javascript" src="excanvas.js"></script><![endif]-->
    <script src="Content/tagcanvas.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      window.onload = function() {
        try {
          TagCanvas.Start('myCanvas','tags',{
            textColour: '#ff0000',
            outlineColour: '#ff00ff',
            reverse: true,
            depth: 0.8,
            maxSpeed: 0.05
          });
        } catch(e) {
          // something went wrong, hide the canvas container
          document.getElementById('myCanvasContainer').style.display = 'none';
        }
      };
    </script>
  </head>
  <body>
    <h1>TagCanvas example page</h1>
    <div id="myCanvasContainer">
      <canvas width="1000" height="1000" id="myCanvas">
        <p>Your browser does not support the tag cloud.  Please try updating your browser, it is severely out of date!</p>
      </canvas>
    </div>
    <div id="tags">
      <ul>
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
	   
       $db->tag_cloud();
   
       $db->disconnect();
?>


      </ul>
    </div>
  </body>
</html>