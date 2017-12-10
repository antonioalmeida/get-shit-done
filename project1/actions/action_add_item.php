<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];

if ( !preg_match ("/^\d+$/", $_GET['id'])) {
  die("ERROR: ID can only contain numbers");
}

if ( !preg_match ("/^[\w\s-?!\.()]*$/", $_GET['description'])) {
  die("ERROR: categoryName can only contain letters, numbers and most common punctuaction");
}

if ( !preg_match ("/^\d\d\d\d-\d{1,2}-\d{1,2}$/", $_GET['dueDate'])) {
  die("ERROR: dueDate can only contain a date on format yyyy-mm-dd");
}

$id_list = $_GET["id"];
$description = (string) $_GET["description"];
$dueDate = $_GET['dueDate'];

addItem($id_list, $description, $dueDate);
?>
