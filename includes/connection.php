<?php
ob_start();
require_once('config.php');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gkresear_laravel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed Test: " . $conn->connect_error);
}
session_start();
/*
if(!$_SESSION['is_login']){
$_SESSION['is_login'] == false;
}
*/
?>