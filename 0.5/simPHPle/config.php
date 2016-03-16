<?php
/*
  Basic framework configuration
  If you don't know what you're doing just change the BASE_FOLDER to where your project is located, and BASE_DIR to the directory in the server
  if you don't know that either, well... just write "str_replace('/simPHPle','',__DIR__);" (without quotes obviously)
  if simPHPle is a your root, just put '' for BASE_DIR
  BASE_DIR is what has to be deleted from the url beginning when routing
*/

/* User settings */

define('BASE_FOLDER',str_replace('/simPHPle','/',__DIR__)); // absolute application folder
define('BASE_DIR','/0.5/'); // application folder,
define('MODE','DEVELOPMENT'); // application mode : PRODUCTION or DEVELOPMENT

/* Log */

define('LOG',true); // whether to store log in production
define('LOG_DIR','storage/log'); // where to store log, backtrace and all...

/* App folder */

define('APP_FOLDER','app'); // Your app folder
define('USER_CLASSES_FOLDER','app/core'); // where you'll write your classes
define('USER_MODULES_FOLDER','app/modules'); // where you'll write your modules
define('USER_ASSETS_FOLDER','app/assets'); // where your non php files (such as templates/css/js/images) are

/* User extensions */

define('USER_CLASS_EXT','.class.php'); // all class files are : *.class.php
define('USER_TRAIT_EXT','.trait.php'); // all trait files are : *.trait.php
define('USER_INTERFACE_EXT','.interface.php'); // all interface files are : *.class.php
define('USER_EVENT_EXT','.event.php'); // all event files are : *.event.php
define('USER_CONTROLLER_EXT','.controller.php'); // all controller files are : *.php
define('USER_TEMPLATE_EXT','.tpl'); // user templates files are *.tpl

/* System constants ; they are just for code readability, /!\ be very careful (please) /!\ */

define('SYS_FOLDER','simPHPle'); // the folder in which simPHPle is in, if you change the name of the dir as well, everything is okay ^_^
// system folders, don't touch them ; or be gentle, it's their first time
define('CLASSES_FOLDER',SYS_FOLDER.'/'.'classes'); // system class folder
define('TRAITS_FOLDER',SYS_FOLDER.'/'.'traits'); // system class folder
define('INTERFACES_FOLDER',SYS_FOLDER.'/'.'interfaces'); // system class folder
define('HELPERS_FOLDER',SYS_FOLDER.'/'.'helpers'); // system class folder
define('LIBRARIES_FOLDER',SYS_FOLDER.'/'.'libs'); // system class folder
// system file extensions
define('CLASS_EXT','.class.php'); // class files extensions
define('TRAIT_EXT','.trait.php'); // traits files extensions
define('INTERFACE_EXT','.interface.php'); // interfaces files extensions
define('HELPER_EXT','.php'); // helpers files extensions
?>
