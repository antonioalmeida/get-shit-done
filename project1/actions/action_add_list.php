<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/init.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/database/user.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/database/lists.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];

$title = (string) $_GET["title"];
$creationDate = "now";
$category = $_GET["category"];

addList($username, $title, $creationDate, $category);
?>
