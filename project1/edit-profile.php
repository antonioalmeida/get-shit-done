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
    <h4>Edit Profile</h4>
    <div class="form-group">
        <form action="action_edit_myprofile.php" method="post">
            <div>
                <div class="form-element">
                    <input type="text" name="username" value="<?=$user['username']?>" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Username</label>
                </div>

                <div class="form-element">
                    <input type="email" name="email" value="<?=$user['email']?>" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Email</label>
                </div>

                <div class="form-element">
                    <input type="text" name="name" value="<?=$user['name']?>" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Name</label>
                </div>

                <div class="form-element">
                    <input type="text" name="bio" value="<?=$user['bio']?>" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Bio</label>
                </div>
            </div>
            <div>
                <input class="button-primary" type="submit" value="Update">
            </div>
        </form>
    </div>

</div>


<?php
include ('templates/common/footer.php');
?>
