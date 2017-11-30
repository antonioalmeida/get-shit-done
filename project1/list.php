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

  <div class="flex-container">
    <div class="sidebar">
      <p>Future Sidebar</p> 
    </div>

    <div class="items">
      <?php if ($isLoggedIn) { ?>
      <h4>
        <?=$list['title']?>
      </h4>
      <h6>Created on <?=$list['creationDate']?></h6>

      <?php } else { ?>
      <!-- else here -->
      <?php } ?>
      <?php foreach($items as $item) { ?>
      <div class="item" id="item<?=$item['id']?>">
        <div class="item-left">
          <input type="checkbox" id="<?=$item['id']?>" name="complete" 
          <?php if($item['complete'] == 1) { ?> 
          checked
          <?php } ?>
          >
          <span><?=$item['description']?></span>
          <span><?= date('d M', strtotime($item['dueDate']))?></span>
        </div>

        <div class="item-edit hidden">
          <form>
            <div class="flex">
              <input type="hidden" name="id" value="<?=$listID?>">
              <div class="form-element">
                <input type="text" name="editDescription" value="<?=$item['description']?>" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Description</label>
              </div>
              <div>
                <p>Due Date</p>
                <input type="date" name="editDate" value="" required>
              </div>
            </div>
            <div>
              <input class="button-primary" type="submit" value="Save">
              <input class="button cancelEditItem" value="Cancel">
            </div>
          </form>
        </div>

        <div class="item-right">
          <span><i id="assignUser<?=$item['id']?>" class="fa fa-user-plus"></i></span>
          <span><i id="edit<?=$item['id']?>" class="fa fa-pencil-square-o"></i></span>
          <span><i id="delete<?=$item['id']?>" class="fa fa-trash"></i></span>
        </div>
      </div>
      <?php } ?>

      <div class="add-item">
        <a href="#" id="showAddItem"><i class="fa fa-plus"></i> Add a Task</a>
        <div>
          <form class="hidden" id="addItemForm">
            <div>
              <input type="hidden" name="id" value="<?=$listID?>">
              <br>
              <div class="form-element">
                <input type="text" name="description" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Description</label>
              </div>
            </div>
            <div>
              <input class="button-primary" type="submit" value="Add">
              <input id="cancelAddItem" class="button" value="Cancel">
            </div>
          </form>
        </div>
      </div>
    </div>

  </div> <!-- end .items -->

</div>

<?php
include('templates/common/footer.php');
?>
