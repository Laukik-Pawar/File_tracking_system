<?php

require "connection/connection.php";


//Protecting Pages
if (!isset($_SESSION['user'])) {
    header("location: index.php");
}
session_destroy();
header("location: index.php");