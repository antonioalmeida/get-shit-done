<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];

	if ( !preg_match ("/^\d+$/", $_GET['itemID'])) {
		die("ERROR: ID can only contain numbers");
	}
	if ( !preg_match ("/^[\w\s-?!\.()]*$/", $_GET['description'])) {
	  die("ERROR: description can only contain letters, numbers and most common punctuaction");
	}
	if ( !preg_match ("/^\d\d\d\d-\d{1,2}-\d{1,2}$/", $_GET['dueDate'])) {
	  die("ERROR: Date invalid");
	}
	$itemID = $_GET["itemID"];
	$description = $_GET["description"];
	$dueDate = $_GET["dueDate"];

	if (isItemAdmin($username, $itemID))
		editItem($itemID, $description, $dueDate);
}
?>
