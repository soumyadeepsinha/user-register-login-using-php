<?php include 'header.php'; ?>

<div class="popup-container" id="login-popup">
  <div class="popup">
    <form method="POST" action="log_reg.php">
      <h2>
        <span>USER LOGIN</span>
        <button type="reset" onclick="popup('login-popup')">X</button>
      </h2>
      <input type="text" placeholder="E-mail or Username" name="email_username">
      <input type="password" placeholder="Password" name="password">
      <button type="submit" class="login-btn" name="login">LOGIN</button>
    </form>
  </div>
</div>

<div class="popup-container" id="register-popup">
  <div class="register popup">
    <form method="POST" action="log_reg.php">
      <h2>
        <span>USER REGISTER</span>
        <button type="reset" onclick="popup('register-popup')">X</button>
      </h2>
      <input type="text" placeholder="Full Name" name="fullname">
      <input type="text" placeholder="Username" name="username">
      <input type="email" placeholder="E-mail" name="email">
      <input type="password" placeholder="Password" name="password">
      <button type="submit" class="register-btn" name="register">REGISTER</button>
    </form>
  </div>
</div>

<?php

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
  print "<h1> WELCOME TO iLovephp - <span style='font-style: italic;'> $_SESSION[username] </span></h1>";
}

?>

<?php include 'footer.php'; ?>