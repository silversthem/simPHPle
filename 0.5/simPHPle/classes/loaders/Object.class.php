<?php
/*
  Class
  Loads an object
*/

namespace loaders;

class Object implements \ILoader
{
  use \ComponentException;

  protected $class; // Class name
  protected $classfile; // Class file

  public function __construct($class,$classfile = NULL) // Creates an object loader, a null $classfile will mean autoload
  {
    $this->class = $class;
    $this->classfile = $classfile;
    $this->exception_set_up('Object loader');
  }
  protected function load_file() // Opens the file
  {
    if(!is_null($this->classfile))
    {
      \loaders\Loader::load_once($this->classfile);
    }
    elseif(!class_exists($this->class))
    {
      $this->exception('Couldn\'t autoload object',\fException::FATAL,$this->class);
    }
  }
  public function load() // Loads an object
  {
    $this->load_file();
    return new $this->class;
  }
}
?>
