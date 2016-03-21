<?php
/*
* simPHPle 0.4 controller.interface.php : Interface
* Minimal methods for all controllers
*/

namespace app;

interface IController
{
  public function init();
  public function error($status);
}
?>
