<?php
/*

*/

namespace sql;

class Database extends \PDO {
  /* Methods */
  public function __construct($using,...$args) { // Creates a database
    switch ($using) {
      case 'sqlite': // SQLite database
        parent::__construct('sqlite:'.$args[0]);
        break;
      default: // Other database
        parent::__construct($using.':host='.$args[0],$args[1],$args[2]);
        break;
    }
  }
  public function execute($query) { // Runs a query
    if(is_string($query)) return parent::exec($query);
    // ...
  }
}
