<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

if ( !preg_match ("/^[a-zA-Z][\w-]{1,18}(?![-_])\w$/", $_POST['username'])) {
  die("ERROR: Username invalid");
}
// if ( !preg_match ("/^https?://(?:[a-z-]+.)+[a-z]{2,6}(?:/[^/#?]+)+.(?:jpe?g|gif|png)$/", $_POST['picture'])) {
//   die("ERROR: Picture URL invalid");
// }
if ( !preg_match ("/^[a-zA-Z ]+$/", $_POST['name'])) {
  die("ERROR: Name can only contain space and letters");
}

if ( !preg_match ("/^[\w\s-?!\.()]*$/", $_POST['bio'])) {
  die("ERROR: Bio can only generic text");
}

try {
  updateUser($_POST['username'], $_POST['picture'], $_POST['name'], $_POST['bio']);
} catch (PDOException $e) {
  die($e->getMessage());
}

$referer = '../myprofile.php';
header('Location: ' . $referer);
?>
