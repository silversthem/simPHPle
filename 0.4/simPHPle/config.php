<?php
/*
*	simPHPle 0.4 config.php : Configuration file
*	Framework Configuration
*	Leave everything at default setting but BASE_DIRECTORY if you don't know what you're doing
*/

/* GENERAL SETTINGS */

define('BASE_DIRECTORY','/0.4/'); // the directory containing the framework
define('MODE','DEVELOPMENT'); // what we're doing : PRODUCTION/DEVELOPMENT/MAINTENANCE
define('LOG',true);
define('LOG_DIRECTORY','storage/log');
define('PROFILER_FILE','storage/log/profiler.json');

/* System directories */

define('CLASS_DIRECTORY','simPHPle/classes');
define('INTERFACES_DIRECTORY','simPHPle/interfaces');
define('TRAITS_DIRECTORY','simPHPle/traits');
define('HELPERS_DIRECTORY','simPHPle/helpers');

/* App directories */

define('MODULES_PATH','app/modules');
define('USER_CLASS_DIRECTORY','app/core');
// forms
// queries
define('TEMPLATES_PATH','app/assets/templates');

/* Files extensions */

define('CONTROLLER_EXT','.controller.php');
define('EVENT_EXT','.event.php');
define('ROUTES_EXT','.php');
define('TEMPLATES_EXT','.tpl');
// system : don't change /!\
define('CLASS_EXT','.class.php');
define('INTERFACE_EXT','.interface.php');
define('TRAIT_EXT','.trait.php');
define('HELPER_EXT','.php');

/* SQL */

define('SQL_LOGIN','root');
define('SQL_PASSWORD','');
define('SGBD','mysql');
define('SQL_HOST','localhost');

/* Development tools */

define('DEVTOOLS_ENABLED',true);
define('DEVTOOLS_ROUTES_ENABLED',true);

?>
