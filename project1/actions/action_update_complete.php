<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

//TODO: add username and list validation

$itemID = $_GET["itemID"];
$complete = $_GET["complete"];

setItemComplete($itemID, $complete);
?>
