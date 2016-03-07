<?php
/*
  Trait
  Makes class able to chain methods
  To use it, just declare all your methods protected and prefixed by "ref_" and let the trait do the rest
*/

trait Referencial
{
  public function __call($method,$arguments) // calls a method
  {
    if(method_exists($this,$method))
    {
      call_user_func_array(array($this,'ref_'.$method),$arguments);
    }
    else // no method
    {
      throw new \fException('Referencial trait',\fException::FATAL,'tried to call inexistant referencial method',
        array('method' => $method,'arguments' => $arguments,'class' => __CLASS__));
    }
    return $this;
  }
}
?>
