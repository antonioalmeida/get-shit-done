<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/lists.php');

if(!isset($_SESSION['username'])) {
			echo -1;
	    header('Location: ' . '../404.php');
}

	$username = $_SESSION['username'];

	if ( !preg_match ("/^\d+$/", $_GET['listID'])) {
	  die("ERROR: listID can only contain numbers");
	}

	if ($_SESSION['csrf'] !== $_GET['csrf']){
	    die("ERROR: Request does not appear to be legitimate");
	}

	$listID = $_GET["listID"];

	if (isAdmin($username, $listID))
		$hasDeleted = deleteList($listID);

	if($hasDeleted)
		echo $listID;
	else
		echo -1;
?>
