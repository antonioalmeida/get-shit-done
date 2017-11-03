<?php
  include_once('includes/init.php');
  session_destroy();
  if (isset($_SERVER['HTTP_REFERER'])){
    $referer = $_SERVER['HTTP_REFERER'];
  } else{
    $referer = 'index.php';
  }
  header('Location: ' . $referer);
?>
