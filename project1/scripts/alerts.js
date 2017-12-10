'use strict';

let alerts = document.getElementById('alerts');

function setAlertMessage(type, message) {
	if(type == 'error') {
		alerts.classList.remove('alert-success');	
		alerts.classList.add('alert-error');	
	}
}