<?php
/*
  Default controller
  You can use these for testing your routing or your models
  Whenever you call an action on them, they just dump whatever they receive if in DEVELOPMENT mode else they do nothing
  Also contain an exception mecanism
  @TODO Better generation when in development 
*/

namespace launchers;

class Controller
{
  public function __construct() // initializes a controller
  {
    \Journal::write('Created controller '.get_class($this));
  }
  public function __call($method,$args) // Undefined Action
  {
    if(MODE == 'DEVELOPMENT')
    {
      echo 'undefined action '.$method.' in '.get_class($this).' Received : <br/><pre>';
      var_dump($args);
      echo '</pre><br/>';
    }
    else
    {
      $this->log('Called to undefined action (method '.$method.') in controller '.get_class($this).', arguments received '.print_r($args,false));
    }
  }
  protected function error($e,$context = NULL) // Throws an component exception
  {
    throw new \fException('Controller '.get_class($this),\fException::ERROR,$e,$context,$this);
  }
  protected function kill($k,$context = NULL) // Fatal error
  {
    throw new \fException('Controller '.get_class($this),\fException::FATAL,$e,$context,$this);
  }
  protected function log($l) // Logs something
  {
    \Journal::write($l);
  }
}
?>
