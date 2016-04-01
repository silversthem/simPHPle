<?php
/*
  Abstract class
  Common methods used mostly by get and post requests
  Mostly default value stuff and escaping
*/

namespace handlers\requests;

abstract class Request implements \IHandler
{
  protected $name; // Request name
  protected $infos; // @TODO
  protected $defaultvalue; // Value if the request doesn't contain anything
  protected $escape; // Escape content
  protected $sql_protect; // @TODO

  public function set_up($name,$defaultvalue = NULL,$escape = true,$sql_protect = true) // Sets up a request, used by its children to go faster
  {
    $this->set_name($name);
    $this->set_default_value($v);
    $this->escape($escape);
    $this->sql_protect($sql_protect);
  }
  public function set_name($n) // Sets request name
  {
    $this->name = $n;
  }
  public function set_default_value($v) // Sets request default value
  {
    $this->defaultvalue = $v;
  }
  public function get_default_value() // Returns default value
  {
    return $this->defaultvalue;
  }
  public function escape($escape = true) // Whether to escape or not
  {
    $this->escape = false;
  }
  public function sql_protect($protect = true) // Whether to "protect" the database from this request
  {
    $this->sql_protect = $protect;
  }
  public static function get_escaped($text) // Escaping a text
  {
    return htmlspecialchars($text);
  }
  public static function get_sql_protected($p) // Gets sql escaped text
  {
    // @TODO
    return $p;
  }
  protected function handle($text) // returns text with appropriate options
  {
    if($this->escape)
    {
      $text = self::get_escaped($text);
    }
    if($this->sql_protect)
    {
      $text = self::get_sql_protected($text);
    }
    return $text;
  }
  abstract public function get(); // Can't get anything

}
?>
