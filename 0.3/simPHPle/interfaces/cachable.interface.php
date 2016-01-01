<?php
/* An interface all views that wish to be able to use the cache must have */

interface icachable
{
  public function gen_cache($f); // creates the cache file
  public function use_cache($f); // uses it
}
?>
