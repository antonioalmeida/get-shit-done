<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

$isLoggedIn = (isset($_SESSION['username']));
if(!$isLoggedIn){
    header('Location: ' . '../404.php');
}
$username = $_SESSION['username'];

if ( !preg_match ("/^[\w\s-?!\.()]*$/", $_GET['categoryName'])) {
  die("ERROR: categoryName can only contain letters, numbers and most common punctuaction");
}

if ( !preg_match ("/^#?[a-f0-9]{6}$/i", $_GET['categoryColor'])) {
  die("ERROR: categoryColor can only contain hexadecimal values");
}

if ($_SESSION['csrf'] !== $_GET['csrf']){
    die("ERROR: Request does not appear to be legitimate");
}

$categoryName = $_GET["categoryName"];
$categoryColor = $_GET["categoryColor"];

addCategory($username, $categoryName, $categoryColor)
?>
