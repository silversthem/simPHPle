<?php
/*
  Interface
  Methods all things in the router must have
*/

namespace routing;

interface IRoute extends \IHandler
{
  public function overrides(); // if the route's generated controller overrides its parent => overwrites it
  public function merges(); // if the route's generated controller merges with its parent => replacing in conflicts
  public function valid($url); // if the route is valid
}
?>
