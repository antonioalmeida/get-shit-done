'use strict';

function showSimilarUsers(name) {
    if(name === '') {
        showNoUsers();
        return;
    }

    let request = new XMLHttpRequest();
    let DOMString = './actions/action_get_similar_users.php?' + encodeForAjax({'name': name});
    request.open('get', DOMString, true);
    request.addEventListener('load', showSimilarUsersFinished);
    request.send();
}

function showNoUsers() {
    searchResults.innerHTML = '';
}

function showSimilarUsersFinished() {
    let allNames = JSON.parse(this.responseText);
    showNoUsers();
    searchResults.innerHTML += '<ul>';
    for(let id in allNames)
        searchResults.innerHTML += '<li class="no-bullets"><a href=./userprofile.php?username='+allNames[id].username+'>@'+allNames[id].username+'</a></li>';
    searchResults.innerHTML += '</ul>';
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}
