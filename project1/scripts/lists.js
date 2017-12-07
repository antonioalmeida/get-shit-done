'use strict';

let addListForm = document.getElementById('addListForm');
let deleteListTargets = document.querySelectorAll('.deleteList');
let addCategoryForm = document.getElementById('addCategoryForm');
let colorPicker = document.getElementById('colorPicker')
let nativeColorPicker = document.getElementById('nativeColorPicker');

addList.addEventListener('submit', addListHandler);
addCategoryForm.addEventListener('submit', addCategoryHandler);

deleteListTargets.forEach(function(element) {
    element.addEventListener('click', deleteListHandler);
})

colorPicker.addEventListener('click', colorPickerHandler);
nativeColorPicker.addEventListener('change', updateColorHandler);

function addListHandler(event) {
    // TODO: Update this
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

function addCategoryHandler(event) {
    event.preventDefault();
    let form = event.target;
    let categoryName = form.querySelector('input[name=categoryName]').value;
    let categoryColor = form.querySelector('input[name=categoryColor]').value.substr(1);
    console.log(categoryColor);
    let csrf = form.querySelector('input[name=csrf]').value;

    let request = new XMLHttpRequest();
    let DOMString = './actions/action_add_category.php?' + encodeForAjax({'categoryName': categoryName, 'categoryColor': categoryColor, 'csrf': csrf});
    request.open('get', DOMString, true);
    request.addEventListener('load', addCategoryFinished);
    request.send();
}

function addCategoryFinished() {
    let newCategory = JSON.parse(this.responseText);
    let categoriesDiv = document.querySelector('.categories');

    let newCategoryHTML = document.createElement('p');
    newCategoryHTML.innerHTML = '<i style="color: #' + newCategory.color +
                            '" class="fa fa-circle"></i> ' + newCategory.name;

    categoriesDiv.append(newCategoryHTML);

    let selectCategory = document.getElementById('selectCategory');
    selectCategory.innerHTML += '<option value="' + newCategory.id + '">' + newCategory.name + '</option>';
}

function filterListsByTitle(title) {
    if(!title.match(/^[\w\s-?!\.()]*$/)) return;
    let titleRegex = new RegExp(title, 'i');
    let allLists = document.querySelectorAll('div[id^=list]');
    [].forEach.call(allLists, function(elem) {
        if(!elem.querySelector("a").innerHTML.match(titleRegex))
            elem.classList.add("hidden");
        else
            elem.classList.remove("hidden");
    });
}

function filterListsByCategory(categoryElement) {
    let allLists = document.querySelectorAll('div[id^=list]');
    let unfilter = categoryElement.classList.contains('filtered');
    if(unfilter) {
        categoryElement.classList.remove('filtered');
        [].forEach.call(allLists, function(elem) {elem.classList.remove("hidden");});
        return;
    }

    let categoryFiltered = categoryElement.textContent.replace(/\s/g, '');
    [].forEach.call(allLists, function(elem) {
        let elemCategory = elem.children[2].textContent.replace(/\s/g,'');
        if(elemCategory !== categoryFiltered)
            elem.classList.add("hidden");
        else
            elem.classList.remove("hidden");
    });
    categoryElement.classList.add('filtered');
}

function colorPickerHandler(event) {
    let picker = document.querySelector('input[name=categoryColor]');
    picker.click();
}

function updateColorHandler (event) {
    console.log(event.target);
    document.getElementById('colorPicker').style.color = event.target.value;
}

function getListHTML(newList){

  return '<div class="flex-container"> <div class="title"> <h6><a href="list.php?id=' + newList.id + '">' + newList.title + '</a></h6>' +
  '</div><div class="deleteList"><i class="fa fa-times"></i>'+
  '</div></div><p>' + newList.creationDate + '</p>' +
  '<p><i style="color: #' + newList.color + '" class="fa fa-circle"></i> ' + newList.name + '</p></div>';

}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}
