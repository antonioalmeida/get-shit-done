<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

if ( !preg_match ("/^[a-zA-Z][\w-]{1,18}(?![-_])\w$/", $_POST['username'])) {
  die("ERROR: Username invalid");
}

if ( !preg_match ("/^https?:\/\/(?:[a-z-]+.)+[a-z]{2,6}(?:\/[^\#?]+)+.(?:jpe?g|gif|png)$/", $_POST['picture'])) {
   die("ERROR: Picture URL invalid");
}

//$encode_data = base64_encode(file_get_contents($_POST['picture']));
//$original_image = "data:image/png;base64,$encode_data";
$temp_image = imagecreatefromstring(file_get_contents($_POST['picture']));

$new_width = 500; 
$new_height = 500; 
$quality = 100; //The quality of your new image
list($width, $height) = getimagesize($_POST['picture']);

$img_ratio = $width/$height;
if($width > $new_width || $height > $new_height) {
	if($new_width/$new_height > $img_ratio)
		$new_width = $new_height*$img_ratio;
	else 
		$new_height = $new_width/$img_ratio;
}

$new_image = imagecreatetruecolor($new_width, $new_height);
imagecopyresampled($new_image, $temp_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

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
