<?php
	session_start(); 
	if(isset($_SESSION['email'])) {
  		unset($_SESSION['email']);
		unset($_SESSION['password']);
		unset($_SESSION['currentcoin']);	
	}

?>
<!DOCTYPE html>
<html>
<head>
<title>Art2Artifact - Login</title>

<link rel="stylesheet" href="Content/style.css"/> 
<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/validation.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script> 
<script type="text/javascript" src="Content/validation.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

	// Validate
	// http://bassistance.de/jquery-plugins/jquery-plugin-validation/
	// http://docs.jquery.com/Plugins/Validation/
	// http://docs.jquery.com/Plugins/Validation/validate#toptions

		$('#login-form').validate({
	    rules: {
	      password: {
	        minlength: 2,
	        required: true
	      },
	      email: {
	        required: true,
	        email: true
	      }
	    },
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); // end document.ready
</script>
</head>

<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">
	<div class="hero-unit" style="width: 100%; height: 100%; padding: 20px; background-color: rgba(250, 250, 250, 0.75); border-color: black;">
            <center>
            	<br>
                <h1>Login</h1>
                <p>
                    To enter the Art2Artifact portal.<br>
		<a href="register.php">Register for access.</a>
                </p>
			</center>
	<div class="modal" style="position: relative; left: auto; right: auto; margin: 0 auto 20px; z-index: 1; max-width: 100%; width: 350px;">
		<div class="modal-body">
			<form action="index.php" method="post" id="login-form">
			<div class="control-group">
				<label class="control-label" for="email">Email Address:</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="email" id="email">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="name">Password:</label>
				<div class="controls">
					<input type="password" class="input-xlarge" name="password" id="name">
				</div>
			</div>
			<?php
  				mb_internal_encoding('UTF-8');
   				mb_http_output('UTF-8');

				if ($_GET["test"] == "fail") {
					echo "<font color=\"red\">Incorrect User/Password combo!</font>";
				}
			?>
			<center>
			<input type="submit" value="Go!" class="btn btn-primary btn-large"></a>
			</center>
			</form>
		</div>
	</div>
	</div>
	<?php include("Includes/footer.php"); ?>
</body>
</html>