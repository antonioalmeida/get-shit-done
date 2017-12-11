<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');
include_once('templates/common/header.php');
include_once('templates/common/navbar.php');
include_once('templates/common/alerts.php');

$isLoggedIn = (isset($_SESSION['username']));
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
     <?php if ($isLoggedIn) { ?>

     <h4><strong>
      <?=$user['name'] ?> </strong>
      <br>
      <small>@<?=$user['username'] ?></small>
    </h4>
    <p><?=$user['bio'] ?></p>
    <a class="button button-primary" href="./edit-profile.php">Edit</a>
    <a class="button" href="./actions/action_logout.php">Logout</a>

    <?php } else { ?>
    <!-- else here -->
    <?php } ?>
  </div>
</div>

<div>
  <h4>Shit To Do</h4>
  <div>
    <?php if(sizeof($assignedItems) > 0) {

      foreach ($assignedItems as $item) { ?>
      <div class="assigned-item flex-container">
        <div>
          <p><?= $item['description']?></p>
        </div>
        <div>
          <p><strong>Due </strong>
            <?= date('d M', strtotime($item['dueDate']))?></p>
          </div>
          <div>
            <p><strong>Priority </strong>
              <?php switch ($item['priority']) {
                case 1: ?>
                <span id="item<?=$item['id']?>priority" onclick="updateItemPriority(this)" class="itemPriority priority-low">Low</span>
                <?php
                break;
                case 2:  ?>
                <span id="item<?=$item['id']?>priority" onclick="updateItemPriority(this)" class="itemPriority priority-medium">Med</span>
                <?php
                break;
                case 3: ?>
                <span id="item<?=$item['id']?>priority" onclick="updateItemPriority(this)" class="itemPriority priority-high">High</span> 
                <?php
                break;
              } ?>
            </p>
          </div>
          <div>
            <p><strong>Part of </strong> LIST NAME</p>
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
