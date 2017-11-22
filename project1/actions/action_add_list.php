<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];

$title = (string) $_GET["title"];
$creationDate = date("d-m-Y");
$category = $_GET["category"];

addList($username, $title, $creationDate, $category);
?>
