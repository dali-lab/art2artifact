<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Art2Artifact - Home</title>

<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>
<script type="text/javascript" src="Content/validation.js"></script>
<style type="text/css" media="all">@import "Content/master.css";</style>  <style type="text/css" media="all">@import "Content/master.css";</style>

<link rel="stylesheet" href="Content/bootstrap_navbar.css"/> 
<script type="text/javascript">
	$(document).ready(function(){

	// Validate
	// http://bassistance.de/jquery-plugins/jquery-plugin-validation/
	// http://docs.jquery.com/Plugins/Validation/
	// http://docs.jquery.com/Plugins/Validation/validate#toptions

		$('#login-form').validate({
	    rules: {
	      title: {
	        maxlength: 45,
	        required: true
	      },
	      description: {
	        maxlength:200
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
<?php
if (isset($_GET["new_corpus"])) {
	echo '<script type="text/javascript">$(window).load(function(){$("#add_corpus_modal").modal("show");});</script>';				
}
?>

<body style="background-image: url(Content/Login_map.jpg); background-size: 100%;">

	<?php include('Includes/header.php'); ?>
	
	

<div style="width: 100%; height: 100%; padding: 20px; background-color: rgba(150, 27, 25, 0.75); border-color: black;">
 	
	 
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

       $db->login($_SESSION['email'], $_SESSION['password']);
   
       $db->disconnect();
?>

	
</div>

<div class="modal hide fade" id="add_corpus_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Create New Corpus</h3>
	</div>
	<div class="modal-body">
		<form action="create_corpus.php" method="post" class="form-horizontal" id="create-corpus">
			<div class="control-group">
				<label class="control-label" for="title_id">Title:</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="title" id="title_id">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="description_id">Description:</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="description" id="description_id">
				</div>
			</div>
	</div>
	<div class="modal-footer">
		<input class="btn btn-primary" name="addcorpus" type="submit" value="Next" />
		</form>
  </div>
</div>

<div class="modal hide fade" id="change_status_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Request Status Change</h3>
	</div>
	<div class="modal-body">
		<form action="request_change.php" method="post" class="form-horizontal" id="create-corpus">
			<div class="control-group">
				<label class="control-label" for="title_id">Title:</label>
				<div class="controls">
					<select name="status_change">
						<option>Student</option>
						<option>Admin</option>
					</select>
				</div>
			</div>
	</div>
	<div class="modal-footer">
		<input class="btn btn-primary" name="addcorpus" type="submit" value="Next" />
		</form>
  </div>
</div>


<?php include('Includes/footer.php'); ?>
</body>
</html>