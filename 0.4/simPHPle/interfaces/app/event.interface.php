<?php
/*
* simPHPle 0.4 event.interface.php : Interface
* Minimal event methods
*/

namespace app;

interface Event extends \IHandler
{
  public function init();
  public function valid();
}
?>
