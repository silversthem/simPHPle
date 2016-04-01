<?php
/*
  Interface
  Events are special in a controller pile, they check if something has happened and returns a different statement
  Example : Checking a form -> if filled do x, if poorly filled do y and if not filled do nothing, and jump to pile next element
*/

namespace events;

interface IEvent extends \IHandler
{
  
}
?>
