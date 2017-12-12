<?php
include_once('includes/init.php');
include_once('templates/common/header.php');
include_once('templates/common/navbar.php');
include_once('templates/common/alerts.php');

$isLoggedIn = (isset($_SESSION['username'])); ?>

<div class="flex-center">
    <?php if($isLoggedIn) { ?>
        <div>
            <h1><strong><i class="fa fa-check-circle text-primary"></i> Welcome!</strong></h1>
            <h3>Have you done something today?</h3>
            <h5>Why not start by checking what other people have been up to?</h5>
        </div>
    <?php }
    else { ?>
        <div>
            <h1><strong><i class="fa fa-check-circle text-primary"></i> Get Shit Done</strong></h1>
            <h4>Do your shit. Do it right.</h4>
            <div>
                    <a href="/login.php"><button class="button button-primary">Login</button></a>
                    <a href="/register.php"><button class="button">Sign Up</button></a>
            </div>
        </div>
    <?php } ?>
</div>

<?php
include_once('templates/common/footer.php');
?>
