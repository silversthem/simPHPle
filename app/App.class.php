<?php
/*

*/

class Website extends App {
  public function routes($router) {
    $router->path('blog/','blog.Blog');
  }
}
