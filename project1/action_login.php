<?php
include_once('includes/init.php');
include_once('database/user.php');
  if (isLoginCorrect($_POST['username'], $_POST['password'])) {
    setCurrentUser($_POST['username']);
  }

  if (isset($_SERVER['HTTP_REFERER'])){
    $referer = $_SERVER['HTTP_REFERER'];
  } else{
    $referer = 'index.php';
  }
  
  header('Location: ' . $referer);
?>
