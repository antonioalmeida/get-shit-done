<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

try {
  updateUser($_POST['username'], $_POST['picture'], $_POST['name'], $_POST['bio']);
} catch (PDOException $e) {
  die($e->getMessage());
}

if (isset($_SERVER['HTTP_REFERER'])){
  $referer = $_SERVER['HTTP_REFERER'];
} else{
  $referer = '../myprofile.php';
}
header('Location: ' . $referer);
?>
