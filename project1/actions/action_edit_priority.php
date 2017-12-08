<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

//TODO: add username and list validation
if (!preg_match("/^\d+$/", $_GET['itemID'])) {
    die("ERROR: itemID ");
}
if (!preg_match("/^1|2|3$/", $_GET['priority'])) {
    die("ERROR: priority ");
}

$itemID = $_GET["itemID"];
$priority = $_GET["priority"];

updateItemPriority($itemID, $priority);
?>
