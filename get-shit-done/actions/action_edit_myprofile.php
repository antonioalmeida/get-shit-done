<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

if(!isset($_SESSION['username'])) {
	    header('Location: ' . '../404.php');
}

if ( !preg_match ("/^[a-zA-Z][\w-]{1,18}(?![-_])\w$/", $_POST['username'])) {
  die("ERROR: Username invalid");
}

if ( !preg_match ("/^[a-zA-Z ]+$/", $_POST['name'])) {
  die("ERROR: Name can only contain space and letters");
}

if ( !preg_match ("/^[\w\s-?!\.()]*$/", $_POST['bio'])) {
  die("ERROR: Bio can only generic text");
}

if(updateUser($_POST['username'], $_POST['name'], $_POST['bio'])){
	$_SESSION['success_messages'][] = "User updated!";
} else {
	$_SESSION['error_messages'][] = "Error updating user!";
}

$referer = '../myprofile.php';
header('Location: ' . $referer);
?>
