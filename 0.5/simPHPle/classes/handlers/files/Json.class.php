<?php
/*
  Referencial Class
  Used to read and write in json files
*/

namespace handlers\files;

class Json implements \Iterator,\ArrayAccess
{
  protected $filename; // file opened
  protected $array; // array contained in file

  use \Referencial; // makes the class referencial
  use \ArrayAccessor; // methods for iterator and ArrayAccess

  public function __construct($file) // creates a json object
  {
    $this->filename = $file;
    try
    {
      $this->array = json_decode(File::read($this->filename),true);
    }
    catch(\fException $e)
    {
      $this->array = array();
    }
    $this->set_up_array($this->array);
  }
  public static function open($file) // opens a file
  {
    $json = new self($file);
    return $json;
  }
  protected function ref_save() // closes a file, saving changes
  {
    File::save($this->filename,json_encode($this->array));
  }
  protected function ref_set($key,$value) // sets a key to value in array
  {
    $this->array[$key] = $value;
  }
  protected function ref_add($value) // adds a value in array
  {
    $this->array[] = $value;
  }
  public function get($key) // gets value in array
  {
    return (array_key_exists($this->array,$key)) ? $this->array[$key] : NULL;
  }
}
?>
