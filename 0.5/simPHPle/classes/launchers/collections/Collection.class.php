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
    elseif($element instanceof \Closure) // An anonymous function, quick to debug
    {
      return $element($argument);
    }
    elseif($element instanceof \IHandler) // A handler
    {
      return $element->get();
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
      // TODO : Handling jumps
      $temp = $this->launch($element,$argument);
      if(!is_null($temp))
      {
        $argument = $temp;
      }
    }
    return $argument;
  }
}
?>
