<?php
/* Route example */

$route = new Route('Index'); // Creating a route with a controller, the model will be extracted by the getModel method

$route->add('index.html',function(){ // When the url is index.html -> call Closure
  echo 'Hello world';
});

$route->add(array('article-{id}.html','id' => '[0-9]+') // When trying to read an article, get it and show it
  ,Query('getArticle',Get('id')),Action('showArticle')); // Calling model method getArticle and giving result to controller method showArticle

$route->add(array('articles.html/{page?}','page' => '[0-9]+') // When trying to read articles in a page (page is optional get parameter and "/" is too automatically)
  ,Query('getArticles', // Calling model method with page number, if can't read Get('page'), returning 0 (first page)
    array(Get('page'),
    QUERY_ELSE => 0)),Action('showArticles')); // Then feeding the result to showArticles method

$route->add('article-create', // When creating an article
  Permission(), // Loading the 'permission.php' file and testing the permission, if it fails, stops everything and redirects to permission error (default behavior)
  Event('getFormEvent', // Getting the form event from the controller
    array(Query('newArticle',Get('name')),Action('showArticle'), // If the form is complete, showing the created article
  EVENT_ELSE => Action('writeArticle')))); // // If the form isn't completed, show the writeArticle form

return $route;
?>
