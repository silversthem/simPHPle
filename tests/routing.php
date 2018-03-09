<?php

include '/var/www/htdocs/simPHPle/simPHPle/autoloader.php';
include '/var/www/htdocs/simPHPle/simPHPle/aliases.php';

// Adding two url parameters
function test0($url) {
  /* Test request */
  $request = new HTTPRequest($url);
  /* Test pattern */
  $pattern = new URLPattern('add/{a:int}/{b:int}');
  /* Creating the route */
  $route = new Route($pattern,function($request) {
    list($a,$b) = $request->url('a','b');
    return $a + $b;
  });
  /* Creating the router */
  $router = new Router();
  $router->add_route($route);
  $r = $router->find_route($request);
  echo ($r !== false) ? $r->call($request) : 'Failed !';
}

// Getting a message from id
function test1($url) {
  $request = new HTTPRequest($url);
  $router = new Router();
  $router->path('api/{key}',function($request) {
    $sub_router = new Router($request->path());
    $sub_router->url('get_message/{id}',function($request) {
      echo 'Returning message '.$request->url('id');
    });
    $rp = $sub_router->find_route($request);
    echo ($rp !== false) ? $rp->call($request) : 'Failed !';
  });
  $r = $router->find_route($request);
  echo ($r !== false) ? $r->call($request) : 'Failed !';
}

test0('add/3/-7');echo "\n";
test1('api/some_key/get_message/52');echo "\n";
