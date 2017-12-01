<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');
include_once(dirname(__DIR__) . '/database/lists.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];

$id_list = $_GET["id"];
$description = (string) $_GET["description"];
$dueDate = date("Y-m-d");
// TODO: need to add actual color input ASAP
$color = 'ff0000';

addItem($id_list, $description, $dueDate, $color);
?>
