<?php
    include_once('includes/init.php');
    include_once('templates/common/header.php');

    $isLoggedIn = (isset($_SESSION['username']));
    $username = $_SESSION['username'];
?>

<div class="container">
    <div>
        <?php if ($isLoggedIn) { ?>
            <h4><?=$username ?></h4>
        <?php } else { ?>
            <h4>User</h4>
        <?php } ?>
    </div>
</div>


<?php
    include_once('templates/common/footer.php');
?>
