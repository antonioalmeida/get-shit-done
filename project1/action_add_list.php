<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');
/*
$username = $_POST["username"];
$title = $_POST["title"];
$creationDate = "now";
$category = $_POST["category"];
$color = $_POST["color"];

if($confirmPassword != $password)
  echo 'Password and confirmPassword not match!';

*/
addList(antonioalmeida, "Viver em casa dos pais", "now", 0, 0xff0000);

if (isset($_SERVER['HTTP_REFERER'])){
  $referer = $_SERVER['HTTP_REFERER'];
} else{
  $referer = 'index.php';
}

header('Location: ' . $referer);
?>
