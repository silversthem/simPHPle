<?php
/* SIMPHPLE - VERSION : 0.3 */

include_once 'simPHPle/simPHPle.php';

global $admin_permission;
$admin_permission = new \security\permission();
$admin_permission->set_function(function(){
  if(isset($_SESSION) && array_key_exists('admin',$_SESSION) && $_SESSION['admin'] == true){return true;}return false;});

global $app;
$app = new simPHPle();

load_module_routes('index','routes');
load_module_routes('articles','routes');
load_module_routes('style','routes');

$app->exec();
?>
