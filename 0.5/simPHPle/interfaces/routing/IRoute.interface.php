<?php
/*
  Interface
  Methods all things in the router must have
*/

namespace routing;

interface IRoute extends \IHandler
{
  public function valid($url); // if the route is valid
}
?>
