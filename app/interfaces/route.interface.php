<?php
/* Methods all types of routes needed */

interface iroute
{
  public function __construct($name,$path);
  public function test_url($url);
  public function name();
  public function path();
  public function create_object();
}
?>
