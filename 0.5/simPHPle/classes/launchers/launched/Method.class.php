<?php
/*
  Class
  Used to executes methods on objects in ObjectCollection
*/

namespace \launchers\launched;

class Method extends \launchers\launched\Function
{
  protected $method; // Method
  protected $class; // Class on which to apply the method

  public function __construct($method,$class,$argument = array()) // creates a Method
  {
    $this->method = $method;
    $this->class = $class;
    $this->arguments = $argument;
  }
  public function name() // Class on which this methods apply
  {
    return $this->class;
  }
  public function method() // Returns method name
  {
    return $this->method;
  }
  public function init(&$context) // initializes the method
  {
    // Check for class existence
    parent::init($context);
  }
  public function launch(&$context) // launches a method
  {
    return call_user_func_array(array($context,$this->method),$this->arguments);
  }
}
?>
