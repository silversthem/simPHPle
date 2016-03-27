<?php
/*
  Class
  Handles a function in a collection
*/

namespace launchers\launched;

class Closure implements \collections\ILaunched
{
  protected $func; // function
  protected $arguments; // arguments

  public function __construct($func,$arguments = array()) // creates a Function
  {
    $this->func = $func;
    $this->arguments = $arguments;
  }
  /* Arguments related methods */
  protected function argument_unshift($arg) // Adds argument to the pile
  {
    if(!is_null($arg))
    {
      array_unshift($this->arguments,$arg);
    }
  }
  protected function arguments_add($args) // Adds argument to the pile
  {
    if(!is_array($args))
    {
      $args = array($args);
    }
    $this->arguments = array_merge($this->arguments,$args);
  }
  /* Launched methods */
  public function init(&$context) // initializes the script
  {
    // Replace GET and POST requests by their values
    $this->argument_unshift($context);
  }
  public function launch(&$context) // launches the function
  {
    return call_user_func_array($this->func,$this->arguments);
  }
}
?>
