<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	$itemID = $_GET["itemID"];
	$description = $_GET["description"];
	$dueDate = $_GET["dueDate"];

	if (isItemAdmin($username, $itemID))
		editItem($itemID, $description, $dueDate);
} 
?>
