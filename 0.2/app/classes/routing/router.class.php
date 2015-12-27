<?php
/*  the router */
namespace routing;

class router
{
  protected $routes = array(); // the list of routes to be read
  protected $displayroute = false; // the route containing the file that'll display everything
  protected $not_allowed_route = array(); // what to do when not allowed
  protected $error_404 = array(); // what to do when 404 error

  const ALL = 1;

  public function __construct() // creates a router
  {

  }
  public function set_display_route($route,$specific_file = 'display.php') // tells which route is used to display the stuff
  {
    $this->displayroute = array('route' => $route,'files' => $specific_file);
  }
  public function set_not_allowed_route($route,$file = 'error.php',$permission = router::ALL) // what to do when a permission isn't true
  {
    $this->not_allowed_route[$permission] = array('route' => $module,'files' => $file);
  }
  public function add_route($route) // adds a route to the pile
  {
    $this->routes[] = $route;
  }
  public function add_routes() // adds routes to the pile
  {
    $routes = func_get_args();
    foreach($routes as $route)
    {
      $this->add_route($route);
    }
  }
  public function set_routes($routes) // adds routes from an array
  {
    foreach($routes as $route)
    {
      $this->routes[] = $route;
    }
  }
  public function read_routes($url) // read the routes and tells what files are to be loaded
  {
    foreach($this->routes as $route) // reads the routes
    {
      $test = $route->test($url);
      if($test === \routing\route::NOT_ALLOWED) // permission error
      {
        // permission error
      }
      elseif($test != false) // if the route matches
      {
        return array('route' => $test,'display_route' => $this->displayroute);
      }
    }
    return $this->error_404;
  }
}
?>
