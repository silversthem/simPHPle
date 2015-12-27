<?php
/* The json class */
class json implements Iterator,ArrayAccess
{
  protected $file; // the file used to load/save
  protected $array; // the array

  public function __construct() // a new json object
  {

  }
  public function __set($k,$v) // sets $k to $v
  {

  }
  public function __get($k) // gets the key $k
  {

  }
  public function set_file($file) // sets the file
  {

  }
  public function set($k,$v) // sets $k to $v
  {

  }
  public function get($k) // gets the key $k
  {

  }
  public function exists($k) // if k exists
  {

  }
  public function load($file) // opens $file
  {

  }
  public function load_from_array($a) // load from an array
  {

  }
  public function save($erase = true) // saves changes in $this->file, if $erase = false then new elements will be added instead of destroying everything
  {

  }
  /* Iterator methods */
  public function current() // the current element
  {

  }
  public function key() // the key name
  {

  }
  public function next() // next element
  {

  }
  public function rewind() // starts the foreach
  {

  }
  public function valid() // if can keep going
  {

  }
  /* ArrayAccess methods */
  public function offsetGet($key) // read the element $key
  {

  }
  public function offsetSet($key,$value) // sets the element $key with $value
  {

  }
  public function offsetExists($key) // if $key exists
  {

  }
  public function offsetUnset($key) // deletes the element $key
  {

  }
}
?>
