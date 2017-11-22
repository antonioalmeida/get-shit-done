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

  $list = getUserList($user['username'],$_GET['id']);
  ?>

  <div class="container">

    <?php if ($isLoggedIn) { ?>

    <h4>
       <?=$list['title']?>
  </h4>

  <?php } else { ?>
  <!-- else here -->
  <?php } ?>

  <div class="flex-container">
    <div class="list">
        <p> <?=$list['creationDate']?></p>
        <p> <?=$list['category']?></p>
    </div>

  </div>

  </div>

<?php
  include('templates/common/footer.php');
?>
