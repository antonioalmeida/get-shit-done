<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/lists.php');

if(!isset($_SESSION['username'])) {
	    header('Location: ' . '../404.php');
}

if ( !preg_match ("/^\d+$/", $_GET['itemID'])) {
  die("ERROR: itemID can only contains numbers");
}
if ( !preg_match ("/^1|2|3$/", $_GET['priority'])) {
    die("ERROR: priority can only contain letters, numbers and most common punctuaction");
}

if(!(isItemAdmin($_SESSION['username'], $_GET['itemID']))) {
    die("ERROR: You can't perform this operation");
}

$itemID = $_GET["itemID"];
$priority = $_GET["priority"];

updateItemPriority($itemID, $priority);
?>
