<?php
/* Handles the css of the website */
$call = new \module\instructions\call('style');
$call->template_send('index','STYLE','index.css');
?>
