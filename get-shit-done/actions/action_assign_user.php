<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

if(!isset($_SESSION['username'])) {
	    header('Location: ' . '../404.php');
}
	$username = $_SESSION['username'];

	if ( !preg_match ("/^\d+$/", $_GET['itemID'])) {
		die("ERROR: itemID can only contain numbers");
	}
	if ( !preg_match ("/^$|^[a-zA-Z][\w-]{1,18}(?![-_])\w$/", $_GET['assignedUser'])) {
		die("ERROR: Username invalid");
	}

	$itemID = $_GET["itemID"];
	$assignedUser = $_GET["assignedUser"];

	if (isItemAdmin($username, $itemID))
		itemAssignUser($itemID, $assignedUser);

?>
