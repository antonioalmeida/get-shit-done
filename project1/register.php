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
                        <input type="text" name="username" pattern="^[a-zA-Z][\w-]{1,18}(?![-_])\w$" title="3 to 20 characters. Must start with a letter and end in an alphanumeric character. Can contain - or _ in between" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Username</label>
                    </div>

                    <div class="form-element">
                        <input type="email" name="email" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Email</label>
                    </div>

                    <div class="form-element">
                        <input type="password" name="password" pattern="^(?=.*\d)(?=.*[a-zA-Z])(?=.*[&quot;-_?!@#+*$%&/()=])[&quot;\w\-?!@#+*$%&/()=]{8,32}$" title="8 to 32 characters. Must contain a letter, one of the following -_?!@#+*$%/()= and a number" required>
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
