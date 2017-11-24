<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');
include_once('templates/common/header.php');

include_once('templates/common/navbar.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];
$user = getUser($username);

if (!isset($_GET['id']))
    die("No id!");

$listID = $_GET['id'];
$list = getUserList($user['username'], $listID);
$items = getListItems($listID);
?>

<div class="container">
    <?php if ($isLoggedIn) { ?>
    <h4>
        <?=$list['title']?>
    </h4>
    <h6>Created on <?=$list['creationDate']?></h6>

    <?php } else { ?>
    <!-- else here -->
    <?php } ?>

    <?php foreach($items as $item) { ?>
        <p><?=$item['description']?></p>
        <p><?=$item['dueDate']?></p>
        <p>Complete: <?=$item['complete']?></p>
        <br><br>
    <?php } ?>

</div>

<?php
include('templates/common/footer.php');
?>
