<?php
include_once('includes/init.php');
include_once('database/user.php');


$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

if($confirmPassword != $password)
  echo 'Password and confirmPassword not match!';

if (usernameExists($username)) {
  echo "Invalid Username!";
} else if(emailInUse($email)){
  echo "Email address already in use!";
} else{
  newUser($username, $password, $firstName, $lastName, $email);
  session_start();
  setCurrentUser($username);
}

if (isset($_SERVER['HTTP_REFERER'])){
  $referer = $_SERVER['HTTP_REFERER'];
} else{
  $referer = 'index.php';
}

header('Location: ' . $referer);
?>
