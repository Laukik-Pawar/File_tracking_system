<?php


require "connection/connection.php";
require "init.php";


$file_id = $_REQUEST["file_id"];

$fileQuery =  "SELECT  *  FROM `files` WHERE id = $file_id;";
$getFileResult = mysqli_query($connection,$fileQuery );
$fileObject = mysqli_fetch_object($getFileResult);

$createdUserQuery =  "SELECT  id  FROM `users` WHERE id = $fileObject->user_id;";
$getCreatedUserResult = mysqli_query($connection,$createdUserQuery );
$createdUserObject = mysqli_fetch_object($getCreatedUserResult);

if ($createdUserObject->id == $_SESSION['user']) {
    $fileDeleteQuery = "DELETE FROM `files` WHERE id = " . $fileObject->id;
    $movementsDeleteQuery = "DELETE FROM `movements` WHERE `movements`.`file_id` = " . $fileObject->id;
    mysqli_query($connection,$fileDeleteQuery );
    mysqli_query($connection,$movementsDeleteQuery );
    header("location: files.php");
} else {
    die("ERROR: Only the user who created the file can delete it.");
}