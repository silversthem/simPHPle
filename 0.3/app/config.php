<?php
/* SIMPHPLE CONFIGURATION */

define('BASE_DIRECTORY','/0.3/'); // the directory containing the framework
define('MODE','DEVELOPMENT'); // what we're doing : PRODUCTION/DEVELOPMENT/MAINTENANCE
define('LOG',true);

/* Directories */

define('MODULES_PATH','modules');
define('TEMPLATES_PATH','assets/templates');
define('CLASS_DIRECTORY','app/classes');
define('INTERFACES_DIRECTORY','app/interfaces');
define('TRAITS_DIRECTORY','app/traits');
define('HELPERS_DIRECTORY','app/helpers');
define('LOG_DIRECTORY','datas/log');

/* Files extensions */

define('CLASS_EXT','.class.php');
define('INTERFACE_EXT','.interface.php');
define('TRAIT_EXT','.trait.php');
define('MODEL_EXT','.model.php');
define('VIEW_EXT','.view.php');

/* SQL */

define('SQL_LOGIN','root');
define('SQL_PASSWORD','');
define('SGBD','mysql');

/* Development tools */

define('DEVTOOLS_ENABLED',true);
define('DEVTOOLS_ROUTES_ENABLED',true);
?>
