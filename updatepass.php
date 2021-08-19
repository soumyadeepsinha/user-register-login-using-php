<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Password</title>
  <style>
    * {
      margin: 0px;
      padding: 0px;
      box-sizing: border-box;
      text-decoration: none;
      font-family: 'Poppins', sans-serif;
    }

    :root {
      --primary-color: #273e47;
      --reset-color: #3a86ff;
      --secondary-color: #deb841;
      --background-color: #75cfb8;
    }

    form {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #f0f0f0;
      width: 350px;
      border-radius: 5px;
      padding: 20px 25px 30px 25px;
    }

    form h3 {
      margin-bottom: 14px;
      color: var(--primary-color);
    }

    form input {
      width: 100%;
      margin-bottom: 20px;
      padding: 5px 0;
      background-color: transparent;
      border: none;
      border-bottom: 2px solid var(--primary-color);
      border-radius: 0;
      outline: none;
      font-size: 15px;
      font-weight: 450;
    }

    form button {
      font-weight: 500;
      color: white;
      background-color: var(--primary-color);
      border: none;
      outline: none;
      padding: 4px 10px;
    }
  </style>
</head>

<body>
  <?php

  require('dbconfig.php');

  if (isset($_GET['email']) && isset($_GET['reset_token'])) {
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    $query = "SELECT * FROM `reged_users` WHERE `email` = '$_GET[email]' AND `reset_token` = '$_GET[reset_token]' AND `token_expiry` = '$date'";
    $result = mysqli_query($con, $query);

    if ($result) {
      if (mysqli_num_rows($result) == 1) {
        print "
        <form action=''>
          <h3>Create New Password</h3>
          <input type='password' name='Password' placeholder='Please Enter your new password' />
          <button type='submit' name='updatepassword'>Reset Password</button>
          <input type='hidden' name='email' value='$_GET[email]' />
        </form>";
      } else {
        print "
      <script>
        alert ('Invalid or Expired link');
        window.location.href = 'index.php';
      </script>";
      }
    } else {
      print "
      <script>
        alert ('Server down! Please try again in some time');
        window.location.href = 'index.php';
      </script>";
    }
  }


  ?>
</body>

</html>