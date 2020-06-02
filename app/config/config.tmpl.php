<?php
//rename to config.php
date_default_timezone_set('Africa/Nairobi');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type,Authorization,Origin,X-Requested-With');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, HEAD, OPTIONS');

use \Phalcon\Config;

return new Config(
    [
        'db'   => [
            'adapter'     => 'Mysql',
            'host'        => 'localhost',
            'port'        => 3306,
            'username'    => 'username',
            'password'    => 'passwd',
            'dbname'      => 'db',
        ],
		'email'   => [
		    'host'          => 'onesmtp.gslb.un.org', 
			'port'          => 25,
			'from_address'  => 'unenvironment.no-reply@un.org', 
			'from_name'     => 'UNEP Evaluation Module ',
			'send_emails'   => 1,
			'contact'       => ''
		],
        'app'   => [
		    'upload_dir'    => '/root/public_html/simon/pims-v2/uploads/evm/', 
		],
		
		'models'          => [
            'metadata'    => [
                'adapter' => 'Memory'
            ],
		],

	
    ]
);
