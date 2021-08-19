<?php

require_once('dbconfig.php');

if (isset($_POST['reset-link'])) {
  $query = "SELECT * FROM `reged_users` WHERE email = '$_POST[email]'";
  $result = mysqli_query($con, $query);

  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      //* email found in database
      $reset_token = bin2hex(random_bytes(16));
      date_default_timezone_set('Asia/Kolkata');
      $date = date('Y-m-d');

      $update = "UPDATE `reged_users` SET `reset_token` = '$reset_token', `token_expiry` = '$date' 
      WHERE `email` = '$_POST[email]'";
      $updatequery = mysqli_query($con, $update);

      if ($updatequery && sendMail($_POST['email'], $reset_token)) {
        print "
        <script>
          alert('A password reset link has been sent to - $_POST[email] ');
          window.location.href='index.php';
        </script>";
      } else {
        print "
      <script>
        alert('Server Down! Please try again in some time');
        window.location.href='index.php';
      </script>";
      }
    } else {
      //* email not found in database
      print "
      <script>
        alert('Invalid Email id');
        window.location.href='index.php';
      </script>";
    }
  } else {
    print "
    <script>
      alert('Please try again later');
      window.location.href='index.php';
    </script>";
  }
}
