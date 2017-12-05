<?php

function getUserLists($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT List.id as listId, List.title as listName, List.creationDate as creationDate, Category.name as categoryName, Color.code as categoryColor from List, Category, Color where List.creator == ? and List.category == Category.id and Category.color == Color.Code;');
    $stmt->execute(array($username));
    return $stmt->fetchAll();
}

function getUserSharedLists($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT Category.name as categoryName, Category.color as categoryColor, List.id as listId, List.title as listName, List.creationDate as creadtionDate from Category, List, ListAdmin where List.id = ListAdmin.list and ListAdmin.user = ? and List.creator <> ? and List.category = Category.id');
    $stmt->execute(array($username, $username));
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

    try {
        $stmt->execute(array($title, $creationDate, $category, $username));
    } catch (Exception $e) {
        print_r($e->errorInfo);
        return;
    }
    // return added list as JSON
    $newList = getLastList($username);
    echo json_encode($newList);
}

function listAddAdmin($listID, $username) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO ListAdmin values(?, ?)');

    try {
        $stmt->execute(array($listID, $username));
    } catch (Exception $e) {
        print_r($e->errorInfo);
        return;
    }
    // return username in case of success
    echo $username; 
}

function getListAdmins($listID) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT User FROM ListAdmin WHERE List = ?');
    $stmt->execute(array($listID));
    return $stmt->fetchAll();
}

function addItem($id_list, $description, $dueDate, $color) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Item (description, dueDate, Color, list) values(?, ?, ?, ?)');

    try {
        $stmt->execute(array($description, $dueDate, $color, $id_list));
    } catch (Exception $e) {
        print_r($e->errorInfo);
        return;
    }
    // return added list as JSON
    $newItem = getLastItem($id_list);
    echo json_encode($newItem);
}

function getLastList($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT List.id, List.title, List.creationDate, Category.name, Category.color FROM List, Category, User WHERE List.creator == ? AND List.category = Category.id ORDER BY List.id DESC LIMIT 1');
    $stmt->execute(array($username));
    return $stmt->fetch();
}

function getLastItem($id_list) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM Item WHERE list == ? ORDER BY Item.id DESC LIMIT 1');
    $stmt->execute(array($id_list));
    return $stmt->fetch();
}

function getItem($itemID) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM Item WHERE id == ?');
    $stmt->execute(array($itemID));
    return $stmt->fetch();
}

function deleteItem($itemID) {
    global $dbh;
    $stmt = $dbh->prepare('DELETE FROM Item WHERE id == ?');

    try {
        $stmt->execute(array($itemID));
        return true;
    }
    catch (Exception $e) {
        return false;
    }
}

function getUserList($username, $id) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM List WHERE creator = ? AND id =?');
    $stmt->execute(array($username,$id));
    return $stmt->fetch();
}

function getAdminList($id) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM List WHERE creator = ? AND id =?');
    $stmt->execute(array($username,$id));
    return $stmt->fetch();
}

function getListItems($listId) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM Item WHERE list = ?');
    $stmt->execute(array($listId));
    return $stmt->fetchAll();
}

function setItemComplete($itemID, $value) {
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Item SET complete = ? WHERE Item.id = ?;');
    $stmt->execute(array($value, $itemID));

    $newItem = getItem($itemID);
    echo json_encode($newItem);
}

function editItem($itemID, $description, $dueDate) {
    global $dbh;
    //TODO: add update due date 
    $stmt = $dbh->prepare('UPDATE Item SET description = ?, dueDate = ? WHERE Item.id = ?;');
    $stmt->execute(array($description, $dueDate, $itemID));

    $newItem = getItem($itemID);
    echo json_encode($newItem);
}

function itemAssignUser($itemID, $assignedUser) {
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Item SET assignedUser = ? WHERE Item.id = ?;');
    $stmt->execute(array($assignedUser, $itemID));

    $newItem = getItem($itemID);
    echo json_encode($newItem);
}

function isItemAdmin($username, $itemID) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM Item, List, ListAdmin WHERE Item.id = ? AND Item.list = List.id AND List.Id = ListAdmin.list AND ListAdmin.user = ?');
    $stmt->execute(array($itemID, $username));
    return ($stmt->fetch() !== false);
}

function deleteList($listId) {
    global $dbh;
    $stmt = $dbh->prepare('DELETE from List where List.id == ?;');

    try {
        $stmt->execute(array($listId));
        return true;
    }
    catch (Exception $e) {
        return false;
    }
}

function getUserCategories($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT id, name, color from category where user is null union select id, name, color from category where user = ?;');
    $stmt->execute(array($username));
    return $stmt->fetchAll();
}

function getUserSharedCategories($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT Category.id as id, Category.name as name, Category.color as color from List, ListAdmin, Category where List.id = ListAdmin.list and ListAdmin.user = ? and List.creator <> ? and List.category = Category.id');
    $stmt->execute(array($username, $username));
    return $stmt->fetchAll();
}

function getUserAssignedItems($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT Item.description as description, Item.complete as complete, Item.dueDate as dueDate, Item.color as color FROM Item WHERE Item.assignedUser = ?');
    $stmt->execute(array($username));
    return $stmt->fetchAll();
}

?>
