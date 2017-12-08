<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

if ( !preg_match ("/^[a-zA-Z][\w-]{1,18}(?![-_])\w$/", $_POST['username'])) {
  die("ERROR: Username invalid");
}

if ( !preg_match ("/^https?:\/\/(?:[a-z-]+.)+[a-z]{2,6}(?:\/[^\#?]+)+.(?:jpe?g|gif|png)$/", $_POST['picture'])) {
   die("ERROR: Picture URL invalid");
}

$encode_data = base64_encode(file_get_contents($_POST['picture']));

$picture = "data:image/png;base64,$encode_data";

try {
  updatePictureUser($_POST['username'], $picture);
} catch (PDOException $e) {
  die($e->getMessage());
}

$referer = '../myprofile.php';
header('Location: ' . $referer);
?>
