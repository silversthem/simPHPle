<?php
/*
  Interface
  Telling if object is a handler
  Handlers handles content and return a response
*/

interface IHandler
{
  public function get(); // gets the handler response
}
?>
