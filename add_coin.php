<?php session_start(); 
if (!isset($_SESSION['email'])) {
	header("Location: login.php?test=fail");
}?>
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
                
                $('#add-coin').validate({
                    rules: {
                        date_start: {
                            digits: true,
                            required: true
                        },
                        date_end: {
                            digits: true,
                            required: true
                        },
						
                        mint_location: {
                            required: true
                        },
						
                        find_location: 
                            digits: true,
                            required: true
                        },
                        bibliography: {
                            required: true,
                            maxlength: 200
                        },
                        obverse_legend: {
                            maxlength: 500
                        },
                        reverse_legend: {
                            maxlength: 500
                        }
                    },
                    highlight: function(element){
                        $(element).closest('.control-group').removeClass('success').addClass('error');
                    },
                    success: function(element){
                        element.text('OK!').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
                    }
                });
                
                $('#add-location').validate({
                    rules: {
                        lat: {
                            number: true,
                            required: true
                        },
                        long: {
                            number: true,
                            required: true
                        },
                        loc_name: {
                            required: true
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
        <div style="height: 100%; background-color: rgba(250, 250, 250, 0.75); padding: 30px 30px 30px 30px; width: 97%; border-color: black;">
            <div class="row">
			<center>
                <h1>Add Coin</h1>
            </center>
			</div>
			<div class="row">
            <div class="modal" style="position: relative; left: auto; right: auto; margin: 0 auto 20px; z-index: 1; max-width: 100%; height: 70%; overflow-y: scroll;">
                	
                    <form action="add_coin_php.php" method="post" ENCTYPE="multipart/form-data" class="form-horizontal" id="add-coin">
                        <div class="control-group">
                            <label class="control-label" for="file">
								<?php
									if (isset($_GET["error"])) {
										echo "<font color='red'>*Select Photo:</font>";
									}
									else {
										echo "Photo:";
									}
								?>
                            </label>
                            <div class="controls">
                                <input type="file" name="file" id="file"><input type="hidden" name="uploaded" value="1">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="era_category">
                                Era Category:
                            </label>
                            <div class="controls">
                                <select name="era_category">
                                    <option value="Republican">Republican</option>
                                    <option value="Imperial">Imperial</option>
                                    <option value="Archaic">Archaic</option>
                                    <option value="Classical">Classical</option>
                                    <option value="Hellenistic">Hellenistic</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="region_category">
                                Region Category:
                            </label>
                            <div class="controls">
                                <select name="region_category">
                                    <option value="Greek">Greek</option>
                                    <option value="Roman">Roman</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="dates_div">
                                Date Range: 
                            </label>
                            <div class="controls">
                                <div name="dates_div">
                                	<input style="width: 100px;" type="text" name="date_start">
                                    <select name="era_start" style="width: 60px;">
                                        <option value="-">BCE</option>
                                        <option value="">AD</option>
                                    </select>
                                    - <input type="text" style="width: 100px;" name="date_end">
                                    <select name="era_end" style="width: 60px;">
                                        <option value="-">BCE</option>
                                        <option value="">AD</option>
                                    </select>
                                    <p>
                                        *(If you have a specific date enter it for both the start and end dates)
                                    </p>
                                </div>
                            </div>
                        </div>
						<?PHP
							include "phpfunctions.php";
							$db = new SunapeeDB();
							$db->connect();
							$db->get_locations(1);
							$db->disconnect();
						?>
						
                        <div class="control-group">
                            <label class="control-label" for="denomination">
                                Denomination:
                            </label>
                            <div class="controls">
                                <input type="text" name="denomination">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mint_authority">
                                Mint Authority:
                            </label>
                            <div class="controls">
                                <input type="text" name="mint_authority">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="obverse_legend">
                                Obverse Legend:
                            </label>
                            <div class="controls">
                                <input type="text" name="obverse_legend">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="reverse_legend">
                                Reverse Legend:
                            </label>
                            <div class="controls">
                                <input type="text" name="reverse_legend">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="bibliography">
                                Bibliography:
                            </label>
                            <div class="controls">
                                <input type="text" name="bibliography">
                            </div>
                        </div><center><input class="btn btn-primary" type="submit" value="Add Coin"></center>
                    </form>
</div>
            </div>
            <div class="modal hide fade" id="addLocationModal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        x
                    </button>
                    <h3>Add a Location</h3>
                </div>
                <div class="modal-body">
                    <form action="add_location.php" method="post" class="form-horizontal" id="add-location">
                        Location Latitude:<input type="text" name="lat" style="margin-left:20px;">
                        <br>
                        Location Longitude:<input type="text" name="long" style="margin-left: 8px;">
                        <br>
                        Location Name:<input type="text" name="loc_name" style="margin-left: 33px;">
                        </div>
                        <div class="modal-footer">
                        <input class="btn btn-primary" name="addloc" type="submit" value="Add Location" />
                    </form>
                </div>
            </div>
            <?php include("Includes/footer.php"); ?>
            </body>
        </html>