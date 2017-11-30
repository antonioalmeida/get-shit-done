<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

  if (isLoginCorrect($_POST['username'], $_POST['password'])) {
    setCurrentUser($_POST['username']);
    $_SESSION['success_messages'][] = "Login Successful!";
    $referer = '../mylists.php';
  } else {
    $_SESSION['error_messages'][] = "Login Failed!";
    $referer = '../login.php';
  }

  header('Location: ' . $referer);
?>
