<?php
/*
  Class
  A controller is a collection containing :
  - events,queries and actions (methods for controller object)
*/

namespace launchers\collections;

class Controller extends \collections\ObjectCollection
{
  public function __construct($controller = NULL/*, Other objects  */) // Creates a controller pile
  {
    $this->set_controller(($controller));
    if(func_num_args() > 2)
    {
      $objects = func_get_args();
      unset($object[0]);
      unset($object[1]);
      foreach($objects as $object) // Adding other objects to the pile
      {
        $this->add_object($object);
      }
    }
  }
  public function set_controller($controller) // Sets controller
  {
    if(is_object($controller))
    {
      $this->objects['Controller'] = $controller; // The controller has a special alias
    }
  }
  public function launch($element,$argument) // Launches an element
  {
    if($element instanceof \controllers\IEvent) // An event
    {
      // Testing the event and getting event pile
    }
    elseif($element instanceof \controllers\IQuery) // A query
    {
      // Get query info
    }
    else
    {
      return parent::launch($element,$argument);
    }
  }
}
?>
