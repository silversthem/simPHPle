<?php
/*
  Class
  Used to make Post request
  Can also be used statically
*/

namespace handlers\requests;

class POST extends \handlers\requests\Request implements \IHandler
{
  public function __construct($name,$default = NULL,$escape = true) // Creates a post request
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
