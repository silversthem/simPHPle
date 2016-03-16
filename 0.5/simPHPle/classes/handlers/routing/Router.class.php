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

  }
  public function dependencies() // Loads dependencies
  {

  }
  public function get() // Gets the right controller
  {
    
  }
}
?>
