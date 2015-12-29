<?php
/* Loads a class : creates an instance of class when executed */

namespace handling;

class loader
{
  protected $basedir; // the dir from which the class will be pulled
  protected $classfile; // the file where the class is
  protected $class; // the class name
  protected $args = array(); // the arguments for the constructor, eventually

  public function construct($class,$args = array()) // where the class is
  {
    $this->class = $class;
    $this->classfile = $this->basedir.'/'.str_replace('\\','/',$class).CLASS_EXT; // namespaces handling
    $this->args = $args;
  }
  public function load() // returns the object
  {
    if(file_exists($this->classfile))
    {
      include_once $this->classfile;
      if(class_exists($this->class))
      {
        $args = implode(',',$this->args);
        $f = create_function('','return new '.$this->class.'('.$args.');');
        $object = $f();
        return $object;
      }
    }
    return NULL;
  }
}
?>
