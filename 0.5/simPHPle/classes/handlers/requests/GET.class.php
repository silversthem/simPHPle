<?php
/*
  Class
  Used to make get requests
  Can also be used statically
*/

namespace handlers\requests;

class GET extends \handlers\requests\Request implements \IHandler
{
  public function __construct($name,$default = NULL,$escape = true) // Creates a get request
  {
    $this->set_up($name,$default,$escape);
  }
  public static function Read($var,$defaultVal = NULL) // Gets a variable content
  {
    return (array_key_exists($var,$_GET)) ? $_GET[$var] : $defaultVal;
  }
  public function get() // Returns the variale or its substitute
  {
    return self::Read($this->name,$this->defaultvalue);
  }
}
?>
