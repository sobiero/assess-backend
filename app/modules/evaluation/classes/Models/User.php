<?php

namespace Project\Evaluation\Models;

class User extends Base
{
	public function getSource()
    {
        return 'evm_user'; 
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
