<?php
/*
  Represents a simPHPle framework exception
*/

namespace simPHPle\core;

class fException extends \Exception {
  /* Attributes */
  protected $component;
  protected $module;
  /* Methods */
  public function __construct($message,$component,$module,$code = 0,$previous = NULL) {
    parent::__construct($message,$code,$previous);
    $this->component = $component;
    $this->module    = $module;
  }
  public function __toString() {

  }

}
