<?php 
    require "connection/connection.php";
    if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user'];
        $getQuery = "SELECT * FROM `users` where `id` = $user_id";
        $result = mysqli_query($connection,$getQuery);
        $userData = mysqli_fetch_array($result);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>FTS</title>

    
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
        
        <div class="row" style="border: 2px solid #CCC;">
            <!-- Main Content -->
            
            <div class="col-md-4" >
                <!-- Sidebar -->
                <h3>Dive In</h3>
                <hr>
                <ul style="list-style: none; text-align: center;">
                    <?php if (!isset($_SESSION['user'])): ?>                    
                    <li><a  href="register.php"><button class="btn btn-block btn-danger">Register</button></a></li>
                    <br>
                    <li><a  href="login.php"><button class="btn btn-block btn-danger">Login</button></a></li>
                    <?php endif ?>
                    <?php if (isset($_SESSION['user'])): ?>
                    
                        </p>
                        <br>
                        <!-- <p>Logged In</p> -->
                        <li><a  href="addfile.php"><button class="btn btn-block btn-primary">Add File</button></a></li><br>
                        <li><a  href="files.php"><button class="btn btn-block btn-primary">Files</button></a></li><br>
                        <li><a  href="notifications.php"><button class="btn btn-block btn-primary">Notifications</button></a></li><br>
                        <li><a  href="profile.php"><button class="btn btn-block btn-danger">Profile</button></a></li>
                        <br>
                        <?php if ($userData[4]): ?>
                            <!-- <p>User with Admin Rights</p> -->
                            <li><a  href="show.php"><button class="btn btn-block btn-danger">Show Users</button></a></li>
                            <br>
                        <?php endif ?>
                        <li><a  href="logout.php"><button class="btn btn-block btn-danger">Log Out</button></a></li>
                    <?php endif ?>
                    
                </ul>
            </div>
        </div>
        <!-- adding footer -->
        <footer style="margin-top: 100px;">
            
        </footer>
        <!-- footer end -->
    </div> 
    <!-- End Container     -->
</body>