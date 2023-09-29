<?php

$host = "localhost";
$username = "root";

$database = "fts";


$connection = mysqli_connect($host, $username, '', $database,3307);

//here if $connection have a value null, it will imply that our system is not connected to the database "myphpnotes";
//if $connection have some value other than null, it will then imply, our system is connected to our database;


//if !$connection means if the $connection has 0, null, false value, this will run.
if (!$connection) {
    die('Not able to connect to the database;');
}

session_start();

//See if we enter wrong credentials we got a flag that "not able to connect to database" and if out credentials are fine, we got "Connection Successfully Established."