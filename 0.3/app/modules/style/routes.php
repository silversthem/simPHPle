<?php
/* The style's routes */
global $app;
$app->create_route('style',array(
  'pattern' => '{[modstyle]}.css',
  'files' => 'index.php'
));
?>
