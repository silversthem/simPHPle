<?php
/* Handles the admin part of modules */

session_start();

$admin = new module('admin');
$admin->load_template(dirname(__FILE__).'/template.tpl');

if(isset($_SESSION['admin'])) // if connected
{
  $admin->set_template_arguments(true,'main_screen');
}
else // ask for connection
{
  $admin->set_template_arguments(true,'login_screen');
}

$admin->run();
?>
