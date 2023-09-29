<?php
require "connection/connection.php";

if (!isset($_SESSION['user'])) {
    header("location: index.php");
    die();
}

$attached = null;
if (isset($_FILES["fileupload"])) {
    $attached = $_FILES["fileupload"]["tmp_name"];
    $attached = mysqli_real_escape_string($connection, file_get_contents($attached)); // Read and escape the file content
}

$file_id = ($_POST["file_id"]);
$file_name = ($_POST["file_name"]);
$description = ($_POST["description"]);

$rawQuery = "INSERT INTO `files` (`hardid`, `filename`, `attachment`, `description`, `user_id`) VALUES ('%s', '%s', '%s', '%s', '%d');";
$query = sprintf($rawQuery, $file_id, $file_name, $attached, $description, $_SESSION['user']);
$result = mysqli_query($connection, $query, MYSQLI_USE_RESULT);

$fileid = mysqli_insert_id($connection);

// Movement
$rawMovementQuery = "INSERT INTO `movements` (`from_id`, `file_id`, `to_id`) VALUES ('%d', '%d', '%d');";
$movementQuery = sprintf($rawMovementQuery, $_SESSION['user'], $fileid, $_SESSION['user']);
$result = mysqli_query($connection, $movementQuery);

header("location: files.php");
?>
