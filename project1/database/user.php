<?php
  function isLoginCorrect($username, $password) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM User WHERE username = ? AND password = ?');
    $stmt->execute(array($username, sha1($password)));
    return $stmt->fetch() !== false;
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

function newUser($username, $password, $firstName, $lastName, $email){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO User (userName, password, firstName, lastName, email) values(?, ?, ?, ?, ?)');
    $stmt->execute(array($username, sha1($password), $firstName, $lastName, $email));
}


?>
