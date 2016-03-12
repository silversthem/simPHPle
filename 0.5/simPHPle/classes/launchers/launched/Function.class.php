<?php
/*
  Class
  Handles a function in a collection
*/

namespace \launchers\launched;

class Function implements \collections\ILaunched
{
  protected $func; // function
  protected $arguments; // arguments

  public function __construct($func,$arguments = array()) // creates a Function
  {
    $this->func = $func;
    $this->arguments = $arguments;
  }
  public function name() // returns name
  {
    return 'Function';
  }
  public function init(&$collection) // initializes the script
  {

  }
  public function launch(&$context) // launches the function
  {
    return call_user_func_array($this->func,$this->arguments);
  }
}
?>
