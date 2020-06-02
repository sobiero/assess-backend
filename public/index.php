<?php

use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;

define('APP_PATH', realpath('../app'));

try {
   
    $config = include APP_PATH . '/config/config.php';

    include APP_PATH . '/config/loader.php';
    include APP_PATH . '/config/services.php';

    $app = new Micro($di);
    
    include APP_PATH . '/../app.php';

	//$auth = new \EmoG\Phalcon\Auth\Middleware\Micro($app, (array)$config->jwt );

    $app->handle();

} catch (\Exception $e) {
    
	echo $e->getMessage(); exit;
}
