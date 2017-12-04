'use strict';

let form = document.querySelector('form');

form.addEventListener('submit', addList);

function addList(event) {
    let listTitle = document.querySelector('input[name=listTitle]').value;
    let category = document.querySelector('select[name=category]').value;

    let request = new XMLHttpRequest();
    let DOMString = './actions/action_add_list.php?' + encodeForAjax({'title': listTitle, 'category': category});
    request.open('get', DOMString, true);
    request.addEventListener('load', listAdded);
    request.send();

    event.preventDefault();
}

function listAdded() {
    let newList = JSON.parse(this.responseText);
    let container = document.querySelector('.flex-container');
    let listDiv = document.createElement('div');

    listDiv.classList.add('list');
    listDiv.innerHTML =
		'<h6><a href="list.php?id=' + newList.id + '">' + newList.title + '</a></h6>' +
		'<p>' + newList.creationDate + '</p>' +
		'<p><i style="color: #' + newList.color + '" class="fa fa-circle"></i> ' + newList.name + '</p>';

    container.append(listDiv);
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}
