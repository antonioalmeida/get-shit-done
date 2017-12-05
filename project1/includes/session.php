<?php

   session_set_cookie_params(0, '/', 'www.fe.up.pt', true, true);
   session_start();
   // session_regenerate_id(true);

   function setCurrentUser($username) {
     $_SESSION['username'] = $username;
 }

  function getErrorMessages() {
    if (isset($_SESSION['error_messages']))
      return $_SESSION['error_messages'];
     else
       return array();
   }

   function getSuccessMessages() {
     if (isset($_SESSION['success_messages']))
       return $_SESSION['success_messages'];
     else
       return array();
   }

   function clearMessages() {
     unset($_SESSION['error_messages']);
     unset($_SESSION['success_messages']);
   }
 ?>
