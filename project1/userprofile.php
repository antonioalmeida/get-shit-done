<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');

$isLoggedIn = (isset($_SESSION['username']));
if(!$isLoggedIn){
    header('Location: ' . './index.php');
}

if ( !preg_match ("/^[a-zA-Z][\w-]{1,18}(?![-_])\w$/", $_GET['username'])) {
    die("ERROR: Username invalid");
}

if($_SESSION['username'] == $_GET['username']) {
    header('Location: ' . './myprofile.php');
}

include_once('templates/common/header.php');
include_once('templates/common/navbar.php');
include_once('templates/common/alerts.php');

$username = $_GET['username'];
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
  </div>
</div>

<div>
  <h4>Shit <?=$username?> Has To Do</h4>
  <div>
    <?php if(sizeof($assignedItems) > 0) {

      foreach ($assignedItems as $item) {
          $currentItemListInfo = getListInfoFromItem($item['id']);?>
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
            <?php $isCurrentListAdmin = isAdmin($_SESSION['username'], $currentItemListInfo['id']); ?>
            <!--    TODO: Ternary below not working properly    -->
            <p><strong>Part of </strong><a href=<?php ($isCurrentListAdmin ? "/list.php?id=".$currentItemListInfo['id'] : "#")?>><?=$currentItemListInfo['title']?></a></p>
            <p><strong>Owned by </strong><?=$_SESSION['username'] == $currentItemListInfo['creator'] ? 'you' : $currentItemListInfo['creator']?></p>
          </div>
        </div>
        <?php }
      } else { ?>
      <h6><?=$username?> doesn't have shit to do!</h6>
      <?php } ?>

    </div>
  </div>
</div>


<?php
include_once('templates/common/footer.php');
?>
