<?php
/* A class that handles constructors */

namespace handling\constructors;

class handler
{
  protected $constructors = array('default' => NULL,'valid' => NULL,'error' => NULL); // the constructors
  protected $object; // the object that'll determine which constructor to use
  protected $method; // the method we'll use to determine which constructor to use

  public function __construct($object = NULL,$method = 'getEvent') // creates a handler
  {
    $this->object = $object;
    $this->method = $method;
    $this->constructors['default'] = new \modules\constructor();
  }
  public function add_method($method) // adds a method, if the method attribute is an array
  {
    if(is_array($this->method))
    {
      $this->method[] = $method;
    }
  }
  public function set_event_constructor($case,$constructor) // sets a constructor to a certain case
  {
    $this->constructors[$case] = $constructor;
  }
  public function merge_event_constructor($case,$constructor) // merges $constructor with the event constructor
  {
    if(array_key_exists($case,$this->constructors))
    {
      $this->constructors[$case]->merge($constructor);
    }
  }
  public function configure($a) // configures the handler from an array
  {
    foreach($a as $case => $elements)
    {

    }
  }
  public function get_constructor($case) // returns the constructor corresponding to the case
  {
    if(array_key_exists($case,$this->constructors))
    {
      return $this->constructors[$case];
    }
    else
    {
      return false;
    }
  }
  public function __get($case) // gets constructor
  {
    return $this->get_constructor($case);
  }
  public function __set($case,$value) // sets constructor
  {
    $this->set_event_constructor($case,$value);
  }
  public function exec() // returns the right constructor
  {
    if(is_object($this->object))
    {
      if(is_array($this->method))
      {
        $r = NULL;
        foreach($this->method as $method)
        {
          $r = $this->object->$method();
        }
        return $this->get_constructor($r);
      }
      else
      {
        $method = $this->method;
        if(method_exists($this->object,$method))
        {
          $case = $this->object->$method();
          return $this->get_constructor($case);
        }
        else
        {
          // ...
        }
      }
    }
    return $this->get_constructor('default'); // no constructor, returning default one ^^
  }
}
?>
