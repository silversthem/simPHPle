<?php
/*
  Trait
  Makes class able to chain methods
  To use it, just declare all your methods protected and prefixed by "ref_" and let the trait do the rest
  For static methodss, same but public methods and ref_static name, this avoids name conflicts. Also those returns __CLASS__, to pile them up
*/

trait Referencial
{
  public function referencial_call($method,$arguments) // referencial method used to call stuff
  {
    if(method_exists($this,$method))
    {
      call_user_func_array(array($this,$method),$arguments);
    }
    else // no method
    {
      throw new \fException('Referencial trait',\fException::FATAL,'tried to call inexistant referencial method',
        array('method' => $method,'arguments' => $arguments,'class' => __CLASS__),$this);
    }
  }
  public function __call($method,$arguments) // calls a method
  {
    $this->referencial_call('ref_'.$method,$arguments);
    return $this;
  }
  public static function __callStatic($method,$arguments) // Calls a static method, to be able to not have name conflicts
  {
    $this->referencial_call('ref_static_'.$method,$arguments);
    return __CLASS__;
  }
}
?>
