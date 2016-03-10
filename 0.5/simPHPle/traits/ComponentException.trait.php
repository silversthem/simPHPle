<?php
/*
  Trait
  Provides an easier way of writing exceptions cases for your components
*/

trait ComponentException
{
  protected $name; // Component name
  protected $default_err_type; // default error type thrown

  public function exception_set_up($component,$defaulterr = \fException::ERROR) // sets up the trait
  {
    $this->name = $component;
    $this->default_err_type = $defaulterr;
  }
  protected function exception($str,$errtype = NULL/*, context */) // throws a framework component exception
  {
    if(is_null($errtype)) $errtype = $this->default_err_type;
    $context = func_get_args();
    if(func_num_args() > 2) // if there's context
    {
      unset($context[0]);
      unset($context[1]);
    }
    throw new \fException($this->name,$errtype,$str,$context,$this);
  }
}
?>
