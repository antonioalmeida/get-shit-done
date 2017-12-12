<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

if(!isset($_SESSION['username'])) {
	    header('Location: ' . '../404.php');
}

if ( !preg_match ("/^[a-zA-Z][\w-]{1,18}(?![-_])\w$/", $_POST['username'])) {
  die("ERROR: Username invalid");
}

if ( !preg_match ("/^https?:\/\/(?:[a-z-]+.)+[a-z]{2,6}(?:\/[^\#?]+)+.(?:jpe?g|gif|png)$/", $_POST['picture'])) {
   die("ERROR: Picture URL invalid");
}

//$encode_data = base64_encode(file_get_contents($_POST['picture']));
//$original_image = "data:image/png;base64,$encode_data";
$temp_image = imagecreatefromstring(file_get_contents($_POST['picture']));

$max_width = 500;
$max_height = 500;
$quality = 100; //The quality of your new image
list($width, $height) = getimagesize($_POST['picture']);

$new_width = $height * $max_width/$max_height;
$new_height = $width * $max_height/$max_width;

//if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
$new_image = imagecreatetruecolor($max_width, $max_height);
if($new_width > $width) {
	$h_point = (($height - $new_height) / 2);
	imagecopyresampled($new_image, $temp_image, 0, 0, 0, $h_point, $max_width, $max_height, $width, $new_width);
} else {
	$w_point = (($width - $new_width) / 2);
	imagecopyresampled($new_image, $temp_image, 0, 0, $w_point, 0, $max_width, $max_height, $new_width, $height);
}

ob_start();
imagepng($new_image);
$contents =  ob_get_contents();
ob_end_clean();

$final_encoding = base64_encode($contents);
$final_image = "data:image/png;base64,$final_encoding";

try {
  if(updatePictureUser($_POST['username'], $final_image))
  	$_SESSION['success_messages'][] = "Image updated!";
  else
    $_SESSION['error_messages'][] = "Error updating image!";
} catch (PDOException $e) {
  die($e->getMessage());
}

$referer = '../myprofile.php';
header('Location: ' . $referer);
?>
