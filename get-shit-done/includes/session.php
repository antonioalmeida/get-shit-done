<?php
   session_start();

   if (!isset($_SESSION['csrf'])) {
     $_SESSION['csrf'] = generate_random_token();
   }
   // session_regenerate_id(true);

   function setCurrentUser($username) {
     $_SESSION['username'] = strtolower($username);
 }

 function generate_random_token() {
  return bin2hex(openssl_random_pseudo_bytes(32));
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
