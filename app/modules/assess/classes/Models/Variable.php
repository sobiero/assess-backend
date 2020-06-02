<?php

namespace Simon\Assess\Models;

class Variable extends Base
{
	public function getSource()
    {
        return 'variable'; 
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
