<?php
/*
  Class
  Handles http requests with router
*/

namespace launchers;

class App implements \ILauncher
{
  public $router; // App's router

  public function __construct() // Creates an app
  {
    $this->router = new \Router();
  }
  public static function dependencies() // Loads dependencies
  {
    \loaders\Loader::load_interface('routing/IRoute');
    \loaders\Loader::load_interface('controllers/IQuery');
    \loaders\Loader::load_interface('controllers/IEvent');
  }
  public function load_route($module,$file = 'route.php') // Loads route in a file
  {

  }
  public function exec() // Runs the app
  {
    // TODO : Add backtrace, and change execution to \Launcher::boot($this->router->get())
    $loader = $this->router->get();
    if($loader instanceof \ILoader)
    {
      $controller = $loader->load();
      $controller->exec();
    }
    else
    {
      // Error 500 => Nothing found
    }
  }
}
?>
