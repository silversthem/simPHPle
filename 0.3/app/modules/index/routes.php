<?php
/* The index module routes */
global $app;
$app->create_route('index',array(
  'pattern' => array(
    array('pattern' => array('index.html','','index','index.php'),'couple' => array(NULL,'index.php')),
    array('pattern' => 'about','files' => 'about.php')
)));
?>
