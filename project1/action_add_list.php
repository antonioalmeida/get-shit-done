<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');

$username = antonioalmeida;
$title = (string) $_GET["title"];
$creationDate = "now";
$category = $_GET["category"];
$color = $_GET["color"];

//addList(antonioalmeida, "Viver em casa dos pais", "now", 0, ff0000);

addList(antonioalmeida, $title, $creationDate, 0, ff0000);

if (isset($_SERVER['HTTP_REFERER'])){
  $referer = $_SERVER['HTTP_REFERER'];
} else{
  $referer = 'index.php';
}

header('Location: ' . $referer);

?>
