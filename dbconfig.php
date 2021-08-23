<?php

$server = 'localhost';
$user = 'root';
$password = '';
$database = 'register';

//* Attempt to connect to MySQL database
$con = mysqli_connect($server, $user, $password, $database);

//! Check connection
if (!$con) {
  print "
  <script>
    alert('Error! Can't connect to database at this moment');
  </script>";
  exit();
}
