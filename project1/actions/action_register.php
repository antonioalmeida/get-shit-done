<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];


if (usernameExists($username)) {
  $_SESSION['error_messages'][] = "Invalid Username!"; $referer = '../register.php';
} else if(emailInUse($email)){
  $_SESSION['error_messages'][] = "Email address already in use!"; $referer = '../register.php';
} else if($confirmPassword != $password){
  $_SESSION['error_messages'][] = "Password and Confirm Password not match!"; $referer = '../register.php';
} else {
  newUser($username, $password, $email);
  $_SESSION['success_messages'][] = "Register Sucessful!";
  $referer = '../index.php';
}

header('Location: ' . $referer);
?>
