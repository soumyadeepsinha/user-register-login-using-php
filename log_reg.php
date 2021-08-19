<?php

require('dbconfig.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $verificationcode)
{
  //* load Composer's autoloader
  require('PHPMailer/PHPMailer.php');
  require('PHPMailer/Exception.php');
  require('PHPMailer/SMTP.php');

  //* create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
    //? Server settings                     
    $mail->isSMTP();                                            //? Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //? Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //? Enable SMTP authentication
    $mail->Username   = 'youremail@mail.com';                     //? SMTP username
    $mail->Password   = 'password';                               //? SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //? Enable implicit TLS encryption
    $mail->Port       = 465;                                    //? TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //? Recipients
    $mail->setFrom('phpprogrammar1@gmail.com', 'PHP Programmar');
    $mail->addAddress($email);     // add email recipient

    //Content
    $mail->isHTML(true);                                  //? Set email format to HTML
    $mail->Subject = "Email Verification from PHP Programmar";
    $mail->Body    = "Thanks for Registration with us!
    Please click the link below to verify your email - 
      <a href='http://localhost/Projects/Registration/verify.php?email=$email&verificationcode=$verificationcode'>Verify</a>";

    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}

//! LOGIN ---
if (isset($_POST['login'])) {
  $query = "SELECT * FROM `reged_users` WHERE `email`='$_POST[email_username]' OR `username`='$_POST[email_username]'";
  $result = mysqli_query($con, $query);

  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      $result_fetch = mysqli_fetch_assoc($result);
      if (password_verify($_POST['password'], $result_fetch['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $result_fetch['username'];
        print "
        <script>
          alert ('You\'ve Logged in successfully');
          window.location.href='index.php';
        </script>";
      } else {
        print "
          <script>
            alert('Incorrect Password');
            window.location.href='index.php';
          </script>";
      }
    } else {
      print "
        <script>
          alert('Email or Username Not Registered');
          window.location.href='index.php';
        </script>";
    }
  } else {
    print "
      <script>
        alert('Cannot Run Query');
        window.location.href='index.php';
      </script>";
  }
}


//! REGISTRATION ---
if (isset($_POST['register'])) {
  $user_exist_query = "SELECT * FROM `reged_users` WHERE `username`='$_POST[username]' OR `email`='$_POST[email]'";
  $result = mysqli_query($con, $user_exist_query);

  if ($result) {
    if (mysqli_num_rows($result) > 0) #it will be executed if username or email is already taken
    {
      $result_fetch = mysqli_fetch_assoc($result);
      if ($result_fetch['username'] == $_POST['username']) {
        //! error for username already registered
        print "
          <script>
            alert('$result_fetch[username] - Username already taken');
            window.location.href='index.php';
          </script>";
      } else {
        //! error for email already registered
        print "
          <script>
            alert('$result_fetch[email] - E-mail already registered');
            window.location.href='index.php';
          </script>";
      }
    } else
    //! it will be executed if no one has taken username or email before
    {
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      $verificationcode = bin2hex(random_bytes(14));

      //! id & created_at fields will be auto generated
      $query = "INSERT INTO `reged_users`(`full_name`, `username`, `email`, `password`, `verification_code`, `is_verified`)
      VALUES ('$_POST[fullname]','$_POST[username]','$_POST[email]','$password', '$verificationcode', '0')";

      if (mysqli_query($con, $query) && sendMail($_POST['email'], $verificationcode)) {
        //! if data inserted successfully
        print "
          <script>
            alert('Registration Successful');
            window.location.href='index.php';
          </script>";
      } else {
        //! if data cannot be inserted
        print "
          <script>
            alert('Error! Please try again later');
            window.location.href='index.php';
          </script>";
      }
    }
  } else {
    print "
      <script>
        alert('Cannot Run Query');
        window.location.href='index.php';
      </script>";
  }
}
