<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
  [
    'Project\Evaluation'          => APP_PATH . '/modules/evaluation/classes/',
	//'PHPMailer\PHPMailer'       => APP_PATH . '/libraries/PHPMailer/src/',
  ]
);

$loader->registerDirs(
    [
        APP_PATH . '/tasks',
    ]
);

$loader->register();
