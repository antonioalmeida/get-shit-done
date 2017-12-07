<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');
include_once('templates/common/header.php');
include_once('templates/common/alerts.php');
?>

<script type="text/javascript" src="scripts/items.js" defer></script>

<?php
include_once('templates/common/navbar.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];
$user = getUser($username);

if (!isset($_GET['id']))
  die("No id!");

if ( !preg_match ("/^\d+$/", $_GET['id'])) {
  die("ERROR: ID can only contain numbers");
}

$listID = $_GET['id'];
$list = getUserList($user['username'], $listID);
$items = getListItems($listID);
$admins = getListAdmins($listID);
?>

<div class="container">
  <div class="flex-container">
    <div class="sidebar">
      <h6><strong>Menu</strong></h6>


      <p><i class="fa fa-users"></i> <strong>Members</strong></p>
      <div class="members">
        <?php foreach ($admins as $admin) { ?>
        <p>@<?=$admin['user']?></p>
        <?php } ?>
      </div>
      <p><i class="fa fa-user-plus"></i> <strong>Invite</strong></p>
      <div>
        <form id="addListAdmin">
          <input type="hidden" name="listID" value="<?=$listID?>" required>
          <input type="text" placeholder="Username" name="addAdminUsername" required>
        </form>
      </div>
      <p><i class="fa fa-calendar-check-o"></i> <strong>Due Today</strong></p>
    </div>

    <div class="items">
      <div id="items-list">
        <?php if ($isLoggedIn) { ?>
        <h4>
          <?=$list['title']?>
        </h4>

        <?php } else { ?>
        <!-- else here -->
        <?php } ?>
        <?php foreach($items as $item) { ?>
        <div class="item flex-container" id="item<?=$item['id']?>">
          <div class="item-left">
            <input type="checkbox" id="<?=$item['id']?>" name="complete"
            <?php if($item['complete'] == 1) { ?>
            checked
            <?php } ?>
            >
            <span class="itemDescription"><?=$item['description']?></span>
          </div>

          <div class="item-edit hidden">
            <form class="editItemForm">
              <div class="flex-equal">
                <input type="hidden" name="itemID" value="<?=$item['id']?>">
                <div>
                  <label for="editDescription">Description</label>
                  <input type="text" name="editDescription" value="<?=$item['description']?>" required>
                </div>
                <div>
                  <label for="editDate">Due Date</label>
                  <input type="date" name="editDate" value="<?=$item['dueDate']?>" required>
                </div>
              </div>
              <div>
                <input class="button-primary" type="submit" value="Save">
                <a class="button cancelEditItem">Cancel</a>
              </div>
            </form>
          </div>

          <div class="item-user hidden">
            <form class="assignUserForm">
              <div class="flex-equal">
                <input type="hidden" name="itemID" value="<?=$item['id']?>">
                <div>
                  <label for="assignedUser">Assign User</label>
                  <select name="assignedUser" >
                    <option value="">None</option>
                    <?php foreach ($admins as $admin) { ?>
                    <option value="<?=$admin['user']?>"><?=$admin['user']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div>
                <input class="button-primary" type="submit" value="Assign">
                <a class="button cancelAssignUser">Cancel</a>
              </div>
            </form>
          </div>

          <div class="item-right">
            <span class="itemDueDate"><?= date('d M', strtotime($item['dueDate']))?></span>
            <?php switch ($item['priority']) {
              case 1: ?>
              <span class="itemPriority priority-low">Low</span> 
              <?php
              break;
              case 2:  ?>
              <span class="itemPriority priority-medium">Med</span> 
              <?php
              break;
              case 3: ?>
              <span class="itemPriority priority-high">High</span> 
              <?php
              break;
            } ?>
            <span>
              <?php if($item['assignedUser'] != "") { ?> 
              <span class="assignUser" id="assignUser<?=$item['id']?>"> @<?=$item['assignedUser']?></span>
              <?php } else { ?>
              <i id="assignUser<?=$item['id']?>" class="fa fa-user-plus assignUser"></i>
              <?php } ?>
            </span>
            <span><i id="edit<?=$item['id']?>" class="fa fa-pencil-square-o"></i></span>
            <span><i id="delete<?=$item['id']?>" class="fa fa-trash deleteItem"></i></span>
          </div>
        </div>
        <?php } ?>
      </div>

      <div class="add-item">
        <a href="#" id="showAddItem"><i class="fa fa-plus"></i> Add a Task</a>
        <div>
          <form class="hidden" id="addItemForm">
            <div class="flex-spaced">
              <input type="hidden" name="id" value="<?=$listID?>">
              <br>
              <div>
                <label for="addItemDescription">Description</label>
                <input type="text" placeholder="Call girlfriend" name="addItemDescription" required>
              </div>
              <div>
                <label for="addItemDueDate">Due Date</label>
                <input type="date" name="addItemDueDate" required>
              </div>
            </div>
            <div>
              <input class="button-primary" type="submit" value="Add">
              <a id="cancelAddItem" class="button">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div> 

</div>

<?php
include('templates/common/footer.php');
?>
