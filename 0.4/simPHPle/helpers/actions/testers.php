<?php
/*
* simPHPle 0.4 testers.php : Helper
* Tests what information an array contains
*/
namespace actions;

function is_action($element) // returns true if element is an action array
{
  return array_key_exists('action',$element);
}

function is_event($element) // returns true if element is event
{
  return array_key_exists('event',$element);
}

function is_couple($element) // returns true if element is couple
{
  return array_key_exists('couple',$element);
}

function is_couple_action($element) // returns true if element is an action for a couple
{
  return array_key_exists('couple_action',$element);
}

function is_event_handler($element) // returns true if element is an event handler of sorts
{
  return array_key_exists('event_handler',$element);
}

function is_form($element) // returns true if the element is a form
{
  return array_key_exists('form',$element);
}

function is_query($element) // returns true if the element is a form
{
  return array_key_exists('query',$element);
}
?>
