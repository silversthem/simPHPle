<?php
include_once 'config.php'; // loads configuration
include_once 'app/classes/launcher.class.php'; // loads launcher class

spl_autoload_register(array('launcher','load_class'));

$launcher = new launcher();

$index = new route('index','index.html','index.php','');
$admin = new route('admin','admin','admin/{module}','admin/{module}/{option}','admin/{module}/{option}/{1}','admin/{module}/{option}/{1}/{[2]}');
$style = new route('style','{[css]}.css');

$launcher->gen_router($index,$admin);
$launcher->link($style,route::BEFORE);
$launcher->start();
?>
