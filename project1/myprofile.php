<?php
  include_once('includes/init.php');
  include_once('database/user.php');
  include_once('templates/common/header.php');

  $isLoggedIn = (isset($_SESSION['username']));
  $username = $_SESSION['username'];
  $user = getUser($username);
?>

<div class="container">
  <div>
    <?php if ($isLoggedIn) { ?>
      <h4><?=$username ?></h4>
    <?php } else { ?>
      <h4>User</h4>
    <?php } ?>
  </div>
</div>

<?php if ($isLoggedIn) { ?>
  <div class="container">
    <section id="myprofile">
      <?php if(isset($user['picture']) != null){?>
        <div class="userPic">
          <img src="<?php $user['picture'] ?>" alt="">
        </div>
        <?php } ?>

        <div class="info">

          <label>Username: </label> <?php echo $user['username']?>
          <br><br>
          <label>Email:</label> <a href="mailto:<?php echo $user['email']?>"><?php echo $user['email']?></a>
          <br><br>
          <label>Name: </label> <?php if(isset($user['name']) != null) echo $user['name'] ?>
          <br><br>
          <label>Bio: </label>
            <?php if($user['bio']!= null) {
            $paragraphs = explode("\n", $user['bio']);
            foreach ($paragraphs as $paragraph) {
              if (trim($paragraph) != '') { ?>
                <p><?=$paragraph?></p>
                <?php } }?>
                <br>
                  <?php } ?>

              </div>
              <a href="edit_myprofile.php">Edit</a>
            </div>


          </section>
        </div>
        <?php } ?>

<?php
  include_once('templates/common/footer.php');
?>
