<?php
  include_once(dirname(__DIR__) . '/includes/init.php');

  if(!isset($_SESSION['username'])) {
  	    header('Location: ' . '../404.php');
  }
  
  session_destroy();

  session_start();
  $_SESSION['success_messages'][] = "User logged out!";

  header('Location: ' . '../index.php');
?>
