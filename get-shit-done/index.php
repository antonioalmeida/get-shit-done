<?php
include_once('includes/init.php');
include_once('templates/common/header.php');
include_once('templates/common/navbar.php');
include_once('templates/common/alerts.php');

$isLoggedIn = (isset($_SESSION['username'])); ?>

<script type="text/javascript" src="scripts/users.js" defer></script>

<div class="flex-center">
    <div>
        <h1><strong><i class="fa fa-check-circle text-primary"></i> Get Shit Done</strong></h1>
        <h4>Do your shit. Do it right.</h4>
        <?php if(!$isLoggedIn) { ?>
        <div>
            <a href="./login.php"><button class="button button-primary">Login</button></a>
            <a href="./register.php"><button class="button">Sign Up</button></a>
        </div>
        <?php } ?>
    </div>
</div>

<?php
include_once('templates/common/footer.php');
?>
