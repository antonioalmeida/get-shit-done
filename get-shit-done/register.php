<?php
include_once('includes/init.php');

$isLoggedIn = (isset($_SESSION['username']));
if($isLoggedIn){
    header('Location: ' . './index.php');
}

include_once('templates/common/header.php');
include_once('templates/common/navbar.php');
include_once('templates/common/alerts.php');
?>

<!-- Typography -->
<div class="centered-form">
    <div class="form">
        <h4>Register</h4>
        <form action="actions/action_register.php" method="post">
            <div>
                <div class="form-element">
                    <label for="username">Username</label>
                    <input type="text" placeholder="johndoe" name="username" pattern="^[a-zA-Z][\w-]{1,18}(?![-_])\w$" title="3 to 20 characters. Must start with a letter and end in an alphanumeric character. Can contain - or _ in between" required>
                </div>

                <div class="form-element">
                    <label for="email">Email</label>
                    <input type="email" placeholder="me@example.com" name="email" required>
                </div>

                <div class="form-element">
                    <label for="password">Password</label>
                    <input type="password" placeholder="Something impressive" name="password" pattern="^(?=.*\d)(?=.*[a-zA-Z])(?=.*[&quot;-_?!@#+*$%&/()=])[&quot;\w\-?!@#+*$%&/()=]{8,32}$" title="8 to 32 characters. Must contain a letter, one of the following -_?!@#+*$%/()= and a number" required>
                </div>

                <div class="form-element">
                    <label>Confirm Password</label>
                    <input type="password" placeholder="Can you repeat that?" name="confirmPassword" required>
                </div>
            </div>
            <div>
                <input class="button-primary" type="submit" value="Register">
            </div>
        </form>
        <br><br>
        <h6>Already have an account? <a href="login.php">Login now!</a></h6>
    </div>
</div>


<?php
include_once('templates/common/footer.php');
?>
