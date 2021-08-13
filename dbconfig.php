<?php

$server = 'localhost';
$user = 'root';
$password = '';
$database = 'register';

//* Attempt to connect to MySQL database
$con = mysqli_connect($server, $user, $password, $database);

//! Check connection
if (mysqli_connect_error()) {
  print "<script>alert('Error! Please check database connection');</script>";
  exit();
}
