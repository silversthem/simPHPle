<?php
/*
  Helpers
  Functions used to specify what controller should do
  Actions are methods to call onto controller
  Queries are methods to call onto model/manager
  Get and Post tells the Query/Action to use a $_GET/$_POST variable
*/

define('QUERY_ELSE',-1); // What to do if a query throw an exception, has to be put in an array as so : "array(SUCCESS_ACTION,QUERY_ELSE => OTHER_ACTION)"
define('EVENT_ELSE',-1); // Same, but with events

function Action($method/*, $arguments */) // An action
{
  $args = array();
  if(func_num_args() > 1)
  {
    $args = func_get_args();
    unset($args[0]);
  }
  return new \launched\Method($method,'Controller',$args);
}

function Query(/* $arguments */) // A query
{

}

function Get($data) // Tells the action/query to use $_GET['data'] if exists
{
  return new GET($data);
}

function Post($data) // Tells the action/query to use $_POST['data'] if exists
{

}

function Event($method/*, $arguments  */) // A controller method that'll return the event object needed to assert the event
{

}

function Permission($file = 'permissions.php') // Loads a permission file
{

}

function Nothing() // Makes a pause between two elements in a pile
{
  return 'PAUSE';
}

function Kill() // Kills (stops) the pile
{
  return 'KILL';
}

function Jump() // TODO : "Jumps" the next element in pile (still giving it the argument but not changing argument for its return value)
{ // Useful to debug usually

}
?>
