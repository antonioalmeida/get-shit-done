'use strict';

let form = document.querySelector('form');

form.addEventListener('submit', addList);

function addList(event) {
	let listTitle = document.querySelector('input[name=listTitle]').value;
	let category = document.querySelector('input[name=category]').value;

	let request = new XMLHttpRequest();
	let DOMString = 'action_add_list.php?' + encodeForAjax({'title': listTitle, 'category': category});
	request.open('get', DOMString, true);
	request.addEventListener('load', listAdded);
	request.send();

	event.preventDefault();
}

function listAdded() {
	console.log(this.responseText);
	let newList = JSON.parse(this.responseText);
	let container = document.querySelector('.flex-container');
	let listDiv = document.createElement('div');

	listDiv.classList.add('list');
	listDiv.innerHTML =
		'<p>' + newList.title + '</p>' +
		'<p>' + newList.creationDate + '</p>' +
		'<p>' + newList.category + '</p>';

	container.append(listDiv);
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

