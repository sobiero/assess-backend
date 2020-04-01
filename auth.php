<?php
define('APP_PATH', realpath('../api/app'));

use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;

require_once( '/root/public_html/simplesaml/lib/_autoload.php' );
	
$saml = new \SimpleSAML\Auth\Simple('default-sp');
$saml->requireAuth();
$data = $saml->getAttributes();

$userObject = json_encode($data);

try {
   
    $config = include APP_PATH . '/config/config.php';
    include APP_PATH . '/config/loader.php';
    include APP_PATH . '/config/services.php';

    $app = new Micro($di);

	$auth = new \EmoG\Phalcon\Auth\Middleware\Micro($app, (array)$config->jwt );

	$di['auth'] = $auth ;

    $app->handle();

} catch (\Exception $e) {
    
	//echo $e->getMessage(); 
}

$payload = [ 
    'sub'   => $data['uniteid'][0], 
    'email' => $data['email'][0],
    'fullname' => $data['fullname'][0],
    //'role'  => 'admin',
    'iat' => time(),
  ];

$token = $app->auth->make($payload);

print '<input type="hidden" name="authToken" id="authToken" value="'.$token.'">';
