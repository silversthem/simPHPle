<?php
/*
  Class
  Used to executes methods on objects in ObjectCollection
*/

class Method
{
  protected $method; // Method
  protected $arguments; // Arguments
  protected $class; // Class on which to apply the method

  public function __construct($method,$class,$argument = array()) // creates a Method
  {
    $this->method = $method;
    $this->class = $class;
    $this->arguments = $argument;
  }
  public function name()
  {
    return $class;
  }
  public function init(&$collection) // initializes the method
  {

  }
  public function launch(&$context) // launches a method
  {

  }
}
?>
