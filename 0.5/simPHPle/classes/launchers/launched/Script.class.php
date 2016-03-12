<?php
/*
  Class
  Executes a php script
*/

namespace \launchers\launched;

class Script implements \collections\ILaunched
{
  protected $file; // the file to execute

  public function __construct($file) // Creates a script
  {
    $this->file = $file;
  }
  public function name() // name of launched
  {
    return 'Script';
  }
  public function init(&$collection) // initializes the script
  {
    if(!file_exists($this->file))
    {
      throw new \fException('Script in collection',\fException::ERROR,'couldn\'t find file',$this->file,$this);
    }
  }
  public function launch(&$context) // launches the script
  {
    return include $this->file;
  }
}
?>
