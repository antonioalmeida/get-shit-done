<?php
include_once('includes/init.php');
include_once('database/user.php');

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

if($confirmPassword != $password)
  echo 'Password and confirmPassword not match!';

if (usernameExists($username)) {
  echo "Invalid Username!";
} else if(emailInUse($email)){
  echo "Email address already in use!";
} else{
  newUser($username, $password, $email);
}

if (isset($_SERVER['HTTP_REFERER'])){
  $referer = $_SERVER['HTTP_REFERER'];
} else{
  $referer = 'index.php';
}

header('Location: ' . $referer);
?>
