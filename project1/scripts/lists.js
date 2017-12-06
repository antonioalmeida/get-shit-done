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
    let csrf = document.querySelector('input[name=csrf]').value;

    let request = new XMLHttpRequest();
    let DOMString = './actions/action_add_list.php?' + encodeForAjax({'title': listTitle, 'category': category, 'csrf': csrf});
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
    listDiv.id = 'list' + newList.id;
    listDiv.innerHTML = getListHTML(newList);
    console.log(listDiv);
    console.log(listDiv.innerHTML);

    listDiv.querySelector('.deleteList').addEventListener('click', deleteListHandler);

    parent.insertBefore(listDiv, addList);
}

function deleteListHandler(event) {
    let listToDelete = event.target.parentNode.parentNode.parentNode;
    let listID = listToDelete.id.substr(4);
      let csrf = document.querySelector('input[name=csrf]').value;

    let request = new XMLHttpRequest();
    let DOMString = './actions/action_delete_list.php?' + encodeForAjax({'listID': listID, 'csrf': csrf});
    request.open('get', DOMString, true);
    request.addEventListener('load', deleteListFinished);
    request.send();
}

function deleteListFinished () {
    let deletedID = this.responseText;
    let listToDelete;
    console.log(deletedID);
    if(deletedID != -1) {
        listToDelete = document.getElementById('list'+deletedID);
        listToDelete.parentNode.removeChild(listToDelete);
    }
}

function getListHTML(newList){

  return '<div class="fex-container"> <div class="title"> <h6><a href="list.php?id=' + newList.id + '">' + newList.title + '</a></h6>' +
  '</div><div class="deleteList"><i class="fa fa-times"></i>'+
  '</div></div><p>' + newList.creationDate + '</p>' +
  '<p><i style="color: #' + newList.color + '" class="fa fa-circle"></i> ' + newList.name + '</p></div>';

}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}
