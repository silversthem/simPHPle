<?php
/* Everything you need is here */

include_once 'config.php';

include_once 'helpers/loaders.php';

load_helper('dirs');

load_interface('cachable');

$journal = new \handling\log\journal(LOG_DIRECTORY,LOG);

//set_error_handler(function($error,$message,$file,$line,$context){
//  \handling\log\journal::write_error_message($error,$message,$file,$line,$context);}); // using this function to write errors
?>
