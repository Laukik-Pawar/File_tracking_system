<?php

require "connection/connection.php";
require "init.php";

if (!isset($_SESSION['user'])) {
    header("location: index.php");
} else {
    $user_id = $_SESSION['user'];
    $getQuery = "SELECT * FROM `notifications` where `user_id` = '$user_id' order by created_at desc";
    $result = mysqli_query($connection, $getQuery);

    $notifcationsData = mysqli_fetch_all($result);
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Notifications</title>

    
    <!-- Linking bootstrap this will give us ways to produce responsive designs with ease -->


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container" style="margin-top: 50px; ">
        <div class="col-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Notifications</h3>
                </div>
                <div style="padding: 10px;">
                    <br>
                        <a  href="index.php"><button class="btn btn-sm btn-primary">Home</button></a> 
                        <a  href="files.php"><button class="btn btn-sm btn-primary">Files</button></a> 
                        <a  href="addfile.php"><button class="btn btn-sm btn-primary">Add File</button></a>
                    <br><br>
                    <table class="table table-bordered">
                      <thead class="thead-dark" style="background: #2e6fa7; color: white;">
                        <tr>
                          <th scope="col">Content</th>
                          <th scope="col">Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($notifcationsData as $key => $notification): ?>
                            <tr>
                              <td><?php echo $notification[2]; ?></td>
                              <td><?php echo date("d.m.Y h.i A", strtotime($notification[3])) ?></td>
                            </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
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
