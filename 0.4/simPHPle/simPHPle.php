<?php
/*
*	simPHPle 0.4 simPHPle.php : Main framework file
*	Autoloads classes, configuration and helpers
*/

include 'config.php';

include_once 'classes/loaders/loader.class.php';

class_alias('\loaders\Loader','Loader');

spl_autoload_register(array('Loader','autoload'));

Loader::load_interface('launcher');
Loader::load_interface('handler');
Loader::load_interface('loader');

Loader::load_trait('profiling');
Loader::load_trait('result');
Loader::load_trait('options');

Loader::load_helper('aliases');

Journal::dependencies();

App::dependencies();

Router::dependencies();

Template::dependencies();

$journal = new Journal(MODE,LOG_DIRECTORY);

set_error_handler(array('Journal','error'));
set_exception_handler(array('Journal','exception_catcher'));
?>
