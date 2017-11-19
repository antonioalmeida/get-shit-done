<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];

$title = (string) $_GET["title"];
$creationDate = "now";
$category = $_GET["category"];

addList($username, $title, $creationDate, $category);
?>
