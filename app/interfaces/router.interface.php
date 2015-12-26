<?php
/* Methods all router need */
interface irouter
{
  public function __construct($url);
  public function exec();
}
?>
