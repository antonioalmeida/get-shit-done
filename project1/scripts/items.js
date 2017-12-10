'use strict';

let addItemForm = document.querySelector('#addItemForm');
let showAddItem = document.querySelector('#showAddItem');
let cancelAddItem = document.querySelector('#cancelAddItem');
let checkboxList = document.querySelectorAll('input[name="complete"]');
let deleteItemList = document.querySelectorAll('.deleteItem');
let editItemList = document.querySelectorAll('.editItem');
let cancelEditItemList = document.querySelectorAll('.cancelEditItem');
let editItemFormList = document.querySelectorAll('.editItemForm');
let assignUserList = document.querySelectorAll('.assignUser');
let cancelAssignUserList = document.querySelectorAll('.cancelAssignUser');
let assignUserFormList = document.querySelectorAll('.assignUserForm');
let addListAdmin = document.getElementById('addListAdmin');

addItemForm.addEventListener('submit', addItemSubmitHandler);
showAddItem.addEventListener('click', showAddItemHandler);
cancelAddItem.addEventListener('click', cancelAddItemHandler);
addListAdmin.addEventListener('submit', addListAdminSubmitHandler);

checkboxList.forEach(function (element) {
    element.addEventListener('click', updateItemComplete);
});

deleteItemList.forEach(function (element) {
    element.addEventListener('click', deleteItemHandler);
});

editItemList.forEach(function (element) {
    element.addEventListener('click', editItemHandler);
});

cancelEditItemList.forEach(function (element) {
    element.addEventListener('click', cancelEditItemHandler);
});

editItemFormList.forEach(function (element) {
    element.addEventListener('submit', editItemSubmitHandler);
});

assignUserList.forEach(function (element) {
    element.addEventListener('click', assignUserHandler);
});

cancelAssignUserList.forEach(function (element) {
    element.addEventListener('click', cancelAssignUserHandler);
});

assignUserFormList.forEach(function (element) {
    element.addEventListener('submit', assignUserSubmitHandler);
});

function addItemSubmitHandler (event) {
    event.preventDefault();
    let id_list = document.querySelector('input[name=id]').value;
    let description = document.querySelector('input[name=addItemDescription]').value;
    let dueDate = document.querySelector('input[name=addItemDueDate]').value;
    console.log(description);
    console.log(dueDate);

    let request = new XMLHttpRequest();
    let DOMString = './actions/action_add_item.php?' + encodeForAjax({'id': id_list, 'description': description, 'dueDate': dueDate});
    request.open('get', DOMString, true);
    request.addEventListener('load', itemAdded);
    request.send();

}

function deleteItemHandler (event) {
    let itemID = event.target.id.substr(6); // getting clicked item's ID

    let request = new XMLHttpRequest();
    let DOMString = './actions/action_delete_item.php?' + encodeForAjax({'id': itemID});
    request.open('get', DOMString, true);
    request.addEventListener('load', itemDeleted);
    request.send();
}

function itemAdded () {
    console.log(this.responseText);
    let newItem = JSON.parse(this.responseText);
    let container = document.getElementById('items-list');
    let itemDiv = document.createElement('div');

    itemDiv.classList.add('item');
    itemDiv.classList.add('flex-container');
    itemDiv.id = 'item' + newItem.id;
    itemDiv.innerHTML = getItemHTML(newItem);

    // Add event listeners to new item
    itemDiv.querySelector('.assignUserForm').addEventListener('submit', assignUserSubmitHandler);
    itemDiv.querySelector('.fa-user-plus').addEventListener('click', assignUserHandler);
    itemDiv.querySelector('.editItem').addEventListener('click', editItemHandler);
    itemDiv.querySelector('.cancelEditItem').addEventListener('click', cancelEditItemHandler);
    itemDiv.querySelector('.deleteItem').addEventListener('click', deleteItemHandler);
    itemDiv.querySelector('input[name="complete"]').addEventListener('click', updateItemComplete);
    itemDiv.querySelector('.editItemForm').addEventListener('submit', editItemSubmitHandler);
    itemDiv.querySelector('.cancelAssignUser').addEventListener('click', cancelAssignUserHandler);

    container.append(itemDiv);
}

function itemDeleted () {
    let itemID = this.responseText;

    if (itemID == -1) { return; }

    let item = document.getElementById('item' + itemID);
    item.parentNode.removeChild(item);
    setAlertMessage('success', 'Item successfuly deleted!');
}

function showAddItemHandler (event) {
    addItemForm.classList.remove('hidden');
    showAddItem.classList.add('hidden');
}

function cancelAddItemHandler (event) {
    addItemForm.classList.add('hidden');
    showAddItem.classList.remove('hidden');
}

function editItemHandler (event) {
	console.log("CEnas");
    let itemID = event.target.id.substr(4);
    let item = document.getElementById('item' + itemID);

    let left = item.querySelector('.item-left');
    let edit = item.querySelector('.item-edit');
    left.classList.add('hidden');
    edit.classList.remove('hidden');
}

function editItemSubmitHandler (event) {
    event.preventDefault();
    let editForm = event.target;
    let itemID = editForm.querySelector('input[name=itemID]').value;
    let newDescription = editForm.querySelector('input[name=editDescription]').value;
    let newDate = editForm.querySelector('input[name=editDate]').value;

    let DOMString = './actions/action_edit_item.php?' + encodeForAjax({'itemID': itemID, 'description': newDescription, 'dueDate': newDate});

    let request = new XMLHttpRequest();
    request.open('get', DOMString, true);
    request.addEventListener('load', editItemFinished);
    request.send();
}

function cancelEditItemHandler (event) {
    let itemEdit = event.target.parentNode.parentNode.parentNode;
    itemEdit.classList.add('hidden');

    let itemLeft = itemEdit.parentNode.querySelector('.item-left');
    itemLeft.classList.remove('hidden');
}

function assignUserHandler (event) {
    let itemID = event.target.id.substr(10);
    let item = document.getElementById('item' + itemID);

    let left = item.querySelector('.item-left');
    let user = item.querySelector('.item-user');
    left.classList.add('hidden');
    user.classList.remove('hidden');
}

function cancelAssignUserHandler (event) {
    let itemUser = event.target.parentNode.parentNode.parentNode;
    itemUser.classList.add('hidden');

    let itemLeft = itemUser.parentNode.querySelector('.item-left');
    itemLeft.classList.remove('hidden');
}

function assignUserSubmitHandler (event) {
    event.preventDefault();
    let editForm = event.target;
    let itemID = editForm.querySelector('input[name=itemID]').value;
    let assignedUser = editForm.querySelector('select[name=assignedUser]').value;

    let DOMString = './actions/action_assign_user.php?' + encodeForAjax({'itemID': itemID, 'assignedUser': assignedUser});

    let request = new XMLHttpRequest();
    request.open('get', DOMString, true);
    request.addEventListener('load', assignUserFinished);
    request.send();
}

function updateItemComplete (event) {
    event.preventDefault();
    let checkbox = event.target;
    let currentValue = checkbox.checked;
    let itemID = checkbox.id;

    let newValue = currentValue ? 1 : 0; // lolwut
    let DOMString = './actions/action_update_complete.php?' + encodeForAjax({'itemID': itemID, 'complete': newValue});

    let request = new XMLHttpRequest();
    request.open('get', DOMString, true);
    request.addEventListener('load', checkboxUpdated);
    request.send();
}

function updateItemPriority (elem) {
    let currentPriority;
    switch(elem.innerHTML) {
      case 'Low':
        currentPriority = 1;
        break;
      case 'Med':
        currentPriority = 2;
        break;
      case 'High':
        currentPriority = 3;
        break;
    }
    let newPriority = (currentPriority + 1 ) % 4;
    if(newPriority == 0) newPriority = 1;

    let itemID = elem.id.match(/\d+/)[0];

    let DOMString = './actions/action_edit_priority.php?' + encodeForAjax({'itemID': itemID, 'priority': newPriority});

    let request = new XMLHttpRequest();
    request.open('get', DOMString, true);
    request.addEventListener('load', updateItemPriorityFinished);
    request.send();
}

function checkboxUpdated () {
	console.log(this.responseText);
    let item = JSON.parse(this.responseText);
    setChecked(item.id, item.complete == 1);
}

function updateItemPriorityFinished() {
    let item = JSON.parse(this.responseText);
    let priorityElem = document.getElementById("item"+item.id+"priority");

    switch(item.priority) {
      case '1':
        priorityElem.innerHTML = 'Low';
        priorityElem.classList.replace('priority-high', 'priority-low');
        return;
      case '2':
        priorityElem.innerHTML = 'Med';
        priorityElem.classList.replace('priority-low', 'priority-medium');
        return;
      case '3':
        priorityElem.innerHTML = 'High';
        priorityElem.classList.replace('priority-medium', 'priority-high');
        return;
    }
}

function editItemFinished () {
	console.log(this.responseText);
    let newItem = JSON.parse(this.responseText);
    let itemID = newItem.id;
    let itemDiv = document.getElementById('item' + itemID);

    let description = itemDiv.querySelectorAll('.itemDescription')[0];
    let dueDate = itemDiv.querySelectorAll('.itemDueDate')[0];

    description.innerHTML = newItem.description;
    dueDate.innerHTML = newItem.dueDate;

    console.log(description);
    console.log(dueDate);

    let itemEditArea = itemDiv.querySelector('.item-edit');
    itemEditArea.classList.add('hidden');

    let itemInfoArea = itemDiv.querySelector('.item-left');
    itemInfoArea.classList.remove('hidden');
}

function assignUserFinished () {
    let newItem = JSON.parse(this.responseText);
    let itemID = newItem.id;
    let itemDiv = document.getElementById('item' + itemID);
    let assignUser = document.getElementById('assignUser' + itemID);

    if(newItem.assignedUser) {
    	assignUser.innerHTML = '@' + newItem.assignedUser;
    	assignUser.classList.remove('fa-user-plus');
    	assignUser.classList.remove('fa');
    }
    else {
    	assignUser.classList.add('fa-user-plus');
    	assignUser.classList.add('fa');
    	assignUser.innerHTML = '';
    }

    let itemUserArea = itemDiv.querySelector('.item-user');
    itemUserArea.classList.add('hidden');

    let itemInfoArea = itemDiv.querySelector('.item-left');
    itemInfoArea.classList.remove('hidden');
}

function setChecked (id, value) {
    let checkbox = document.getElementById(id);
    checkbox.checked = value;
}

function addListAdminSubmitHandler (event) {
    event.preventDefault();
    let form = event.target;
    let listID = form.querySelector('input[name=listID]').value;
    let username = form.querySelector('input[name=addAdminUsername]').value;
    form.querySelector('input[name=addAdminUsername]').value = '';

    let DOMString = './actions/action_add_list_admin.php?' + encodeForAjax({'listID': listID, 'username': username});

    let request = new XMLHttpRequest();
    request.open('get', DOMString, true);
    request.addEventListener('load', addListAdminFinished);
    request.send();
}

function addListAdminFinished () {
    let membersDiv = document.querySelector('.members');
    let newMember = document.createElement('div');
    newMember.innerHTML = '<p>@' + this.responseText + '</p>';

    membersDiv.append(newMember);
}

function getItemHTML (newItem) {
    return '<div class="item-left">' +
			'<input type="checkbox" id="' + newItem.id + '" name="complete">' +
			'<span class="itemDescription">' + newItem.description + '</span>' +

    '</div>	<div class="item-edit hidden"><form class="editItemForm"> <div class="flex-equal">' +
			'<input type="hidden" name="itemID" value="' + newItem.id + '"><div>' +
			'<label for="editDescription">Description</label>' +
			'<input type="text" name="editDescription" value="' + newItem.description + '" required></div>' +
		'<div><label for="editDate">Due Date</label>' +
			'<input type="date" name="editDate" value="' + newItem.dueDate +
			'" required></div></div><div><input class="button-primary" type="submit" value="Save">' +
			'<a class="button cancelEditItem">Cancel</a> </div></form></div>'+

      '<div class="item-user hidden"><form class="assignUserForm"><div class="flex-equal">'+
            '<input type="hidden" name="itemID" value="' + newItem.id + '"><div><label for="assignedUser">Assign User</label>'+
              '<select name="assignedUser" ><option value="">None</option>'+ getAllAdmin(newItem)+
              '</select></div></div><div><input class="button-primary" type="submit" value="Assign">'+
            '<a class="button cancelAssignUser">Cancel</a></div></form></div>'+

      '<div class="item-right">' +
      '<span class="itemDueDate">' + newItem.dueDate + '</span>'+
      '<span id="item' + newItem.id + 'priority" onclick="updateItemPriority(this)" class="itemPriority priority-low">Low</span>'+
      '<span><i id="assignUser' + newItem.id + '" class="fa fa-user-plus"></i></span>' +
			'<span><i id="edit' + newItem.id + '" class="fa fa-edit editItem"></i></span>' +
			'<span><i id="delete' + newItem.id + '" class="fa fa-times deleteItem"></i></span>' + '</div>';
}

function getAllAdmin(newItem){
  let admins = newItem.admins;
  let options = '';
  for (let admin of admins) {
    options += '<option value="'+ admin['user'] + '">'+ admin['user'] + '</option>';
  }
  return options;
}

function encodeForAjax (data) {
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}
