<?php

//print_r( $app->getDI()->get('auth')->data('email') ); exit ;

$app->get('/assess', function () use ($app) {

    $data = [ 'data' => 'Project Assess Module API', 'error' => null ];
    return sendResponse( 200, $data );
 
});

$app->get('/assess/var', function () use ($app) {
	
	$data = \Simon\Assess\Models\Variable::find();

    $data = [ 'data' => $data, 'error' => null ];
    return sendResponse( 200, $data );
 
});
