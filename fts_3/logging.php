<?php

require "connection/connection.php";



//Protecting Pages
if (isset($_SESSION['user'])) {
    header("location: index.php");
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
} else {
    die('getted');
}

//fetching User from the database
//

$getQuery = "SELECT * FROM `users` where `email` = '$email' and `password` = '$password' ;";
$result = mysqli_query($connection, $getQuery);

$userData = mysqli_fetch_array($result);
if (!$userData) {
    die('Invalid password and email combination.');
}
$user_id = $userData[0];
$_SESSION['user'] = $user_id;

header("location: index.php");