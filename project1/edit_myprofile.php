<?php
  include_once('includes/init.php');
  include_once('database/user.php');


  $isLoggedIn = (isset($_SESSION['username']));
  $username = $_SESSION['username'];
  try {
  $user = getUser($username);
} catch (PDOException $e) {
  die($e->getMessage());
}

  include_once('templates/common/header.php');
?>

<div class="container">
  <section id="myprofile">
    <?php if(isset($user['picture']) != null){?>

        <img src="<?php $user['picture'] ?>" alt="">

      <?php } ?>


        <form action="action_edit_myprofile.php" method="post">
        <input type="hidden" name="picture" value="">
        <label>Username: </label> <input type="text" name="username" value="<?=$user['username']?>">
        <br><br>
        <label>Email:</label> <input type="text" name="email" value="<?=$user['email']?>"></a>
        <br><br>
        <label>Name: </label> <input type="text" name="name" value="<?=$user['name']?>">
        <br><br>
        <label>Bio: </label><textarea name="bio"><?=$user['bio']?></textarea>
        <input type="submit" value="Save">
      </form>
            

        </section>
      </div>


<?php
include ('templates/common/footer.php');
?>
