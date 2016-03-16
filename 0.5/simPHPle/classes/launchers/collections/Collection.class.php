<?php
/*
  Class
  A collection is a pile of things to execute
*/

namespace launchers\collections;

class Collection implements \collections\ICollection
{

  protected $pile = array(); // pile of Launched waiting to be executed

  public function __construct() // Creates a collection
  {

  }
  public function add($element) // adds an element to the pile
  {
    $this->pile[] = $element;
  }
  protected function launch($element,$argument) // launches an element
  {
    if($element instanceof \collections\ILaunched)
    {
      $element->init($argument);
      return $element->launch(NULL);
    }
    else // A pause, or a weird unknown thing
    {
      return NULL;
    }
  }
  public function exec() // Executes the pile
  {
    $argument = NULL;
    foreach($this->pile as $element)
    {
      if(is_string($element) && $element == 'KILL') // killing the pile
      {
        break;
      }
      $argument = $this->launch($element,$argument);
    }
    return $argument;
  }
}
?>
