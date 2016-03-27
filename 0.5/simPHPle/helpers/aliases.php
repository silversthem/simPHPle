<?php
/*
  Helpers
  Commonly used class aliases
*/

/* Launchers */

class_alias('launchers\App','App');
class_alias('launchers\Launcher','Launcher');
/* Collections */
class_alias('launchers\collections\Collection','collections\Collection');
class_alias('launchers\collections\ObjectCollection','collections\ObjectCollection');
class_alias('launchers\collections\Controller','collections\Controller');
/* Pile elements */
class_alias('launchers\launched\Closure','launched\Closure');
class_alias('launchers\launched\Method','launched\Method');
class_alias('launchers\launched\Script','launched\Script');

/* Handlers */

/* Routing */
class_alias('handlers\routing\Router','Router');
class_alias('handlers\routing\Route','Route');
class_alias('handlers\routing\Pattern','routing\Pattern');
/* Log and error handling */
class_alias('handlers\log\Journal','Journal');
class_alias('handlers\log\Log','Log');
class_alias('handlers\log\fException','fException');
/* Files */
class_alias('handlers\files\File','File');
class_alias('handlers\files\Json','Json');
/* Requests */
class_alias('handlers\requests\GET','GET');

/* Loaders */

class_alias('loaders\Loader','Loader');
class_alias('loaders\Controller','Loader\Controller');
?>
