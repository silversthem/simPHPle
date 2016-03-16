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

}

function Query($class,$method/*, $arguments */) // A query
{

}

function Get($data) // Tells the action/query to use $_GET['data'] if exists, else -> unhandled exception
{

}

function Post($data) // Tells the action/query to use $_POST['data'] if exists, else -> unhandled exception
{

}

function Event($method,/*, $arguments  */) // A controller method that'll return the event object needed to assert the event
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
?>
