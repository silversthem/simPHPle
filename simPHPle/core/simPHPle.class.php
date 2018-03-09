<?php
/*
  simPHPle engine
*/

namespace core;

class simPHPle {
  /* Attributes */
  protected $database; // Used database
  protected $journal; // Journal, for logging purposes
  /* Methods */
  public function __construct() {

  }
  public function database($object) { // Sets database

  }
  public function public($controller) {
    // index route
  }
  public function add($controller,$begin_path) {
    // Add to router
  }
  public function run($journal = NULL,$request = NULL) {
    // Journal stuff...
    // Processing access method
    if(is_null($request)) {
      // Creating request
    }
    // ...
  }
}
