<?php
require('dbconfig.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function sendMail($email, $reset_token)
{
  //* load composer's autoloader
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
    $mail->Username   = 'yourmail@email.com';                     //? SMTP username
    $mail->Password   = 'password';                               //? SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //? Enable implicit TLS encryption
    $mail->Port       = 465;                                    //? TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //? Recipients
    $mail->setFrom('yourmail@email.com', 'PHP Programmar');
    $mail->addAddress($email);     // add email recipient

    // content
    $mail->isHTML(true);                                  //? Set email format to HTML
    $mail->Subject = "Reset Password from PHP Programmar";
    $mail->Body    = "We have received a request from you to reset your password! <br>
        You can reset your password by clicking the below link! <br>
      <a href='http://localhost/Projects/user-register-login-using-php/updatepass.php?email=$email&reset_token=$reset_token'>Reset Password</a>";

    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}

if (isset($_POST['reset-btn'])) {
  //? if user click reset password button
  $select = "SELECT * FROM `reged_users` WHERE `email` = '$_POST[email]'";
  $result = mysqli_query($con, $select);

  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      //* email found in database
      $reset_token = bin2hex(random_bytes(16));
      date_default_timezone_set('Asia/Kolkata');
      $date = date('Y-m-d');
      $update = "UPDATE `reged_users` SET `reset_token`='$reset_token',`token_expiry`='$date' 
      WHERE `email` = '$_POST[email]'";
      $query = mysqli_query($con, $update);

      if ($query && sendMail($_POST['email'], $reset_token)) {
        //* email send to user
        print "
        <script>
          alert ('Reset password link has been sent to your registered email');
          window.location.href = 'index.php';
        </script>";
      } else {
        //* coding error
        print "
        <script>
          alert ('Server down! Please try again in some time');
          window.location.href = 'index.php';
        </script>";
      }
    } else {
      //* email not found in database
      print "
    <script>
      alert ('Please enter a registered email');
      window.location.href = 'index.php';
    </script>";
    }
  } else {
    print "
    <script>
      alert ('Please try again later');
      window.location.href = 'index.php';
    </script>";
  }
}
