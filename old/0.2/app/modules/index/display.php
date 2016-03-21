<?php
/* Display the modules */
global $index;
$index->template->set_file($index->dir().'/template.tpl');
$index->template->set_type(\view\template::HTML);
$index->template->set_template_id('index');
$index->run();
?>
