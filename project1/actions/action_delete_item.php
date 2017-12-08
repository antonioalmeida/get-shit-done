<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    if (!preg_match("/^\d+$/", $_GET['id'])) {
        die("ERROR: ID can only contain numbers");
    }

    $itemID = $_GET["id"];

    if (isItemAdmin($username, $itemID))
        $hasDeleted = deleteItem($itemID);

    if ($hasDeleted)
        echo $itemID;
    else
        echo -1;
} else
    echo -1;

?>
