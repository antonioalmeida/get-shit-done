<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

  if (isLoginCorrect($_POST['username'], $_POST['password'])) {
    setCurrentUser($_POST['username']);
  }

  $referer = '../mylists.php';

  //TODO: Add redirect to login page again in case of login error

  header('Location: ' . $referer);
?>
