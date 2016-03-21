<?php
/* View loader */

namespace view;

class view extends \handling\loader
{
  public function __construct($class,$args = array()) // creates a view
  {
    $this->basedir = VIEWS_DIRECTORY;
    parent::__construct($class,$args);
  }
}
?>
