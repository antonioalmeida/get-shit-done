<?php
include_once('includes/init.php');
include_once('templates/common/header.php');
include_once('templates/common/navbar.php');
?>

<!-- Typography -->
<div class="container">
  <h4>Login</h4>

  <div class="form-group">
    <form action="actions/action_login.php" method="post">
      <div>
        <div class="form-element">
          <label for="username">Username</label>
          <input type="text" placeholder="johndoe" name="username" pattern="^[a-zA-Z][\w-]{1,18}(?![-_])\w$" title="3 to 20 characters. Must start with a letter and end in an alphanumeric character. Can contain - or _ in between" required>
        </div>

        <div class="form-element">
          <label for="password">Password</label>
          <input type="password" placeholder="Definitely not 'password'" name="password" required>
        </div>
      </div>
      <div>
        <input class="button-primary" type="submit" value="Login">
      </div>
    </form>
  </div>

  <br><br>
  <h6>Don't have an account? <a href="register.php">Create one now!</a></h6>
</div>


<?php
include_once('templates/common/footer.php');
?>
