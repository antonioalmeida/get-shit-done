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

function showSimilarUsersDiscover(name) {
    if(name === '') {
        showNoUsers();
        return;
    }

    let request = new XMLHttpRequest();
    let DOMString = './actions/action_get_similar_users.php?' + encodeForAjax({'name': name});
    request.open('get', DOMString, true);
    request.addEventListener('load', showSimilarUsersDiscoverFinished);
    request.send();
}

function showNoUsers() {
    searchResults.innerHTML = '';
}

function showSimilarUsersFinished() {
    let allNames = JSON.parse(this.responseText);
    showNoUsers();
    for(let id in allNames) {
        let result = document.createElement('p');
        result.addEventListener('click', updateUsernameValue);
        result.innerHTML = '@'+allNames[id].username;
        searchResults.append(result);
    }
}

function showSimilarUsersDiscoverFinished() {
    let allNames = JSON.parse(this.responseText);
    showNoUsers();
    for(let id in allNames) {
        let result = document.createElement('p');
        result.innerHTML = '<a href=/userprofile.php?username='+allNames[id].username+'>@'+allNames[id].username+'</a>';
        searchResults.append(result);
    }
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}

function updateUsernameValue(event) {
    let addMember = document.querySelector('input[name=addAdminUsername]');
    let username = event.target.innerHTML.substr(1);
    addMember.value = username;
}
