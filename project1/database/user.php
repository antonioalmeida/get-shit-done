<?php
  function isLoginCorrect($username, $password) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM User WHERE username = ?');
    $stmt->execute(array($username));
    $user = $stmt->fetch();
    return ($user !== false && password_verify($password, $user['password']));
  }

  function usernameExists($username){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM User where username = ?');
    $stmt->execute(array($username));
    return ($stmt->fetch() !== false);
}

function emailInUse($email){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM User where email = ?');
    $stmt->execute(array($email));
    return ($stmt->fetch() !== false);
}

function newUser($username, $password, $email){
    global $dbh;
    $options = ['cost' => 12];
    $stmt = $dbh->prepare('INSERT INTO User (userName, password, email) values(?, ?, ?)');
    $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT, $options), $email));
}

function getUser($username) {
  global $dbh;
  $stmt = $dbh->prepare('SELECT * FROM User WHERE userName = ?');
  $stmt->execute(array($username));
  return $stmt->fetch();
}

function updateUser($username, $picture,$name, $bio) {
  global $dbh;
  $stmt = $dbh->prepare('UPDATE User SET picture = ?, name = ?, bio = ? WHERE username = ?');
  $stmt->execute(array($picture, $name, $bio, $username));
}

?>
