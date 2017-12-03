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
$categoriesUser = getUserCategories($user['username']);
?>

<div class="container">
  <div class="flex-container">
    <div class="sidebar">
     <h6><strong>Menu</strong></h6>
     <p><strong>Categories</strong></p>
     <div class="categories">
       <?php foreach ($categoriesUser as $category) { ?>
       <p> <i style="color: #<?=$category['color']?>" class="fa fa-circle"></i> <?=$category['name']?></p>
       <?php } ?>
     </div>
   </div>

   <div class="lists">
    <?php if ($isLoggedIn) { ?>
    <h4> My Lists </h4>
    <?php } ?>

    <div class="flex-container">
      <?php foreach ($lists as $list) { ?>
      <div class="list">
        <h6> <a href="list.php?id=<?=$list['listId']?>"><?=$list['listName']?></a></h6>
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
            <label for="listTitle">Title</label>
            <input placeholder="Homework" type="text" name="listTitle" required>
          </div>

          <div class="form-element">

            <label for="category">Category</label>
            <select name="category">
              <?php foreach ($categoriesUser as $category) { ?>
              <option value="<?=$category['id']?>"><?=$category['name']?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div>
          <input class="button-primary" type="submit" value="Add">
        </div>
      </form>
    </div>
  </div>
</div>

</div>

<?php
include_once('templates/common/footer.php');
?>
