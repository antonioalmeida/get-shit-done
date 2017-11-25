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

<script type="text/javascript" src="scripts/items.js" defer></script>

<div class="container">
    <?php if ($isLoggedIn) { ?>
    <h4>
        <?=$list['title']?>
    </h4>
    <h6>Created on <?=$list['creationDate']?></h6>

    <?php } else { ?>
    <!-- else here -->
    <?php } ?>
    <div class="items" >


    <?php foreach($items as $item) { ?>
    <div class="item">
    <input type="checkbox" name="complete">
        <span><?=$item['description']?></span>
        <span><?=$item['dueDate']?></span>
    </div>
    <?php } ?>
    </div>
    <div class="item">
      <span><i class="fa fa-plus"></i> Add a Task</span>
      <div>
          <form id="addItemForm">
              <div>
                <input type="hidden" name="id" value="<?=$list['id']?>">
                  <div class="form-element">
                      <input type="text" name="description" required>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <label>Description</label>
                  </div>
              </div>
              <div>
                  <input class="button-primary" type="submit" value="Add">
              </div>
          </form>
      </div>
    </div>

</div>

<?php
include('templates/common/footer.php');
?>
