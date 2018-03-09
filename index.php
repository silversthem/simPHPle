<?php
/*

*/

include_once 'simPHPle/autoloader.php';
include_once 'simPHPle/aliases.php';

$journal = new Journal(Journal::write_in_dir('data/log'));
