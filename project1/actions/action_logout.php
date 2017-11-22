<?php
  include_once(dirname(__DIR__) . '/includes/init.php');

  session_destroy();

  header('Location: ' . '../index.php');
?>
