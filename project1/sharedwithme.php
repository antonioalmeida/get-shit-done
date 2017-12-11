<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');
include_once('templates/common/header.php');
?>

<script type="text/javascript" src="scripts/lists.js" defer></script>

<?php
include_once('templates/common/navbar.php');
include_once('templates/common/alerts.php');

if($_SESSION['username'] == null){
    header('Location: ' . './index.php');
}

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];
$user = getUser($username);
$lists = getUserSharedLists($user['username']);
$categoriesUser = getUserSharedCategories($user['username']);
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
    <h4> Shared With Me </h4>
    <?php } ?>

    <div id="allLists" class="flex-container">
      <?php if(sizeof($lists) > 0) {
        foreach ($lists as $list) { ?>
        <div class="list">
          <div class="flex-container">
            <div class="title">
              <h6> <a href="list.php?id=<?=$list['listId']?>"><?=$list['listName']?></a></h6>
            </div>
            <div class="deleteList"><i class="fa fa-times"></i></div>
          </div>
          <p> <?=$list['creationDate']?></p>
          <p> <i style="color: #<?=$list['categoryColor']?>" class="fa fa-circle"></i> <?=$list['categoryName']?></p>
        </div>
        <?php }
      } else { ?>
      <h6>Noone shared any lists with you. <i class="fa fa-frown-o"></i></h6>
      <?php } ?>

    </div>

  </div>
</div>
</div>


<?php
include_once('templates/common/footer.php');
?>
