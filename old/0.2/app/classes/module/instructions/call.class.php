<?php
/* This class works both end of the calling mecanism */
namespace module\instructions;

class call
{
  protected $module; // the module name
  protected $datas = array(); // the datas sent by modules

  const ANY = 0; // any module

  public function __construct($modname) // creates a new call object
  {
    $this->module = $modname;
  }
  public function set_data($module,$type,$info) // set a data
  {
    if(array_key_exists($module,$this->datas)) // datas have already been sent
    {
      $this->datas[$module][$type] = $info;
    }
    else
    {
      $this->datas[$module] = array($type => $info);
    }
  }
  public function send($module,$type,$info) // send $info as $type to $module module
  {
    if(isset($GLOBALS[$module])) // if the module exists
    {
      $GLOBALS[$module]->call_center->set_data($this->module,$type,$info);
    }
  }
  public function template_send($module,$name,$value) // changes the template in another module
  {
    if(isset($GLOBALS[$module]) && get_class($GLOBALS[$module]) == 'module\module') // if the module exists
    {
      $GLOBALS[$module]->template->set_var($name,$value);
    }
  }
  public function get($from = \module\instructions\call::ANY,$info = false) // get the sent info
  {
    if($from == \module\instructions\call::ANY) // all datas
    {
      return $this->datas;
    }
    elseif(array_key_exists($from,$this->datas)) // datas from an existing module
    {
      if($info !== false) // a specific info
      {
        if(array_key_exists($info,$this->datas[$from]))
        {
          return $this->datas[$from][$info];
        }
      }
      else // everything
      {
        return $this->datas[$from];
      }
    }
  }
}
?>
