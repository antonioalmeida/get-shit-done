<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');

$isLoggedIn = (isset($_SESSION['username']));
if(!$isLoggedIn){
  header('Location: ' . './index.php');
}

include_once('templates/common/header.php');
include_once('templates/common/navbar.php');
include_once('templates/common/alerts.php');

$username = $_SESSION['username'];
$user = getUser($username);
$assignedItems = getUserAssignedItems($username);
?>

<div class="container">
  <div class="flex-container">
   <div id="profile-pic">
     <img width="100%" src="<?= $user['picture'] ?>" alt="">
   </div>

   <div id="profile-info">
     <h4><strong>
      <?=$user['name'] ?> </strong>
      <br>
      <small>@<?=$user['username'] ?></small>
    </h4>
    <p><?=$user['bio'] ?></p>
    <a class="button button-primary" href="./edit-profile.php">Edit</a>
    <a class="button" href="./actions/action_logout.php">Logout</a>
  </div>
</div>

<div>
  <h4>Shit To Do</h4>
  <div>
    <?php if(sizeof($assignedItems) > 0) { ?>

    <div class="assigned-header flex-container">
      <p>Description</p>
      <p>Due Date</p>
      <p>Priority</p>
      <p>List</p>
      <p>Owner</p>
    </div>

    <?php 
      foreach ($assignedItems as $item) {
        $currentItemListInfo = getListInfoFromItem($item['id']);
        if($item['complete'] == 1) {
          continue;
        }?>
        <div class="assigned-items flex-container">
          <div>
            <p><?= $item['description']?></p>
          </div>
          <div>
            <p>
              <?= date('d M', strtotime($item['dueDate']))?></p>
            </div>
            <div>
              <p>
                <?php switch ($item['priority']) {
                  case 1: ?>
                  <span id="item<?=$item['id']?>priority" class="itemPriority priority-low">Low</span>
                  <?php
                  break;
                  case 2:  ?>
                  <span id="item<?=$item['id']?>priority" class="itemPriority priority-medium">Med</span>
                  <?php
                  break;
                  case 3: ?>
                  <span id="item<?=$item['id']?>priority" class="itemPriority priority-high">High</span>
                  <?php
                  break;
                } ?>
              </p>
            </div>
            <div>
              <p><a href="./list.php?id=<?=$currentItemListInfo['id']?>"><?=$currentItemListInfo['title']?></a></p>
            </div>
            <div>
              <p><?=$_SESSION['username'] == $currentItemListInfo['creator'] ? 'you' : $currentItemListInfo['creator']?></p>
            </div>
          </div>
          <?php }
        } else { ?>
        <h6>You don't have shit to do, congrats!</h6>
        <?php } ?>

      </div>
    </div>
  </div>


  <?php
  include_once('templates/common/footer.php');
  ?>
