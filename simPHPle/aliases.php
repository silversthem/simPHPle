<?php
/*
  simPHPle's aliases
*/

/* containers module */
class_alias('containers\Container','Container');
/* http module */
class_alias('http\HttpRequest','HTTPRequest');
class_alias('http\UrlPattern','URLPattern');
/* log module */
class_alias('log\Journal','Journal');
/* routing module */
class_alias('routing\Router','Router');
class_alias('routing\Route','Route');
/* sql module */
class_alias('sql\Database','Database');
class_alias('sql\Model','Model');
class_alias('sql\models\Entry','models\Entry'); // sql default model
class_alias('sql\queries\Create','queries\Create'); // Creation query
class_alias('sql\queries\Drop','queries\Drop'); // Drop query
class_alias('sql\queries\Insert','queries\Insert'); // Insertion query
class_alias('sql\queries\Search','queries\Search'); // Search query
class_alias('sql\queries\Select','queries\Select'); // Selection query
class_alias('sql\queries\Update','queries\Update'); // Update query
class_alias('sql\Schema','Schema');
class_alias('sql\Types','Types');
