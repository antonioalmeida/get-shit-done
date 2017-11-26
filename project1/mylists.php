<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');
include_once('templates/common/header.php');
?>

<script type="text/javascript" src="scripts/lists.js" defer></script>

<?php
include_once('templates/common/navbar.php');
$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];
$user = getUser($username);
$lists = getUserLists($user['username']);
?>

<div class="container">

  <?php if ($isLoggedIn) { ?>

  <h4>
    My Lists
  </h4>

<?php } else { ?>
<!-- else here -->
<?php } ?>

<div class="flex-container">
  <?php foreach ($lists as $list) { ?>
  <div class="list">
      <h6> <a href="list.php?id=<?=$list['id']?>"><?=$list['listName']?></a></h6>
      <p> <?=$list['creationDate']?></p>
      <p> <i style="color: #<?=$list['categoryColor']?>" class="fa fa-circle"></i> <?=$list['categoryName']?></p>
  </div>

  <?php } ?>
</div>

<h4>Add a List</h4>
<div>
    <form id="addListForm">
        <div>
            <div class="form-element">
                <input type="text" name="listTitle" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Title</label>
            </div>

            <div class="form-element">
                <input type="text" name="category" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Category</label>
            </div>
        </div>
        <div>
            <input class="button-primary" type="submit" value="Add">
        </div>
    </form>
</div>

</div>

<?php
include_once('templates/common/footer.php');
?>
