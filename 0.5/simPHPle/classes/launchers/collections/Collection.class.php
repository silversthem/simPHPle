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
  public function set_pile($pile) // Sets collection pile
  {
    $this->pile = $pile;
  }
  public function add_pile($pile) // Adds a pile
  {
    foreach($pile as $element)
    {
      $this->add($element);
    }
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
    elseif(\Launcher::can_boot($element)) // A handler
    {
      return \Launcher::boot($element);
    }
    return NULL; // Default
  }
  public function exec() // Executes the pile
  {
    $argument = NULL;
    // @TODO : Support Memoization when $element is an array -> Create a big argument for each array element return
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
