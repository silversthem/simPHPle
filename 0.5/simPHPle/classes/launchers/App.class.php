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
    // Loads router dependencies
    // Loads all controllers related
  }
  public function load_route($module,$file = 'route.php') // Loads route in a file
  {
    
  }
  public function exec() // Runs the app
  {

  }
}
?>
