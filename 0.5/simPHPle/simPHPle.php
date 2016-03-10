<?php
/*
  Main framework file
  Loads basic components
*/

/* Let there be code */

include 'config.php'; // includes configuration

/* Autoloader */

include 'classes/loaders/Loader.class.php'; // loads autoloader

spl_autoload_register(array('loaders\Loader','autoload'));

/* Traits used by classes */

loaders\Loader::load_trait('ComponentException');
loaders\Loader::load_trait('Referencial');
loaders\Loader::load_trait('ArrayAccessor');
loaders\Loader::load_trait('Collection');

/* Interface used by classes having aliases */

loaders\Loader::load_interface('log\IWriter');

/* Aliases and system classes dependencies */

include 'helpers/aliases.php'; // Class aliases

Journal::dependencies();

/* Creating the journal : Your debugging/error handling tool */

$Journal = new Journal(); // initializing the journal

/* Good luck, have fun
  - Created by Silversthem : https://github.com/silversthem
  - With love
 */
?>
