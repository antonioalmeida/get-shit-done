<?php
    include_once('includes/init.php');
    include_once('templates/common/header.php');
    include_once('templates/common/navbar.php');
?>

<!-- Typography -->
<div class="container">
  <h6>Typography</h6>
    <div>
        <h4>Login</h4>
        <div>
          <?php if (isset($_SESSION['username']) && $_SESSION['username'] != '') { ?>
            <form action="/actions/action_logout.php" method="post">
              <a href="register.php"><?=$_SESSION['username']?></a>
              <input type="submit" value="Logout">
            </form>
          <?php } else { ?>
            <form action="actions/action_login.php" method="post">
              <input type="text" placeholder="username" name="username">
              <input type="password" placeholder="password" name="password">
              <div>
                <input type="submit" value="Login">
                <a href="register.php">Register</a>
              </div>
            </form>
          <?php } ?>
        </div>     </div>
  </div>


<?php
    include_once('templates/common/footer.php');
?>
