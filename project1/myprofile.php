<?php
  include_once('includes/init.php');
  include_once('templates/common/header.php');

  $isLoggedIn = (isset($_SESSION['username']));
  $username = $_SESSION['username'];

  include_once('templates/profile/myprofile.php');
  include_once('templates/common/footer.php');

?>
