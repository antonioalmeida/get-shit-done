'use strict';

let addListForm = document.getElementById('addListForm');
let deleteListTargets = document.querySelectorAll('.deleteList');

addList.addEventListener('submit', addListHandler);

deleteListTargets.forEach(function(element) {
    element.addEventListener('click', deleteListHandler);
})

function addListHandler(event) {
    let listTitle = document.querySelector('input[name=listTitle]').value;
    let category = document.querySelector('select[name=category]').value;

    let request = new XMLHttpRequest();
    let DOMString = './actions/action_add_list.php?' + encodeForAjax({'title': listTitle, 'category': category});
    request.open('get', DOMString, true);
    request.addEventListener('load', addListFinished);
    request.send();

    event.preventDefault();
}

function addListFinished() {
    let newList = JSON.parse(this.responseText);
    let parent = document.getElementById('allLists');
    let addList = document.getElementById('addList');
    addList.querySelector('input[name=listTitle').value = '';

    let listDiv = document.createElement('div');
    listDiv.classList.add('list');
    listDiv.innerHTML =
		'<h6><a href="list.php?id=' + newList.id + '">' + newList.title + '</a></h6>' +
		'<p>' + newList.creationDate + '</p>' +
		'<p><i style="color: #' + newList.color + '" class="fa fa-circle"></i> ' + newList.name + '</p>';

    parent.insertBefore(listDiv, addList);

}

function deleteListHandler(event) {
    // TODO
}


function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}
