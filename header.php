<?php

require_once 'dbconfig.php';
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- gogole font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <!-- custom style sheet -->
  <link rel="stylesheet" href="style.css">
  <title>Register & Login</title>
</head>


<header>
  <h2>iLovephp</h2>
  <nav>
    <a href="/Projects/Registration">Home</a>
    <a href="https://twitter.com/soumyadeep_27" target="_blank">About</a>
    <a href="https://github.com/soumyadeepsinha" target="_blank">Projects</a>
    <a href="https://soumyadeep-portfolio.netlify.app/" target="_blank">Portfolio</a>
  </nav>

  <?php
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    print "
      <div class='user'>
       <b> $_SESSION[username] ~ <a href='logout.php'>LOGOUT </b></a>
      </div>
      ";
  } else {
    print "
      <div class='sign-in-up'>
        <button type='button' onclick=\"popup('login-popup')\">LOGIN</button>
        <button type='button' onclick=\"popup('register-popup')\">REGISTER</button>
      </div>
      ";
  }
  ?>
</header>

<body>