<?php

session_start();
session_unset();

session_destroy();

print "
<script>
  alert ('You\'ve Logged out');
  // window.location.href='index.php';
</script>
";

header('location: index.php');
