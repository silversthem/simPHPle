<?php
/* SIMPHPLE - VERSION : 0.3 */

include_once 'app/simPHPle.php';

$membre_permission = new \security\permission();
$moderator_permission = new \security\permission();
$admin_permission = new \security\permission();

global $app;
$app = new simPHPle();

$app->create_route('index',array(
  'pattern' => array('index.html','','index','index.php',array('pattern' => 'about','files' => 'about.php')),
  'files' => 'index.php'
));

$app->create_route('style',array(
  'pattern' => '{[modstyle]}.css',
  'files' => 'index.php'
));

$app->create_route('members',array(
  'first_pattern' => 'members/',
  'pattern' => array(
    array('pattern' => array('members/search','members/search{[params]}'),'files' => 'search.php'),
    array('pattern' => 'members/','files' => 'list.php'),
    array('pattern' => 'members/view/{type}','files' => 'list_specific.php'),
    array('pattern' => 'members/{id}','files' => 'profile/view.php'),
    array('pattern' => 'members/{id}/ban/{token}','files' => 'profile/ban.php','permission' => $moderator_permission),
    array('pattern' => 'members/me','files' => 'profile/user.php','permission' => $membre_permission),
    array('pattern' => 'members/me/edit','files' => 'profile/user_edit.php','permission' => $membre_permission),
    array('pattern' => 'members/me/delete/{token}','files' => 'profile/user_delete.php','permission' => $membre_permission)
)));

$app->create_route('forum',array(
  'first_pattern' => 'forum/',
  'pattern' => array(
    array('pattern' => 'forum/','files' => 'list.php'),
    array('pattern' => array('forum/search{[params]}','forum/search'),'files' => 'search.php'),
    array('pattern' => 'forum/new','files' => 'cat/new.php','permission' => $admin_permission),
    array('pattern' => 'forum/delete/{cat}/{token}','files' => 'cat/delete.php','permission' => $admin_permission),
    array('pattern' => 'forum/move/{cat}/{id}/{newcat}','files' => 'thread/move.php','permission' => $moderator_permission),
    array('pattern' => 'forum/{cat}','files' => 'cat/list.php'),
    array('pattern' => 'forum/{cat}/{id}/answer','files' => 'thread/answer/new.php','permission' => $membre_permission),
    array('pattern' => 'forum/{cat}/{id}/answer/{aid}/edit','files' => 'thread/answer/edit.php','permission' => $membre_permission),
    array('pattern' => 'forum/{cat}/{id}/answer/{aid}/delete/{token}','files' => 'thread/answer/delete.php','permission' => $membre_permission),
    array('pattern' => 'forum/{cat}/{id}/answer','files' => 'thread/answer/new.php','permission' => $membre_permission),
    array('pattern' => 'forum/{cat}/{id}/edit','files' => 'thread/edit.php','permission' => $membre_permission),
    array('pattern' => 'forum/{cat}/{id}/delete/{token}','files' => 'thread/delete.php','permission' => $membre_permission),
    array('pattern' => 'forum/{cat}/{id}/{[name]}','files' => 'thread/view.php'),
    array('pattern' => 'forum/{cat}/new','files' => 'thread/new.php','permission' => $membre_permission)
  ),
  'files' => 'index.php'
));

$app->exec();
?>
