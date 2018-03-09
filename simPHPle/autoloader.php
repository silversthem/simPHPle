<?php
/*
  Starting the autoloader
*/

include_once 'core/Loader.class.php';

core\Loader::register(dirname(__FILE__),dirname(__FILE__).'/../modules');
