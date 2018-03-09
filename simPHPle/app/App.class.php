<?php
/*

*/

namespace app;

class App {
  protected $database;
  protected $router;
  protected $name;
  /* Methods */
  public function __construct($database) {

  }
  public function init($name,$url) {
    $this->name = $name;
    $r = new Router($name,$url);
    $this->routes($r);
  }
  protected function schema(...$classes) { // Sets the data schema

  }
  /* Methods to inherit */
  public function permission($user) {
    
  }
  public function routes() {
    // -> 404
  }
}
