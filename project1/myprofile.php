<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');
include_once('templates/common/header.php');
include_once('templates/common/navbar.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];
$user = getUser($username);
$assignedItems = getUserAssignedItems($username);
?>

<div class="container">
  <div class="flex-container">
   <div id="profile-pic">
     <img width="60%" src="/assets/img/sample-logo.png" alt="">
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
    <?php foreach ($assignedItems as $item) { ?>
    <div class="assigned-item">
      <p><?= $item['description']?></p>
      <p><?= $item['dueDate']?></p>
      <p><?= $item['color']?></p>
    </div>
    <?php } ?>

  </div>
</div>
</div>


<?php
include_once('templates/common/footer.php');
?>
