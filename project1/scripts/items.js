'use strict';

let form = document.querySelector('form');
let showAddItem = document.querySelector('#showAddItem');
let cancelAddItem = document.querySelector('#cancelAddItem');
let checkboxList = document.querySelectorAll('input[name="complete"]');
let deleteItemsList = document.querySelectorAll('.fa-trash');

form.addEventListener('submit', addItem);
showAddItem.addEventListener('click', showAddItemHandler);
cancelAddItem.addEventListener('click', cancelAddItemHandler);

checkboxList.forEach(function(element) {
	element.addEventListener('click', updateItemComplete);
});

deleteItemsList.forEach(function(element) {
	element.addEventListener('click', deleteItem);
});

function addItem(event) {
	let id_list = document.querySelector('input[name=id]').value;
	let description = document.querySelector('input[name=description]').value;

	let request = new XMLHttpRequest();
	let DOMString = './actions/action_add_item.php?' + encodeForAjax({'id':id_list, 'description': description});
	request.open('get', DOMString, true);
	request.addEventListener('load', itemAdded);
	request.send();

	event.preventDefault();
}

function deleteItem(event) {
	let itemID = event.target.id.substr(6,6); // getting clicked item's ID

	let request = new XMLHttpRequest();
	let DOMString = './actions/action_delete_item.php?' + encodeForAjax({'id':itemID});
	request.open('get', DOMString, true);
	request.addEventListener('load', itemDeleted);
	request.send();
}

function itemAdded() {
	let newItem = JSON.parse(this.responseText);
	let container = document.querySelector('.items');
	let itemDiv = document.createElement('div');

	itemDiv.classList.add('item');
	itemDiv.innerHTML =
	'<input type="checkbox" name="complete">' +
	'<span>' + newItem.description + '</span>'+
	'<span>' + newItem.dueDate + '</span>';

	container.append(itemDiv);
}

function itemDeleted() {
	let itemID = this.responseText;
	console.log(itemID);

	if(itemID == -1) 
		return;

	let item = document.getElementById('item' + itemID);
	item.parentNode.removeChild(item);
}

function showAddItemHandler(event) {
	form.classList.remove('hidden');
	showAddItem.classList.add('hidden');
}

function cancelAddItemHandler(event) {
	form.classList.add('hidden');
	showAddItem.classList.remove('hidden');
}

function updateItemComplete(event) {
	event.preventDefault();
	let checkbox = event.target;
	let currentValue = checkbox.checked;
	let itemID = checkbox.id;

	let newValue = currentValue ? 1 : 0; //lolwut
	let DOMString = './actions/action_update_complete.php?' + encodeForAjax({'itemID':itemID, 'complete': newValue});

	let request = new XMLHttpRequest();
	request.open('get', DOMString, true);
	request.addEventListener('load', checkboxUpdated);
	request.send();
}

function checkboxUpdated() {
	let item = JSON.parse(this.responseText);
	setChecked(item.id, item.complete == 1);
}

function setChecked(id, value) {
	let checkbox = document.getElementById(id);
	checkbox.checked = value;
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}
