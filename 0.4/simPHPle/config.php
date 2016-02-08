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

define('VIEWS_DIRECTORY','app/mvc/views');
define('MODELS_DIRECTORY','app/mvc/models');
define('USER_CLASS_DIRECTORY','app/classes');
define('CONTROLLERS_DIRECTORY','app/mvc/controllers');
define('FORM_DIRECTORY',CONTROLLERS_DIRECTORY.'/forms');
define('QUERIES_DIRECTORY',CONTROLLERS_DIRECTORY.'/queries');
define('TEMPLATES_PATH','app/assets/templates');
define('MODULES_PATH','app/modules');

/* Files extensions */

define('CLASS_EXT','.class.php');
define('INTERFACE_EXT','.interface.php');
define('TRAIT_EXT','.trait.php');
define('HELPER_EXT','.php');
define('ROUTES_EXT','.php');
define('TEMPLATES_EXT','.tpl');

/* SQL */

define('SQL_LOGIN','root');
define('SQL_PASSWORD','');
define('SGBD','mysql');
define('SQL_HOST','localhost');

/* Development tools */

define('DEVTOOLS_ENABLED',true);
define('DEVTOOLS_ROUTES_ENABLED',true);

?>
