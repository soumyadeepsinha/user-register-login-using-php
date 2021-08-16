<?php

require('dbconfig.php');

if (isset($_GET['email']) && $_GET['verificationcode']) {
  $query =
    "SELECT * FROM `reged_users` WHERE `email` = '$_GET[email]' AND `verification_code` = '$_GET[verificationcode]'";
  $result = mysqli_query($con, $query);

  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      $fetchresult = mysqli_fetch_assoc($result);
      if ($fetchresult['is_verified'] == 0) {
        $update = "UPDATE `reged_users` SET `is_verified` = '1' WHERE `email` = '$fetchresult[email]'";
        if (mysqli_query($con, $update)) {
          print "
        <script>
          alert('Email verified successfully');
          window.location.href='index.php';
        </script>";
        } else {
          print "
          <script>
            alert('Verification Failed! Please try again later');
            window.location.href='index.php';
          </script>";
        }
      } else {
        print "
        <script>
          alert('Your Email is already verified');
          window.location.href='index.php';
        </script>";
      }
    } else {
      print "
      <script>
        alert('Error! Please try again later');
        window.location.href='index.php';
      </script>";
    }
  } else {
    print "
    <script>
      alert('Server Problem, Please try again later');
      window.location.href='index.php';
    </script>";
  }
}
