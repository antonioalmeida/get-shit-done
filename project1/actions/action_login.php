<?php
include_once(dirname(__DIR__) . '/includes/init.php');
include_once(dirname(__DIR__) . '/database/user.php');

if ( !preg_match ("/^[a-zA-Z][\w-]{1,18}(?![-_])\w$/", $_POST['username'])) {
  die("ERROR: Username invalid");
}
// if ( !preg_match ("/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[&quot;-_?!@#+*$%&\/\(\)=])[&quot;\w\-?!@#+*$%&\/\(\)=]{8,32}$/", $_POST['password'])) {
//   die("ERROR: password");
// }

  if (isLoginCorrect($_POST['username'], $_POST['password'])) {
    setCurrentUser($_POST['username']);
    $_SESSION['success_messages'][] = "Login Successful!";
    $referer = '../mylists.php';
  } else {
    $_SESSION['error_messages'][] = "Login Failed!";
    $referer = '../login.php';
  }

  header('Location: ' . $referer);
?>
