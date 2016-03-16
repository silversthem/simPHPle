<?php
/*
  Class
  A controller is a collection containing :
  - events,queries and actions (methods for controller object)
*/

namespace launchers\collections;

class Controller extends \collections\ObjectCollection
{
  public function __construct($controller = NULL,$manager = NULL/*, Other objects  */) // Creates a controller pile
  {
    // Adds objects to the pile, with special identifiers
  }
  public function launch($element,$argument) // Launches an element
  {
    // If element is an event
    // Or a query
    // Else
    return parent::launch($element,$argument);
  }
}
?>
