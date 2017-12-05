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

    <div id="allLists" class="flex-container">
      <?php foreach ($lists as $list) { ?>
      <div class="list" id="list<?=$list['listId']?>">
        <div class="flex-container">
          <div class="title">
            <h6> <a href="list.php?id=<?=$list['listId']?>"><?=$list['listName']?></a></h6>
          </div>
          <div class="deleteList"><i class="fa fa-times"></i></div>
        </div>
        <p> <?=$list['creationDate']?></p>
        <p> <i style="color: #<?=$list['categoryColor']?>" class="fa fa-circle"></i> <?=$list['categoryName']?></p>
      </div>
      <?php } ?>

      <div class="list" id="addList">
        <form id="addListForm">
          <input placeholder="New List" name="listTitle" required>
          <br>
          <select name="category">
            <?php foreach ($categoriesUser as $category) { ?>
            <option value="<?=$category['id']?>"><?=$category['name']?></option>
            <?php } ?>
          </select>
        </form>
      </div>
    </div>

  </div>
</div>
</div>


<?php
include_once('templates/common/footer.php');
?>
