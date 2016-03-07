<?php
/*
  Class < Exception
  Exception type used by the framework
*/

namespace handlers\log;

class fException extends \Exception
{
  protected $type; // Error type
  protected $component; // Component that caused the exception
  protected $error; // Error
  protected $context; // Context of error
  protected $timeline; // when the exception was created

  const FATAL = 'Fatal error'; // Very important error, you know what you've done and guess what, we know too
  const ERROR = 'Error'; // Unexpeced behavior, see context to know how it was handled
  const WARNING = 'Warning'; // Weird behavior, see context to know how it was handled
  const NOTICE = 'Notice'; // Bad/Depreciated practice, still works but could be cleaner, see context

  public function __construct($component,$type,$error,$context = NULL) // creates a new framework exception
  {
    parent::__construct('Framework error');
    $this->type = $type;
    $this->component = $component;
    $this->error = $error;
    $this->context = $context;
    $this->timeline = Journal::timeline();
  }
  final public function  __get($attribute) // all attributes of all exception are readable, always. It's important, very important
  {
    if(isset($this->$attribute)) // we're trying to access something that's defined
    {
      return $this->$attribute;
    }
    throw new fException('fException',self::WARNING,'Undefined attribute',$attribute);
    /* Throwing an exception in the exception class, so cool */
  }
  public function __toString() // returns a string to quickly understand what the fuss was all about
  {
    return $this->code.' in '.$this->component.' : '.$this->error.' '.$this->context;
  }
}
?>
