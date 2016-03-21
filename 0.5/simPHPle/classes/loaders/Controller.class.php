<?php
/*
  Class
  Creates a controller pile
*/

namespace loaders;

class Controller implements \ILoader
{
  protected $controller; // Controller
  protected $modfile; // Module file
  protected $to_load_classes = array('Controller' => NULL); // Classes to load

  public function __construct($module,$controller = NULL) // Creates a controller pile
  {
    $this->modfile = USER_MODULES_FOLDER.'/'.$module;
    $this->controller = new \collections\Controller();
    if(!is_null($controller)) // Defined controller
    {
      if(is_string($controller)) // Is a class from module
      {
        $this->to_load_classes['Controller'] = new \loaders\Object($controller,$this->modfile);
      }
    }
  }
  public function add_class($class) // Adds classes to the pile of things to be loaded
  {
    $this->to_load_classes[] = new \loaders\Object($class);
  }
  public function add_pile($pile) // Adds a pile to the pile
  {
    foreach($pile as $element)
    {
      $this->add_to_pile($element);
    }
  }
  public function add_to_pile($element) // Adds an element to the pile
  {
    $this->controller->add($element);
  }
  protected function set_controller() // Sets the controller's object for the pile
  {
    if($this->to_load_classes['Controller'] instanceof \ILoader)
    {
      $this->controller->set_controller($this->to_load_classes['Controller']->load());
    }
    else
    {
      $this->controller->set_controller($this->to_load_classes['Controller']);
    }
    unset($this->to_load_classes['Controller']);
  }
  public function load() // Returns the created controller and pile
  {
    $this->set_controller();
    foreach($this->to_load_classes as $loader) // Loading all classes and giving them to the controller pile
    {
      $this->controller->add_object($loader->load());
    }
    return $this->controller;
  }
}
?>
