<!DOCTYPE html>
<html>
<head>
<title>Art2Artifact - Add Coin</title>

<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<link rel="stylesheet" href="Content/validation.css"/> 
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>
<script type="text/javascript" src="Content/validation.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

	// Validate
	// http://bassistance.de/jquery-plugins/jquery-plugin-validation/
	// http://docs.jquery.com/Plugins/Validation/
	// http://docs.jquery.com/Plugins/Validation/validate#toptions

		$('#add-user').validate({
	    rules: {
	      name: {
			required: true,
			maxlength: 45
	      },
		  email: {
		  	required: true,
			maxlength: 45,
			email: true
		  },
		  password: {
		  	required: true,
			maxlength: 45
		  },
		  password2: {
		  	required: true,
			maxlength: 45,
			equalTo: "#password_input_1"
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

	<?php include('Includes/header.php'); ?>

<div class="well" style="width: 85%; margin-left: 70px; margin-top: 50px; background-color: rgba(250, 250, 250, 0.75); border-color: black;">

	
<form action="add_user_php.php" method="post" ENCTYPE="multipart/form-data" class="form-horizontal" id="add-user">
	Photo:<input style="margin-left: 150px;" type="file" name="file" id="file"><br><br>
	<input type="hidden" name="uploaded" value="1">
	Status:<select name="status" style="width: 220px; margin-left: 109px;">
		<option value="Student">Student</option>
		<option value="Professor">Professor</option>
		<option value="Other">Other</option>
	</select><br>
	Name: <input style="margin-left: 107px;" type="text" name="name"><br>
	Email: <input style="margin-left: 110px;" type="text" name="email"><br>
	Password: <input style="margin-left: 82px;" type="password" name="password" id="password_input_1"><br>
	Input Password Again: <input style="margin-left: 6px;" type="password" name="password2"><br>
	University Affiliation: <input style="margin-left: 22px;" type="text" name="affiliation"><br>
<input class="btn btn-primary" type="submit" value="Create Account">
</form> 




	
</div>
	<?php include("Includes/footer.php"); ?>
</body>
</html>