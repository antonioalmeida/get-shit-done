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

function addList($username, $title, $creationDate, $category) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO List (title, creationDate, category, creator) values(?, ?, ?, ?)');
    $stmt->execute(array($title, $creationDate, $category, $username));  

    // return added list as JSON
    $newList = getLastList($username);
    echo json_encode($newList);
}

function addItem($id_list, $username, $description, $dueDate, $color) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Item (description, dueDate, Color, list) values(?, ?, ?, ?)');
    $stmt->execute(array($description, $dueDate, $color, $id_list));
}

function getLastList($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT List.id, List.title, List.creationDate, List.category FROM List, User WHERE List.creator == ? ORDER BY List.id DESC LIMIT 1'); 
    $stmt->execute(array($username));
    return $stmt->fetch();
}
?>