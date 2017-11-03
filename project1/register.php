<?php
include_once('includes/init.php');
include_once('templates/common/header.php');
?>

<!-- Typography -->
<div class="container">
    <div>
        <h4>Register</h4>
        <div class="form-group">
            <form action="action_register.php" method="post">
                <div>
                    <div class="form-element">
                        <input type="text" name="firstName" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Name</label>
                    </div>

                    <div class="form-element">
                        <input type="email" name="email" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Email</label>
                    </div>

                    <div class="form-element">
                        <input type="password" name="password" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Password</label>
                    </div>

                    <div class="form-element">
                        <input type="password" name="confirmPassword" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Confirm password</label>
                    </div>
                </div>
                <div>
                    <input class="button-primary" type="submit" value="Register">
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include_once('templates/common/footer.php');
?>
