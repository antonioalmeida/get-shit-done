<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

if ( !preg_match ("/^\d+$/", $_GET['itemID'])) {
  die("ERROR: itemID can only contain numbers ");
}
if ( !preg_match ("/^0|1$/", $_GET['complete'])) {
  die("ERROR: Complete invalid ");
}

if(!(isset($_SESSION['username']) && isItemAdmin($_SESSION['username'], $_GET['itemID']))) {
    die("ERROR: You can't perform this operation");
}

$itemID = $_GET["itemID"];
$complete = $_GET["complete"];

setItemComplete($itemID, $complete);
?>
