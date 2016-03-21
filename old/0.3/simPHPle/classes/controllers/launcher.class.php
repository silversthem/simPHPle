<?php
/* The launcher can use a router to load module, it's the class to use when taking care of modules */

namespace controllers;

class launcher
{
  public $router; // the router object
  protected $modules = array(); // the modules to be called

  public function __construct() // creates a launcher
  {

  }
  public function set_router($router) // sets a router to the launcher
  {
    $this->router = $router;
  }
  public function init() // launches the router, loading all the modules to be loaded
  {
    $router_module = $this->router->exec();
    if(is_string($router_module) && array_key_exists($router_module,$GLOBALS) && $GLOBALS[$router_module] instanceof \modules\module)
    {
      $this->modules[] = $GLOBALS[$router_module];
    }
    else
    {
      // something's wrong
    }
  }
  public function add_module($module) // adds a module to load
  {
    $this->modules[] = $module;
  }
  protected function load_modules() // loads the modules
  {
    foreach($this->modules as $module)
    {
      $module->exec();
    }
  }
  public function start() // loads all the modules
  {
    $this->load_modules();
  }
}
?>
