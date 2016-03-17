<?php
/*
  Interface
  Event methods
  Events are usually just forms when completed
  The get() method returns what the pile should do after
*/

namespace controllers;

interface IEvent extends \IHandler
{
  public function valid(); // If the event is valid
}
?>
