<?php

class Component0 {
  public function routes($routes) {
    $routes->url('welcome','welcome');
    $routes->url('hello/{name}','hello');
  }
  public function welcome() {
    return 'Hi !'."\n";
  }
  public function hello($name) {
    return 'Hello '.$name."\n";
  }
}

class App0 {
  public function routes($routes) {
    $routes->path('say/','Component0');
  }
}
