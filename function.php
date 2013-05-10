<?php
//error handler function
function customError($errno, $errstr)
 { 
 error_log("Error: [$errno] $errstr",3,'error.log');
}
//set error handler
set_error_handler("customError",E_ALL);

trigger_error("User error !!!",E_USER_WARNING);
?>
