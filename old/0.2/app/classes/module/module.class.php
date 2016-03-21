<?php
/* A module */
namespace module;

class module
{
  protected $name; // module name
  protected $dir; // the dir in which the module is in
  public $template; // the main template
  public $call_center; // the call center

  public function __construct($name) // creates a module object
  {
    $this->name = $name;
    $this->call_center = new \module\instructions\call($name);
    $this->template = new \view\template();
  }
  public function set_dir($dir) // the dir in which the module's in
  {
    $this->dir = $dir;
  }
  public function dir() // returns the module's files dir
  {
    return $this->dir;
  }
  public function loop_with_func($vars,$func,$tid = false,$times = false) // runs the template multiple times using a function
  {

  }
  public function loop($vars,$tid = false,$times = false) // runs the template multiple times
  {

  }
  public function run() // runs the module
  {
    echo $this->template->display();
  }
}
?>
