<?php
define('APP_PATH', realpath('../api/app'));
date_default_timezone_set('UTC');

use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;

//require_once( '/var/www/html/simplesaml/lib/_autoload.php' );
	
//$saml = new \SimpleSAML\Auth\Simple('default-sp');
//$saml->requireAuth();
//$data = $saml->getAttributes();

//$userObject = json_encode($data);

//var_dump($userObject); exit;

$data['uniteid'][0] = "smogaka"; 
$data['email'][0] = "simon.mogaka@un.org";
$data['fullname'][0] = "Simon Mogaka";

try {
   
    $config = include APP_PATH . '/config/config.php';
    include APP_PATH . '/config/loader.php';
    include APP_PATH . '/config/services.php';

    $app = new Micro($di);

	//$auth = new \EmoG\Phalcon\Auth\Middleware\Micro($app, (array)$config->jwt );

	//$di['auth'] = $auth ;

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

print '<input type="hidden" name="authToken" id="authToken" value="'.$token.'" />';
