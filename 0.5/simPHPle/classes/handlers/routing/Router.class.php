<?php
/*
  Class
  Handles routes and returns the right controller
  If there's no right controller, throws an exception
*/

namespace handlers\routing;

class Router implements \IHandler
{
  protected $url; // Url to route from
  protected $routes = array(); // routes

  const MAKE_URL = 0; // Tells the router to create its own url from config file + server info

  public function __construct($url = self::MAKE_URL) // Creates a router
  {
    $this->url = ($url == self::MAKE_URL) ? $this->make_url() : $url;
  }
  public static function dependencies() // Loads router dependencies
  {

  }
  protected function make_url() // Makes url from server and config file
  {
    return str_replace(BASE_DIR,'',$_SERVER['REQUEST_URI']);
  }
  public function add_route($route) // Adds a route to the router
  {
    $this->routes[] = $route;
  }
  public function add_a_route() // Adds an anonymous route quickly
  {
    $r = new \Route();
    call_user_func_array(array($r,'add'),func_get_args());
    $this->add_route($r);
  }
  public function get() // Gets the right controller
  {
    foreach($this->routes as $route)
    {
      if($route->valid($this->url))
      {
        // TODO : Add backtrace
        return $route->get(); // Returns loader for a controller
      }
    }
    // We made it this far => 404
  }
}
?>
