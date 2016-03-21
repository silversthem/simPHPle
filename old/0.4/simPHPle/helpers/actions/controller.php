<?php
/*
* simPHPle 0.4 controller.php : Helper
* Functions to help route a controller
*/

namespace actions;

function Controller($controller) // creates a controller
{
  if(is_object($controller)) // object
  {
    return array('type' => 'object','controller' => $controller);
  }
  elseif(is_string($controller)) // class
  {
    return array('type' => 'class','controller' => $controller);
  }
  return array('type' => 'undefined','controller' => $controller); // undefined
}

function Action($method,$args = array()) // creates an action
{
  return array('action' => true,'method' => $method,'arguments' => $args);
}

function Event($object,$action,$options = array()) // creates an event for an event object
{
  return array('event' => Event_handler($object),'options' => $options);
}

function Event_handler($handler) // returns an event handler to use
{
  if(is_object($handler)) // event handler is an object
  {
    return array('type' => 'object','object' => $handler,'event_handler' => true);
  }
  elseif(is_string($handler) && class_exists($handler)) // class
  {
    return array('type' => 'class','class' => $handler,'event_handler' => true);
  }
  else // we create an executor or collection
  {
    if(is_array($handler)) // collection
    {
      return array('type' => 'bootable','boot' => \Collection::create($handler),'event_handler' => true);
    }
    else // executor
    {
      return array('type' => 'bootable','boot' => \Executor::create($handler),'event_handler' => true);
    }
  }
}

function Query($query,$options = array(),$type = 'GET') // creates a simple query
{
  if(!is_array($query)) // already configured
  {
    return array('options' => $options,'query' => Event_handler($query),'type' => $type,'query' => true);
  }
  return array('options' => $options,'query' => $query,'type' => $type,'query' => true);
}
?>
