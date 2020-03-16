<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
  [
    'Project\Evaluation'  => APP_PATH . '/modules/evaluation/classes/',
	'Dmkit\Phalcon'       => APP_PATH . '/libraries/dmkit/Phalcon/', //for PHP 7
	'EmoG\Phalcon'        => APP_PATH . '/libraries/emog/Phalcon/', //for PHP 5.6
	'Firebase\JWT'        => APP_PATH . '/libraries/firebase/', //for PHP 5.6


  ]
);

$loader->registerDirs(
    [
        APP_PATH . '/tasks',
    ]
);

$loader->register();
