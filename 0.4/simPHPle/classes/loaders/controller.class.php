<?php
/*
* simPHPle 0.4 controller.class.php : Class
* Loads a controller
*/

namespace loaders;

class Controller implements \ILoader
{
  use \Options;

  const UNDEFINED = 'undefined'; // when the controller is going to be defined later

  protected $actions; // things to do
  protected $events; // events to check

  public function __construct($controller = NULL) // creates a controller loader
  {
    if(!is_null($controller))
    {
      
    }
  }
  public function add_event($event,$action) // adds an event to the pile, associating it with an action
  {

  }
  public function add_action($action) // adds an action to the pile
  {

  }
  public function load() // returns an object executor with the controller and methods to execute
  {

  }
}
?>
