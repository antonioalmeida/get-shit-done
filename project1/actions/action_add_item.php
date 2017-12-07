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
  die("ERROR: ID can only contain numbers");
}

//TODO add regex for date verification

$id_list = $_GET["id"];
$description = (string) $_GET["description"];
$dueDate = $_GET['dueDate'];

if (addItem($id_list, $description, $dueDate))
    $_SESSION['success_messages'][] = "Item added!";
else
    $_SESSION['error_messages'][] = "Error adding Item";
?>
