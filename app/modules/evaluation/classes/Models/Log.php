<?php

namespace Project\Evaluation\Models;

class Log extends Base
{
	public function getSource()
    {
        return 'evm_log'; 
    }

    public function initialize()
    {

    }

	public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
