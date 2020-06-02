<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
  [
    'Simon\Assess'  => APP_PATH . '/modules/assess/classes/',
	'Dmkit\Phalcon'       => APP_PATH . '/libraries/jwt/dmkit/Phalcon/', //for PHP 7
	'EmoG\Phalcon'        => APP_PATH . '/libraries/jwt/emog/Phalcon/', //for PHP 5.6
	'Firebase\JWT'        => APP_PATH . '/libraries/jwt/firebase/', //for PHP 5.6


  ]
);

$loader->registerDirs(
    [
        APP_PATH . '/tasks',
    ]
);

$loader->register();
