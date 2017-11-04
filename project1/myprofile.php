<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('templates/common/header.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];
$user = getUser($username);
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


    <?php } else { ?>
    <!-- else here -->
    <?php } ?>

</div>
</div>
</div>


<?php
include_once('templates/common/footer.php');
?>
