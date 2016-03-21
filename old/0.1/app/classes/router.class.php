<?php
/* The router loads the modules and creates the modules objects */
class router
{
  protected $routes; // list of 'route' objects
  protected $elements; // files and priority, things to load
  protected $url; // actual url

  const MAKE_URL = 1; // to make code clearer

  public function __construct($url = router::MAKE_URL,$routes) // creates the object
  {
    if($url == router::MAKE_URL) // find the current url
    {
      if(defined('BASE_DIRECTORY')) // if the directory the framework is in is defined
      {
        $this->url = str_replace('/'.BASE_DIRECTORY.'/','',$_SERVER['REQUEST_URI']);
      }
    }
    else
    {
      $this->url = $url;
    }
    $this->routes = $routes;
  }
  public function add_route($route) // adds a route to the pile
  {
    $this->routes[] = $route;
  }
  public function add_routes() // adds a routes to the pile
  {
    $routes = func_get_args();
    foreach($routes as $route)
    {
      $this->routes[] = $route;
    }
  }
  public function link_module($module,$place = route::BEFORE) // link a module to all the routes previously added
  {

  }
  public function link($route,$place = route::BEFORE) // link a route to all the routes previously added
  {
    foreach($this->routes as $Aroute)
    {
      $Aroute->link($route,$place);
    }
  }
  public function go() // reads the routes
  {
    $toLoad = array();
    foreach($this->routes as $route)
    {
      $a = $route->test($this->url);
      if($a !== false)
      {
        return $a;
      }
    }
  }
}
?>
