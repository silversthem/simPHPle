<?php
/* The router reads a url and returns a connected module */

namespace routing;

load_interface('router');

class router implements \irouter
{
  protected $routes = array(); // the routes in the router
  protected $url; // the url the router will use
  protected $options = array(); // options

  const MAKE_URL = 1; // tells the router to generate the url from BASE_DIRECTORY

  public function __construct($url = router::MAKE_URL) // creates a router
  {
    if($url == router::MAKE_URL)
    {
      $this->set_url();
    }
    else
    {
      $this->url = $url;
    }
  }
  protected function set_url() // sets the url to the one detected by the server
  {
    $this->url = str_replace(BASE_DIRECTORY,'',$_SERVER['REQUEST_URI']);
  }
  public function add_route($route) // adds a route to the pile to be read
  {
    $this->routes[] = $route;
  }
  public function add_routes($routes) // adds routes
  {
    if(is_array($routes)) // an array of routes
    {
      if(func_num_args() == 1) // one array
      {
        foreach($routes as $route)
        {
          $this->routes[] = $route;
        }
      }
      else // multiple things
      {
        $args = func_get_args();
        foreach($args as $arg)
        {
          $this->add_routes($arg);
        }
      }
    }
    elseif(is_object($routes)) // first element is a route
    {
      if(func_num_args() == 1) // only a route to add
      {
        $this->routes[] = $routes;
      }
      else // multiple elements
      {
        $args = func_get_args();
        foreach($args as $arg)
        {
          $this->add_routes($arg);
        }
      }
    }
  }
  public function exec() // starts the router, returning the module corresponding to the url
  {
    foreach($this->routes as $route)
    {
      if($route instanceof \iroute)
      {
        $result = $route->test_url($this->url);
        if($result instanceof \modules\module) // if the route corresponds
        {
          return $result; // tells which files are to be loaded
        }
      }
    }
    return array();
  }
}
?>
