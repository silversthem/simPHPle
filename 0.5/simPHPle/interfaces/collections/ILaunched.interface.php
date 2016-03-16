<?php
/*
  Interface
  Methods used by objects that can be executed by Collections
*/

namespace collections;

interface ILaunched
{
  public function init(&$context); // initializes the launched object
  public function launch(&$context); // launches the object
}
