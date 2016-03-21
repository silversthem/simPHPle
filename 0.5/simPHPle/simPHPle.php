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

loaders\Loader::load_trait('Referencial');
loaders\Loader::load_trait('ComponentException');
loaders\Loader::load_trait('ArrayAccessor');
loaders\Loader::load_trait('Collection');

/* Interface used by classes having aliases */

/* Basics */
loaders\Loader::load_interface('ILauncher');
loaders\Loader::load_interface('IHandler');
loaders\Loader::load_interface('ILoader');
/* Logging */
loaders\Loader::load_interface('log\IWriter');
/* Collections related */
loaders\Loader::load_interface('collections\ICollection');
loaders\Loader::load_interface('collections\ILaunched');

/* Aliases and system classes dependencies */

launchers\App::dependencies();

include 'helpers/aliases.php'; // Class aliases

Journal::dependencies();

/* Creating the journal : Your debugging/error handling tool */

$Journal = new Journal(); // initializing the journal

set_error_handler(array('Journal','register_error'));
set_exception_handler(array('Journal','uncaught_exception'));

/* Good luck, have fun
  - Created by Silversthem : https://github.com/silversthem
  - With love
 */
?>
