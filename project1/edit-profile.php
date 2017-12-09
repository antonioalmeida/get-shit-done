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
include_once('templates/common/navbar.php');
include_once('templates/common/alerts.php');
?>

<div class="container">
    <h4>Edit Profile</h4>
        <div>
            <form action="actions/action_edit_myprofile.php" method="post">
                <div>
                    <div class="form-element">
                        <label for="username">Username</label>
                        <input type="text" placeholder="johndoe" name="username" value="<?=$user['username']?>" required>
                    </div>

                    <div class="form-element">
                        <label for="email">Email</label>
                        <input type="email" placeholder="email@example.com" name="email" value="<?=$user['email']?>" required>
                    </div>

                    <div class="form-element">
                        <label for="name">Name</label>
                        <input type="text" placeholder="John Doe" name="name" value="<?=$user['name']?>" required>
                    </div>

                    <div class="form-element">
                        <label for="bio">Bio</label>
                        <input type="text" name="bio" placeholder="'I'll be back!'" value="<?=$user['bio']?>" required>
                    </div>
                </div>
                <div>
                    <input class="button-primary" type="submit" value="Update">
                </div>
            </form>
        </div>

        <div class="upload">
            <form action="actions/action_uploadPPic.php" method="post" enctype="multipart/form-data">
                <br><label>Profile Picture:</label>
                <input type="hidden" name="username" value="<?=$user['username']?>"/>
                <input type="url" name="picture" placeholder="Insert the URL !" required>
                <input type="submit" class="button-primary" value="Upload">
            </form>
        </div>

    </div>

</div>


<?php
include ('templates/common/footer.php');
?>
