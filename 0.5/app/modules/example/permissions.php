<?php
/* Permission creation */

$admin = new Permission(); // Creates a permission

$admin->set_condition(function(){ // Condition to test if the permission is valid
  return isset($_SESSION['admin']);
});

$admin->set_granted(function(){ // Function granting the permission
  $_SESSION['admin'] = true;
});

$admin->set_deleted(function(){ // Function to delete the permission
  if(isset($_SESSION['admin'])) unset($_SESSION['admin']);
});

return $admin;
?>
