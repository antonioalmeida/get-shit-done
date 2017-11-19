'use strict';

let form = document.querySelector('form');

form.addEventListener('submit', addList);

function addList(event) {
	let listTitle = document.querySelector('input[name=listTitle]').value;
	let category = document.querySelector('input[name=category]').value;
	let color = document.querySelector('input[name=color]').value;

	let request = new XMLHttpRequest();
	let DOMString = 'action_add_list.php?' + encodeForAjax({'title': listTitle, 'category': category, 'color': color});
	request.open('get', DOMString, true);
	request.addEventListener('load', listAdded);
	request.send();

	event.preventDefault();
}

function listAdded() {
	console.log('listAdded');
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}