<?php 

if(!function_exists('dispalyErrorClass')){
    function dispalyErrorClass($validationErrors, $field){
        if (session()->has($validationErrors) && isset(session($validationErrors)[$field])){
            return "is-invalid";
        }
    }
}
if(!function_exists('dispalyValidatorErrorClass')){
    function dispalyValidatorErrorClass($validationErrors, $field){
        if (isset($validationErrors) && $validationErrors->hasError($field)){
            return "is-invalid";
        }
    }
}

if(!function_exists('dispalyValidatorErrorMessage')){
    function dispalyValidatorErrorMessage($validationErrors, $field){
        if (isset($validationErrors) && $validationErrors->hasError($field)){
            return $validationErrors->getError($field);
        }
    }
}

if(!function_exists('dispalyErrorMessage')){
    function dispalyErrorMessage($validationErrors, $field){
        
        if (session()->has($validationErrors) && isset(session($validationErrors)[$field])){
            return session($validationErrors)[$field];
        }
    }
}