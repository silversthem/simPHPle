<?php
/* Model loader */

namespace model;

class model extends \handling\loader
{
  public function __construct($class,$args = array()) // creates the loader
  {
    $this->basedir = MODELS_DIRECTORY;
    parent::__construct($class,$args);
  }
}
?>
