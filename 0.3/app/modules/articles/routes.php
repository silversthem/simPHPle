<?php
/* The article's routes */
global $app;
global $admin_permission;
/*
$app->create_route('articles',array(
  'first_pattern' => 'articles/{all}',
  'pattern' => array(
    array('pattern' => 'articles/pages/{id}','query' => new \model\query('article_query','pageExists')),
    array('pattern' => 'articles/','couple' => array(new \model\model('article'),new \view\view('article_view')),'action' => array('getLastArticles','showLastArticles')),
    array('pattern' => 'articles/admin/edit_comment/{id}/{comment_id}','query' => new \model\query('article_query','commentExists'),'permission' => $admin_permission),
    array('pattern' => 'articles/admin/delete_comment/{id}/{comment_id}/{token}','query' => new \model\query('article_query','commentExists'),'permission' => $admin_permission->token('token')),
    array('pattern' => 'articles/admin/delete/{id}/{token}','query' => new \model\query('article_query','articleExists'),'permission' => $admin_permission->token('token')),
    array('pattern' => 'articles/admin/edit/{id}','query' => new \model\query('article_query','commentExists'),'permission' => $admin_permission),
    array('pattern' => 'articles/{y}/{m}/{d}/{[TITLE]}','query' => new \model\query('article_query','articleExists')),
    array('pattern' => 'articles/admin','form' => new \handling\form\loader('login','articles')),
    array('pattern' => 'articles/admin/new','form' => new \handling\form\loader('admin_form','articles'),'permission' => $admin_permission)
)));*/
?>
