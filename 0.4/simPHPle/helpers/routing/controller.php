<?php
/*
* simPHPle 0.4 controller.php : Helper
* Functions to help route a controller
*/

namespace routing\controller;

function Action($method,$args = array()) // creates an action
{
  return array('method' => $method,'arguments' => $args);
}

function Query($methods,$query) // creates a simple get query
{
  return array('method' => $method,'query' => $query,'type' => 'GET');
}
?>
