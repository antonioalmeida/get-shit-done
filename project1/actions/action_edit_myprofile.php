<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

try {
  updateUser($_POST['username'], $_POST['picture'], $_POST['name'], $_POST['bio']);
} catch (PDOException $e) {
  die($e->getMessage());
}

$referer = '../myprofile.php';
header('Location: ' . $referer);
?>
