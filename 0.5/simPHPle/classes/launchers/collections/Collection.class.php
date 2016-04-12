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
  protected function launch($element,$argument,$memoized) // launches an element
  {
    if(is_array($element)) // An array, each array element must be dissected
    {
      $mem = array(); // Memoization
      foreach($element as $sub) // Each element has to be executed, $argument is now an array
      {
        $temp = $this->launch($sub,$argument,false);
        if(!is_null($temp))
        {
          $mem[] = $temp;
        }
      }
      return $mem;
    }
    elseif($element instanceof \collections\ILaunched)
    {
      $element->init($argument,$memoized);
      return $element->launch(NULL);
    }
    elseif($element instanceof \Closure || is_callable($element)) // A function
    {
      return ($memoized) ? call_user_func_array($element,$argument) : $element($argument);
    }
    elseif(\Launcher::can_boot($element)) // A handler
    {
      return \Launcher::boot($element);
    }
    return $element; // Default
  }
  public function exec() // Executes the pile
  {
    $argument = NULL;
    $memoized = false;
    foreach($this->pile as $element)
    {
      if(is_string($element) && $element == 'KILL') // killing the pile
      {
        break;
      }
      else
      {
        // TODO : Handling jumps
        $temp = $this->launch($element,$argument,$memoized);
        $memoized = is_array($element);
        if(!is_null($temp) || !empty($temp)) // If temp isn't null
        {
          $argument = $temp;
        }
      }
    }
    return $argument;
  }
}
?>
