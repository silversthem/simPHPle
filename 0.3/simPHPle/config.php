<?php
/* SIMPHPLE CONFIGURATION */

define('BASE_DIRECTORY','/0.3/'); // the directory containing the framework
define('MODE','DEVELOPMENT'); // what we're doing : PRODUCTION/DEVELOPMENT/MAINTENANCE
define('LOG',true);
define('LOG_DIRECTORY','storage/log');

/* System directories */

define('CLASS_DIRECTORY','simPHPle/classes');
define('INTERFACES_DIRECTORY','simPHPle/interfaces');
define('TRAITS_DIRECTORY','simPHPle/traits');
define('HELPERS_DIRECTORY','simPHPle/helpers');

/* App directories */

define('VIEWS_DIRECTORY','app/views');
define('MODELS_DIRECTORY','app/models');
define('USER_CLASS_DIRECTORY','app/classes');
define('TEMPLATES_PATH','app/assets/templates');
define('MODULES_PATH','app/modules');

/* Files extensions */

define('CLASS_EXT','.class.php');
define('INTERFACE_EXT','.interface.php');
define('TRAIT_EXT','.trait.php');
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
