<?php

require "connection/connection.php";

if (!isset($_SESSION['user'])) {
    header("location: index.php");
    die();
} else {

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Profile</title>

    
    <!-- Linking bootstrap this will give us ways to produce responsive designs with ease -->


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container" style="margin-top: 50px; width: 850px;">
        
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Add File</h3>
                </div>
                <div style="padding: 10px;">
                    <form action="postaddfile.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        
                    <div class="form-group">
                            <label for="file_id">File ID</label>
                            <input type="text" required="required" name="file_id" class="form-control" value="">
                        </div>

                        <div class="form-group">
                            <label for="file_name">File Name</label>
                            <input type="text" name="file_name" required="required" class="form-control" value="">
                        </div> 

                        <div class="form-group">
                            <label for="description">File Description (Optional)</label>
                            <input type="text" name="description" class="form-control" value="">
                        </div>

                        <div class="form-group">
                            <label for="fileupload">Soft File (Optional)</label>
                            <input type="file" name="fileupload" class="form-control" value="">
                            
                            <!-- <a href="form.html">Add Attachment</a> -->
                        </div>
                           
                        <input type="submit"  class="btn btn-block btn-success" value="Add File">
                    </form>
                </div>
            </div>
        </div>
        <!-- adding footer -->
        <footer style="margin-top: 100px;">
            
        </footer>
        <!-- footer end -->
    </div> 
    <!-- End Container     -->
</body>