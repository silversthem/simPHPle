<?php
/* This class stores info to configure a module */

namespace modules;

class constructor
{
  protected $name; // the name of the module
  protected $files = array(); // load files to configure the module
  protected $funcs = array(); // run functions to configure the module
  protected $couple = array('model' => NULL,'view' => NULL); // gives a model and a view to the module
  protected $action = array('model' => 'exec','view' => 'exec'); // if model and view are object, what method is to be called

  public function __construct($name = false) // creates a constructor
  {
    $this->name = $name;
  }
  public function set_name($name) // sets the module name
  {
    $this->name = $name;
  }
  public function get_params() // returns parameters for merging
  {
    return array('files' => $this->files,'funcs' => $this->funcs,'couple' => $couple,'action' => $action);
  }
  public function merge($c) // merges the two constructors
  {
    $params = $c->get_params();
  }
  public function add_file($file) // adds a file
  {
    if(!in_array($file,$this->files))
    {
      $this->files[] = $file;
    }
  }
  public function add_function($func) // adds a file
  {
    if(!in_array($func,$this->funcs))
    {
      $this->funcs[] = $func;
    }
  }
  public function configure($a) // configures the constructor
  {
    if(array_key_exists('files',$a)) // get the files
    {
      if(is_array($a['files']))
      {
        foreach($a['files'] as $file)
        {
          $this->add_file($file);
        }
      }
      else
      {
        $this->add_file($a['files']);
      }
    }
    if(array_key_exists('couple',$a)) // a couple
    {
      if(array_key_exists('action',$a)) // a specific method
      {
        $this->action = $a['action'];
      }
      $this->couple['model'] = $a['couple'][0];
      $this->couple['view'] = $a['couple'][1];
    }
    if(array_key_exists('functions',$a)) // functions
    {
      if(is_array($a['functions']))
      {
        foreach($a['functions'] as $func)
        {
          $this->add_function($func);
        }
      }
      else
      {
        $this->add_function($a['functions']);
      }
    }
  }
  protected function load_files() // loads the files
  {
    foreach($this->files as $file)
    {
      include MODULES_PATH.'/'.$this->name.'/'.$file;
    }
  }
  protected function run_functions() // runs the functions
  {
    foreach($this->funcs as $func)
    {
      $func();
    }
  }
  public function exec() // runs the constructor
  {
    if(is_string($this->name) && array_key_exists($this->name,$GLOBALS)) // if the module exists
    {
      $GLOBALS[$this->name]->set_couple($this->couple['model'],$this->couple['view'],$this->action);
      $this->run_functions();
      $this->load_files();
    }
  }
}
?>
