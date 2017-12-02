<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

//TODO: add username and list validation
if ( !preg_match ("/^\d+$/", $_GET['itemID'])) {
  die("ERROR: itemID ");
}
if ( !preg_match ("/^0|1$/", $_GET['complete'])) {
  die("ERROR: Complete ");
}

$itemID = $_GET["itemID"];
$complete = $_GET["complete"];

setItemComplete($itemID, $complete);
?>
