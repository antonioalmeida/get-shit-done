<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	$itemID = $_GET["id"];

	if (canDeleteItem($username, $itemID))
		$hasDeleted = deleteItem($itemID);

	if($hasDeleted)
		echo $itemID;
	else
		echo -1;
} else 
	echo -1;

?>
