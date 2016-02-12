<?php
/*
* simPHPle 0.4 controller.class.php : Class
* Loads a controller
*/

namespace loaders\routing;

class Controller implements \ILoader
{
  use \Options;

  const UNDEFINED = 'undefined'; // when the controller is going to be defined later

  protected $controller; // controller object

  public function __construct($controller = self::UNDEFINED) // creates a controller loader
  {
    $this->controller($controller);
    $this->set_option('actions',array());
  }
  public static function create($a) // creates a controller from another
  {

  }
  public function set_controller($controller) // sets object controller
  {
    if($controller == self::UNDEFINED)
    {
      $this->controller = new \Controller(NULL,NULL);
    }
    else
    {
      $this->controller = $controller;
    }
  }
  public function load() // returns an object executor with the controller and methods to execute
  {
    if($this->controller instanceof \ILoader) // controller has to be loaded
    {
      $this->controller = \Launcher::boot($this->controller);
    }
  }
}
?>
