'use strict';

let closeButton = document.querySelector('.close-button');
closeButton.addEventListener('click', function() {
    let bottomAlerts = document.getElementById('bottomAlerts');
    bottomAlerts.classList.add('hidden');
});

function setAlertMessage(type, message) {
    let bottomAlerts = document.getElementById('bottomAlerts');
    let alertMessage = bottomAlerts.querySelector('.alert-message');
    alertMessage.innerHTML = message;

    if(type == 'error') {
        bottomAlerts.classList.remove('alert-success'); 
        bottomAlerts.classList.add('alert-error'); 
    }
    else if(type == 'success') {
        bottomAlerts.classList.remove('alert-error'); 
        bottomAlerts.classList.add('alert-success'); 
    }

    bottomAlerts.classList.remove('hidden');
}

