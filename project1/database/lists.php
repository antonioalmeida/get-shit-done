<?php

function getUserLists($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM List WHERE creator = ?');
    $stmt->execute(array($username));
    return $stmt->fetchAll();
}

function isAdmin($username, $listID) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT user FROM List, ListAdmin WHERE user = ? AND ListAdmin.list = ?');
    $stmt->execute(array($username, $listID));
    return ($stmt->fetch() !== false);
}

function addList($username, $title, $creationDate, $category, $color) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO List (title, creationDate, category, Color, creator) values(?, ?, ?, ?, ?)');
    $stmt->execute(array($title, $creationDate, $category, $color, $username));  
}

function addItem($id_list, $username, $description, $dueDate, $color) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Item (description, dueDate, Color, list) values(?, ?, ?, ?)');
    $stmt->execute(array($description, $dueDate, $color, $id_list));      
}

?>