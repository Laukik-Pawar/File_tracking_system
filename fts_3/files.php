<?php
require "connection/connection.php";
require "init.php";

if (!isset($_SESSION['user'])) {
    header("location: index.php");
} else {
    $user_id = $_SESSION['user'];
    $getQuery = "SELECT * FROM `movements` WHERE `to_id` = '$user_id' ORDER BY created_at DESC";
    $result = mysqli_query($connection, $getQuery);

    $filesData = mysqli_fetch_all($result);
    $filesData = array_unique(array_map(function ($i) { return $i[2]; }, $filesData));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Files</title>
    
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
                    <h3>Files</h3>
                </div>
                <div style="padding: 10px;">
                    <br>
                    <a  href="index.php"><button class="btn btn-sm btn-primary">Home</button></a> 
                    <a  href="addfile.php"><button class="btn btn-sm btn-primary">Add File</button></a>
                    <br><br>
                    <table class="table table-bordered">
                        <thead class="thead-dark" style="background: #2e6fa7; color: white;">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Added</th>
                                <th scope="col">Added By</th>
                                <th scope="col">Controls</th>
                                <th scope="col">Soft File</th> <!-- Added "Soft File" column -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 0; ?>
                            <?php foreach ($filesData as $key => $file_id): ?>
                                <?php 
                                    $fileQuery =  "SELECT * FROM `files` WHERE id = $file_id;";
                                    $getFileResult = mysqli_query($connection, $fileQuery);
                                    $fileObject = mysqli_fetch_object($getFileResult);

                                    $createdUserQuery =  "SELECT * FROM `users` WHERE id = $fileObject->user_id;";
                                    $getCreatedUserResult = mysqli_query($connection, $createdUserQuery);
                                    $createdUserObject = mysqli_fetch_object($getCreatedUserResult);
                                    $count++;

                                    // Retrieve and display the soft file content
                                    $softFileContent = base64_encode($fileObject->attachment);
                                 ?>
                                <tr>
                                    <th scope="row"><?php echo $count ?></th>
                                    <td><?php echo $fileObject->hardid; ?></td>
                                    <td><?php echo $fileObject->filename; ?></td>
                                    <td title="<?php echo $fileObject->description; ?>"><?php echo substr($fileObject->description, 0, 50); ?>...</td>
                                    <td><?php echo date("d.m.Y h.i A", strtotime($fileObject->created_at)) ?></td>
                                    <td><?php echo $createdUserObject->name ?></td>
                                    <td>
                                        <!-- ... (controls) -->
                                        <?php if ($fileObject->attachment): ?>
                                     <!-- Display the View PDF link with the file ID as a query parameter -->
                                    <a href="show_pdf.php?id=<?php echo $fileObject->id; ?>">View File</a>
                                    
                                    <?php endif ?>

                                  <?php if ($fileObject->attachment): ?>
                                    <!-- <a  href="/file/<?php echo $fileObject->attachment ?>" download="<?php echo $fileObject->attachment ?>"><button class="btn btn-sm btn-primary">Download</button></a>  -->
                                    <!-- <a href="showing.php">View PDF</a> -->
                                    
                                  <?php endif ?>
                                  <a  href="/fts_3/track.php?file_id=<?php echo $fileObject->id; ?>"><button class="btn btn-sm btn-primary">Track</button></a> 
                                  <?php if (isDispatchable($connection, $fileObject->id)): ?>
                                    <a  href="/fts_3/dispatch.php?file_id=<?php echo $fileObject->id; ?>"><button class="btn btn-sm btn-primary">Dispatch</button></a> 
                                  <?php endif ?>
                                  <?php if ($createdUserObject->id == $_SESSION['user']): ?>
                                    <a  href="deletefile.php?file_id=<?php echo $fileObject->id; ?>" ><button class="btn btn-sm btn-danger">Delete</button></a> 
                                  <?php endif ?>

                              
                                    </td>
                                    <td>
                                        <?php if ($fileObject->attachment): ?>
                                            <!-- Display the soft file download link -->
                                            <a href="data:application/octet-stream;base64,<?php echo $softFileContent; ?>" download="<?php echo $fileObject->filename; ?>">Download Soft File</a>
                                        <?php endif ?>
                                        
                                    </td>
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
</html>
