<?php
    require "connection/connection.php";

//Protecting Pages
if (isset($_SESSION['user'])) {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>myPHPnotes Club</title>

    
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
                    <h3>Register</h3>
                </div>
                <div style="padding: 10px;">
                    <form action="registering.php" method="post" autocomplete="off">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="text" name="email" placeholder="you@somewhere.com" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password"  class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" value="">
                        </div>
                        <input type="submit" value="Register" class="btn btn-danger btn-block">
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