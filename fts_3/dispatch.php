<?php

require "connection/connection.php";
require "init.php";

if (!isset($_SESSION['user'])) {
    header("location: index.php");
} else {
    $user_id = $_SESSION['user'];
    $dObject = isDispatchable($connection, $_REQUEST['file_id']);
    if (!$dObject) {
        die("You do not have privilege or this file.");
    }
    
    $fileQuery =  "SELECT  *  FROM `files` WHERE id = {$_REQUEST['file_id']};";
    $getFileResult = mysqli_query($connection,$fileQuery );
    $fileObject = mysqli_fetch_object($getFileResult);

    $usersQuery =  "SELECT  *  FROM `users`;";
    $getUserResult = mysqli_query($connection,$usersQuery );
    $usersObject = mysqli_fetch_all($getUserResult);
   
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
        
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Dispatch File: <?php echo $fileObject->filename ?></h3>
                </div>
                <div style="padding: 10px;">
                    <form action="dispatchfile.php" method="post" autocomplete="off">
                      
                        <div class="form-group">
                            <label for="dispatch_name">Dispatch File to:</label><br>
                            <select name="dispatch_name" id="dispatch_name" class="form-control">
                                <?php foreach ($usersObject as $user): ?>
                                    <option value="<?php echo $user[0]; ?>"><?php echo $user[1]; ?></option>
                                <?php endforeach ?>
                            </select>
                            <br>
                            <div class="form-group">
                            <label for="note">Note (Optional)</label>
                            <input type="text" name="note" class="form-control" value="">
                            </div>   
                            <br>
                            <input type="hidden" name="file_id" value="<?php echo $_REQUEST['file_id'] ?>">
                        </div>
                        <input type="submit" value="Dispatch" class="btn btn-danger btn-block">
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
</html>