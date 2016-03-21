<?php
/*
  Class
  Returns a controller based on url
  If there's no controller to return, throws an exception
*/

namespace handlers\routing;

class Route implements \routing\IRoute
{
  protected $patterns = array(); // An array containing patterns and the pile
  public $loader; // The loader for the controller if the route matches

  public function __construct($module = 'Anonymous',$controller = NULL/*, Other objects to load in module */) // Creates a route
  {
    $this->loader = new \loaders\Controller($module,$controller);
  }
  public function add($pattern/*, Pile */) // Adds a pattern to the route, followed by a pile of actions to be done
  {
    $pile = func_get_args();
    unset($pile[0]);
    $p = new \routing\Pattern($pattern,$pile);
    $this->patterns[] = $p;
  }
  public function valid($url) // If the route is valid
  {
    $pattern = \Launcher::valid_in_objects($this->patterns,'valid',$url);
    if(!is_null($pattern))
    {
      $this->loader->add_pile($pattern->get_pile());
      return true;
    }
    return false;
  }
  public function get() // Gets the controller
  {
    return $this->loader;
  }
}
?>
