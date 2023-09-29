<?php

require "connection/connection.php";
require "init.php";

if (!isset($_SESSION['user'])) {
    header("location: index.php");
} else {
    $user_id = $_SESSION['user'];
    $fileObject = isDispatchable($connection, $_REQUEST['file_id']);
    if (!$fileObject) {
        die("You do not have privilege or this file.");
    }

    $usersQuery =  "SELECT  *  FROM `users`;";
    $getUserResult = mysqli_query($connection,$usersQuery );
    $usersObject = mysqli_fetch_all($getUserResult);
   
}

$to_id = $_POST["dispatch_name"];
$file_id = $_POST["file_id"];
$note = $_POST["note"];

$user_id = $_SESSION['user'];
$fileQuery =  "INSERT INTO `movements` (`from_id`, `file_id`, `to_id`, `note`) VALUES ('$user_id', '$file_id', '$to_id', '$note');";
mysqli_query($connection,$fileQuery );


$fileQuery =  "SELECT  *  FROM `files` WHERE id = $file_id;";
$getFileResult = mysqli_query($connection,$fileQuery );
$fileObject = mysqli_fetch_object($getFileResult);


$fromUserQuery =  "SELECT  *  FROM `users` WHERE id = $fileObject->user_id;";
$fromUserResult = mysqli_query($connection,$fromUserQuery );
$fromUserObject = mysqli_fetch_object($fromUserResult);

$notificationQuery =  "INSERT INTO `notifications` (`user_id`, `content`) VALUES ('$to_id', 'A file with name \"{$fileObject->filename}\" has been arrived from \"{$fromUserObject->name}\" with note: \"$note\".');";
mysqli_query($connection,$notificationQuery );

header("location: track.php?file_id=".$file_id);
