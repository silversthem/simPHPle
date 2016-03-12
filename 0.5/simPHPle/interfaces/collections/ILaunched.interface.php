<?php
/*
  Interface
  Methods used by objects that can be executed by Collections
*/

namespace collections;

interface ILaunched
{
  public function name(); // returns element's name, for its result to be stored in the pile
  public function init(&$collection); // initializes the launched object, giving the collection its a part of
  public function launch(&$context); // launches the object
}
