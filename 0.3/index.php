<?php
/* SIMPHPLE - VERSION : 0.3 */

include_once 'simPHPle/simPHPle.php';

$admin_permission = new \security\permission();

global $app;
$app = new simPHPle();
/*
$app->create_route('index',array(
  'pattern' => array('index.html','','index','index.php',array('pattern' => 'about','files' => 'about.php')),
  'files' => 'index.php'
));

$app->create_route('style',array(
  'pattern' => '{[modstyle]}.css',
  'files' => 'index.php'
));

$app->create_route('articles',array(
  'files' => 'index.php',
  'first_pattern' => 'articles/{all}',
  'pattern' => array(
    array('pattern' => 'articles/pages/{id}','files' => 'show/page.php'),
    array('pattern' => 'articles/','files' => 'show/articles.php'),
    array('pattern' => 'articles/admin/edit_comment/{id}/{comment_id}','files' => 'admin/edit_comment.php','permission' => $admin_permission),
    array('pattern' => 'articles/admin/delete_comment/{id}/{comment_id}/{token}','files' => 'admin/delete_comment.php','permission' => $admin_permission->token('token')),
    array('pattern' => 'articles/admin/delete/{id}/{token}','files' => 'admin/delete.php','permission' => $admin_permission->token('token')),
    array('pattern' => 'articles/admin/edit/{id}','files' => 'admin/edit.php','permission' => $admin_permission),
    array('pattern' => 'articles/{y}/{m}/{d}/{[TITLE]}','files' => 'show/article.php'),
    array('pattern' => 'articles/admin','files' => 'admin/index.php'),
    array('pattern' => 'articles/admin/new','files' => 'admin/new.php','permission' => $admin_permission)
)));
*/
$app->create_route('test',array('pattern' => 'index.html'));
$GLOBALS['test']->link(function(){return 'hello world';},function($args){echo $args;});

$app->exec();
?>
