<?php

use App\Libraries\Authentication;

if(!function_exists('current_user')){
    function current_user(){
     $auth = service('auth');
      return $auth->getCurrentUser();
    }
}
if(!function_exists('current_userRole')){
  function current_userRole(){
    $auth = service('auth');
    return $auth->getUserRole();
  }
}