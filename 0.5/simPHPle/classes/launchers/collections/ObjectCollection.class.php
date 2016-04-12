<?php
/*
  Class
  A collection of method applied to an object
  Note : ObjectCollections can be created using the appropriate loader, it's much easier that way
*/

namespace launchers\collections;

class ObjectCollection extends \collections\Collection
{
  use \ComponentException;

  protected $objects; // the object in the collection
  protected $pile; // the methods applied to the object

  public function __construct(/* Objects */) // creates an object collection
  {
    $this->exception_set_up('ObjectCollection');
  }
  public function add_object(&$object) // Adds an object
  {
    $this->objects[get_class($object)] = $object;
  }
  protected function launch($element,$arguments,$memoized) // Launches methods + all generic types
  {
    if($element instanceof \launchers\launched\Method)
    {
      if(array_key_exists($element->name(),$this->objects))
      {
        $element->init($arguments,$memoized);
        return $element->launch($this->objects[$element->name()]);
      }
      else
      {
        $this->exception('Trying to call method on non object',\fException::ERROR,$element->name(),$element->method());
      }
    }
    else
    {
      return parent::launch($element,$arguments,$memoized);
    }
  }
}
?>
