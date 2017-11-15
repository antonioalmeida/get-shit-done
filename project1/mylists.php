<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');
include_once('templates/common/header.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];
$user = getUser($username);
$lists = getUserLists($user['username']);
?>

<div class="container">

       <?php if ($isLoggedIn) { ?>

       <h4>
            My Lists
      </h4>

      <?php } else { ?>
      <!-- else here -->
      <?php } ?>

    <?php foreach ($lists as $list) { ?>
        <p> <?=$list['title']?></p>

    <?php } ?>      

</div>


<?php
include_once('templates/common/footer.php');
?>
