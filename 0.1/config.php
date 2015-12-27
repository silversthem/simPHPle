<?php
/* Hi there ! Welcome inside framework_name
Here's a few things you need to know :
  - Every configuration option if defined here
  - The index.php file is already close to functional, you just need to create the router
Conventions :
  - underscore ('_') is used to separate words in functions and an uppercase letter in variables
*/
define('BASE_DIRECTORY','simphple/0.1'); // name of directory the framework is in
/* SQL PARAMETERS */
define('SQL_LOGIN','root');
define('SQL_PASSWORD','password');
/* WEBSITE PARAMETERS */
define('LOGIN','admin');
define('SALT','sweg');
define('PASSWORD',crypt('password',SALT));
?>
