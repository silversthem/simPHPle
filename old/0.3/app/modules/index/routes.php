<?php
/* The index module routes */
global $app;
$app->create_route('index',array(
  'pattern' => array(
    array('pattern' => array('index.html','','index','index.php'),
      'couple' => array(new model\model('article'),new view\view('index')),
      'action' => array(array('getLastArticles','getPageAmount'),'exec')),
    array('pattern' => 'about','files' => 'about.php')
)));
?>
