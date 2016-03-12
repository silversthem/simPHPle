<?php
/*
  Interface
  Telling if object is a loader
  Loaders return loaded content to be used by launchers, usually
  Doesn't actually load content, usually objects
*/

interface ILoader
{
  public function load(); // Returns loaded content
}
?>
