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

/* Handlers */

/* Routing */
class_alias('handlers\routing\Router','Router');
class_alias('handlers\routing\Router','Route');
class_alias('handlers\routing\Pattern','routing\Pattern');
/* Log and error handling */
class_alias('handlers\log\Journal','Journal');
class_alias('handlers\log\Log','Log');
class_alias('handlers\log\fException','fException');
/* Files */
class_alias('handlers\files\File','File');
class_alias('handlers\files\Json','Json');

/* Loaders */

class_alias('loaders\Loader','Loader');
?>
