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
                    highlight: function(element){
                        $(element).closest('.control-group').removeClass('success').addClass('error');
                    },
                    success: function(element){
                        element.text('OK!').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
                    }
                });
                
            }); // end document.ready
        </script>
    </head>
    <body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">
        <?php include('Includes/header.php'); ?>
        <div class="hero-unit" style="width: 100%; height: 100%; padding: 20px; background-color: rgba(250, 250, 250, 0.75); border-color: black;">
            <center>
                <h1>Sign Up</h1>
                <p>
                    To get access to the Art2Artifact database
                </p>
			</center>	
	<div class="modal" style="position: relative; top: auto; left: auto; right: auto; margin: 0 auto 20px; z-index: 1; max-width: 100%;">
                
				<form action="add_user_php.php" method="post" ENCTYPE="multipart/form-data" class="form-horizontal" id="add-user" style="margin-top: 10px; margin-left: 10px; margin-bottom: 20px;">
					<div class="control-group">
                        <label class="control-label" for="email">
                            Profile Picture
                        </label>
                        <div class="controls">
                            <input type="file" name="file" id="file">
                        </div>
                    </div>
                    <input type="hidden" name="uploaded" value="1">
					<div class="control-group">
                        <label class="control-label" for="email">
                            Name:
                        </label>
                        <div class="controls">
                        	<input type="text" name="name">
                        </div>
                    </div>
					<div class="control-group">
                        <label class="control-label" for="email">
                            Email:
                        </label>
                        <div class="controls">
	                        <input type="text" name="email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="email">
                            Password:
                        </label>
                        <div class="controls">
	                        <input type="password" name="password" id="password_input_1">
                        </div>
                    </div>
					<div class="control-group">
                        <label class="control-label" for="email">
                            Input Password Again:
                        </label>
                        <div class="controls">
	                        <input type="password" name="password2">
                        </div>
                    </div>
					<div class="control-group">
                        <label class="control-label" for="email">
                            University Affiliation:
                        </label>
                        <div class="controls">
	                        <input type="text" name="affiliation">
                        </div>
                    </div>
					<div class="control-group">
                        <label class="control-label" for="email">
                            Status:
                        </label>
                        <div class="controls">
                        <select name="status" style="width: 220px;">
                            <option value="Student">Student</option>
                            <option value="Professor">Professor</option>
                            <option value="Other">Other</option>
                        </select>
                        </div>
                    </div>
					<center>
                    <input class="btn btn-primary btn-large" type="submit" value="Create Account">
               		</center>
			    </form>
				
			</div>
        </div>
        
        <?php include("Includes/footer.php"); ?>
    </body>
</html>