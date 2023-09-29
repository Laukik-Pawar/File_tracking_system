<?php
    require "connection/connection.php";

//Protecting Pages
if (isset($_SESSION['user'])) {
    header("location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name) or empty($email) or empty($password) or empty($confirm_password)) {
        die("All field's are compulsory.");
    }
    if ($password != $confirm_password) {
        die("Password did not matched.");
    }
    if (!stripos($email, '@')) {
        die("Invalid email address.");
    }
}
else {
    die('error');
}

//Now we can insert this data into the database

//Remember to write query in between double quotes.
$insertQuery = "INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$name','$email','$password')";
$result = mysqli_query($connection, $insertQuery);

header("location: index.php");
