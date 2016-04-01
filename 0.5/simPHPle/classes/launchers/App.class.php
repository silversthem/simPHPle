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
    \loaders\Loader::load_interface('events/IQuery');
    \loaders\Loader::load_interface('events/IEvent');
    \loaders\Loader::load_helper('controllers');
  }
  public function load_route($module,$file = 'route.php') // Loads route in a file
  {
    if(file_exists($route_file = USER_MODULES_FOLDER.'/'.$module.'/'.$file))
    {
      // @TODO : use loader method for backtrace
      $this->router->add_route(include $route_file);
    }
    else
    {
      throw new \fException('App component',\fException::FATAL,'Couldn\'t load route file',$file,$this);
    }
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
