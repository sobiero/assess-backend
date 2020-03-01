<?php


$app->get('/evaluation/ext-url', function () use ($app) {

	 $response = new \Phalcon\Http\Response();

	$response->setHeader('Access-Control-Allow-Origin', '*');
    $response->setHeader('Access-Control-Allow-Headers', 'Content-Type,Authorization,Origin,X-Requested-With');    
	$response->setHeader('Content-Type', 'application/json');    

    $data = \file_get_contents( $_GET['url'] );

	$response->setContent( $data );
    return $response->send();

 
});

include APP_PATH . "/modules/evaluation/routes.php" ;

function sendResponse($code, $data)
{

    $httpResCodes = [ 
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
    ];

    $response = new \Phalcon\Http\Response();
    
	$response->setHeader('Access-Control-Allow-Origin', '*');
    $response->setHeader('Access-Control-Allow-Headers', 'Content-Type,Authorization,Origin,X-Requested-With');    
	$response->setHeader('Content-Type', 'application/json');    
	
	$response->setStatusCode($code, $httpResCodes[$code]);   
    $response->setContentType("application/json");
    
	$response->sendHeaders();

    $response->setContent( \json_encode( ['status' => ['code' => $code, 'msg' => $httpResCodes[$code] ], 'resp' => $data ] ));
    return $response->send();
 
}



function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } 
        else if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) { //Simon
            $headers = trim($_SERVER["REDIRECT_HTTP_AUTHORIZATION"]);
        } 	
		else if (isset($_SERVER['REDIRECT_REDIRECT_HTTP_AUTHORIZATION'])) { //Simon
            $headers = trim($_SERVER["REDIRECT_REDIRECT_HTTP_AUTHORIZATION"]);
        } 	
		elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
/**
 * get access token from header
 * */
function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function getUser(){
   $bearer = getBearerToken();
   $data = \json_decode($bearer, true);
   return @$data['user'];
}
function getToken(){
   $bearer = getBearerToken();
   $data = \json_decode($bearer, true);
   return @$data['token'];
}
