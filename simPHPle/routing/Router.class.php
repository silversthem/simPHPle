<?php
/*

*/

namespace routing;

class Router {
  /* Attributes */
  protected $routes = [];  // Routes
  protected $path; // Path to current router

  public function __construct($path = '') { // Creating a router
    $this->path = $path;
  }
  /* Route factories */
  public function url($pattern,$action,$name = NULL) { // Adds a route from a pattern and an action
    $pattern = (is_string($pattern)) ? new \URLPattern($pattern,$this->path) : $pattern;
    $this->add_route(new \Route($pattern,$action),(is_null($name) && is_string($action) ? $action : $name));
    // If action is a string but name is null, action becomes name
  }
  public function path($pattern,$action,$name = NULL) { // Adds an open ended route
    $pattern = (is_string($pattern)) ? new \URLPattern($pattern,$this->path) : $pattern;
    $pattern->open_end(); // Allows url to extend further than the path
    $this->add_route(new \Route($pattern,$action),(is_null($name) && is_string($action) ? $action : $name));
  }
  /* Methods */
  public function add_route($route,$routename = NULL) { // Adding a route
    if(is_null($routename)) {
      $this->routes[] = $route;
    } else {
      $this->routes[$routename] = $route;
    }
  }
  public function call($routename) { // Calls a route
    if(array_key_exists($routename,$this->routes)) {
      return $this->routes[$routename];
    }
  }
  public function find_route($request) { // Returns route matching request
    foreach($this->routes as $route) {
      if($route->match($request)) { // Found correct route
        // $request->set_path();
        return $route;
      }
    }
    return false;
  }
}
