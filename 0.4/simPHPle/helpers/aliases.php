<?php
/*
*	simPHPle 0.4 aliases.php : Helper
*	Creates cool aliases for commonly used classes
*/

/* Handlers */

class_alias('\handlers\Handler','Handler');
class_alias('\handlers\Journal','Journal');
class_alias('\handlers\files\File','File');
class_alias('\handlers\events\Query','Query');
class_alias('\handlers\events\Form','Form');

/* Router */

class_alias('\handlers\routing\Router','Router');
class_alias('\handlers\routing\Route','Route');
class_alias('\handlers\routing\Pattern','Pattern');

/* Loaders */

/* Launchers */

class_alias('\launchers\Launcher','Launcher');
class_alias('\launchers\app\App','App');
class_alias('\launchers\app\SimPHPle','SimPHPle');
class_alias('\launchers\Controller','Controller');
class_alias('\launchers\Module','Module');
class_alias('\launchers\executors\Collection','Collection');

/* Databases */

/* Views */

?>
