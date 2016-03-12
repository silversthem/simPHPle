<?php
/*
  Class
  A collection is a pile of things to execute
*/

namespace launchers\collections;

class Collection implements \collections\ICollection
{
  use \Collection{
    add as add_to_collection;
  } // Collection used for pile results

  protected $pile = array(); // pile of Launched waiting to be executed

  public function __construct() // Creates a collection
  {
    $this->set_up_collection(array('Script' => array()),array('Function' => array()),array('Collection' => array()));
  }
  public function name() // Collection's type
  {
    return 'Collection';
  }
  public function add(\collections\ILaunched $element) // adds an element to the pile
  {
    $this->pile[] = $element;
  }
  public function add_collection(\collections\ICollection $collection) // adds a collection to the pile
  {
    $this->pile[] = $collection;
  }
  protected function store($element,$content) // stores a result in the pile
  {

  }
  protected function launch($element) // launches an element
  {

  }
  public function exec() // Executes the pile
  {
    foreach($this->pile as $element)
    {
      $this->launch($element);
    }
  }
}
?>
