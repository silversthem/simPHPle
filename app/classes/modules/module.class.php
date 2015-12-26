<?php
/* A module is a piece of the application */

namespace modules;

class module
{
  protected $views = array(); // the views linked
  protected $models = array(); // the models of the module
  protected $name; // the directory name
  protected $path; // the path to the module's dir

  public function __construct($name,$path) // creates a module
  {

  }
  public function exec() // executes the module, loading the views, models and so on
  {
    
  }
}
?>
