<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];

//TODO: add regex verification for category name and category color

if ($_SESSION['csrf'] !== $_GET['csrf']){
    die("ERROR: Request does not appear to be legitimate");
}

$categoryName = $_GET["categoryName"];
$categoryColor = $_GET["categoryColor"];

addCategory($username, $categoryName, $categoryColor)
?>
