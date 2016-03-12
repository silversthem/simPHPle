<?php
/*
  Class
  A collection of method applied to an object
  Note : ObjectCollections can be created using the appropriate loader, it's much easier that way
*/

namespace launchers\collections;

class ObjectCollection implements \collections\ICollection
{
  protected $object; // the object in the collection
  protected $pile; // the methods applied to the object

  public function __construct($object) // creates an object collection
  {

  }
  public function name() // Returns object's name to store in bigger collection if needed
  {
    return get_class($object);
  }
  public function exec() // executes the pile on the object
  {

  }
}
?>
