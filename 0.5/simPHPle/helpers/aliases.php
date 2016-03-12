<?php
/*
  Helpers
  Commonly used class aliases
*/

/* Launchers */

class_alias('launchers\Launcher','Launcher');
class_alias('launchers\collections\Collection','collections\Collection');
class_alias('launchers\collections\ObjectCollection','collections\ObjectCollection');

/* Handlers */

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
