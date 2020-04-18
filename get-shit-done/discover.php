<?php
include_once('includes/init.php');

$isLoggedIn = (isset($_SESSION['username']));
if (!$isLoggedIn) {
    header('Location: ' . './404.php');
}

include_once('templates/common/header.php');
include_once('templates/common/navbar.php');
include_once('templates/common/alerts.php');
?>

<script type="text/javascript" src="scripts/users.js" defer></script>

<div class="flex-center">
    <?php if($isLoggedIn) { ?>
    <div>
        <h1><strong><i class="fa fa-search text-primary"></i> Discover</strong></h1>
        <h3>Find out what other people are up to.</h3>
        <div class="flex-spaced">
            <div>
                <input onkeyup=showSimilarUsersDiscover(this.value) type="text" placeholder="Username..." name="username" />
            </div>
            <div id="searchResults"></div>
        </div>
    </div>
    <?php } ?>
</div>

<?php
include_once('templates/common/footer.php');
?>
