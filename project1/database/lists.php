<?php

function getUserLists($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT List.id as listId, List.title as listName, List.creationDate as creationDate, Category.name as categoryName, Category.color as categoryColor from List, Category where List.creator == ? and List.category == Category.id');
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
        echo json_encode($e->errorInfo[2]);
        return false;
    }
    // return added list as JSON
    $newList = getLastList($username);
    echo json_encode($newList);
    return true;
}

function getListInfoFromItem($itemID) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT List.title as title, List.creator as creator from Item, List where Item.id = ? and Item.list = List.id');
    $stmt->execute(array($itemID));
    return $stmt->fetch();
}

function listAddAdmin($listID, $username) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO ListAdmin values(?, ?)');
    $response['username'] = $username;

    try {
        $stmt->execute(array($listID, $username));
    } catch (Exception $e) {
        $response['result'] = 'error';
        echo json_encode(array('error', $username));
        return;
    }

    // return username in case of success
    $response['result'] = 'success';
    $response['profilePic'] = getUserPicture($username);
    echo json_encode($response);
}

function getListAdmins($listID) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT User.username, User.picture FROM User, ListAdmin WHERE List = ? AND ListAdmin.user = User.username');
    $stmt->execute(array($listID));
    return $stmt->fetchAll();
}

function addItem($id_list, $description, $dueDate) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Item (description, dueDate, list) values(?, ?, ?)');

    try {
        $stmt->execute(array($description, $dueDate, $id_list));
    } catch (Exception $e) {
        echo json_encode($e->errorInfo[2]);
        return false;
    }

    // return added list as JSON
    $newItem = getLastItem($id_list);
    $admins = getListAdmins($id_list);
    $newItem['admins']=$admins;
    echo json_encode($newItem);
    return true;
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

function getList($id) {
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
    $stmt = $dbh->prepare("SELECT Item.id as id, Item.complete as complete, Item.assignedUser as assignedUser, Item.priority as priority, Item.dueDate as dueDate, Item.description as description, User.picture as userImage
                            FROM Item, User
                            WHERE list = ? AND User.username = Item.assignedUser
                            union all
                            SELECT Item.id as id, Item.complete as complete, '' as assignedUser, Item.priority as priority, Item.dueDate as dueDate, Item.description as description, '' as userImage
                            from Item
                            where list = ? AND assignedUser IS NULL;");
    $stmt->execute(array($listId, $listId));
    return $stmt->fetchAll();
}

function setItemComplete($itemID, $value) {
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Item SET complete = ? WHERE Item.id = ?;');

    try {
        $stmt->execute(array($value, $itemID));
    } catch (Exception $e) {
        echo json_encode($e->errorInfo[2]);
        return false;
    }

    $newItem = getItem($itemID);
    echo json_encode($newItem);
    return true;
}

function editItem($itemID, $description, $dueDate) {
    global $dbh;
    //TODO: add update due date
    $stmt = $dbh->prepare('UPDATE Item SET description = ?, dueDate = ? WHERE Item.id = ?;');

    try {
        $stmt->execute(array($description, $dueDate, $itemID));
    } catch (Exception $e) {
        echo json_encode($e->errorInfo[2]);
        return false;
    }

    $newItem = getItem($itemID);
    echo json_encode($newItem);
}

function itemAssignUser($itemID, $assignedUser) {
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Item SET assignedUser = ? WHERE Item.id = ?;');

    try {
      $stmt->execute(array($assignedUser, $itemID));
    } catch (Exception $e) {
        $response['result'] = 'error';
        $response['message'] = $e->errorInfo[2];
        echo json_encode($response);
        return false;
    }

    $response['result'] = 'success';
    $response['item'] = getItem($itemID);
    $response['profilePic'] = getUserPicture($assignedUser);
    echo json_encode($response);
    return true;
}

function isItemAdmin($username, $itemID) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM Item, List, ListAdmin WHERE Item.id = ? AND Item.list = List.id AND List.Id = ListAdmin.list AND ListAdmin.user = ?');
    $stmt->execute(array($itemID, $username));
    return ($stmt->fetch() !== false);
}

function updateItemPriority($itemID, $priority) {
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Item set priority = ? where Item.id = ?');

    try {
        $stmt->execute(array($priority, $itemID));
    } catch (Exception $e) {
        echo json_encode($e->errorInfo[2]);
        return false;
    }

    $newItem = getItem($itemID);
    echo json_encode($newItem);
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
    $stmt = $dbh->prepare('SELECT Item.id, Item.description as description, Item.complete as complete, Item.dueDate as dueDate, Item.priority as priority FROM Item WHERE Item.assignedUser = ?');
    $stmt->execute(array($username));
    return $stmt->fetchAll();
}

function addCategory($username, $name, $color) {
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Category (name, color, user) values(?, ?, ?)');

    try {
        $stmt->execute(array($name, $color, $username));
    } catch (Exception $e) {
        echo json_encode(array('error', $name));
        return false;
    }

    // return added list as JSON
    $newCategory = getLastCategory($username);
    echo json_encode($newCategory);
    return true;
}

function getLastCategory($username) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM Category WHERE Category.user = ? ORDER BY Category.id DESC LIMIT 1');
    $stmt->execute(array($username));
    return $stmt->fetch();
}
?>
