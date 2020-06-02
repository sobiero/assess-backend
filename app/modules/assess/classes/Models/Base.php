<?php

namespace Simon\Assess\Models;

use \Phalcon\Mvc\Model\Resultset\Simple as Resultset;
use \Phalcon\Mvc\Model\Query;
use \Phalcon\Mvc\Model;

class Base extends Model
{
	public static function getDb()
	{
		$di = \Phalcon\DI::getDefault();

		if ( is_null(self::$db) )
		{
			self::$db = $di->get('db');
		}
		return self::$db ;
    }
    
}
