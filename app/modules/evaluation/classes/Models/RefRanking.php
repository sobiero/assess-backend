<?php

namespace Project\Evaluation\Models;

class RefRanking extends Base
{
	public function getSource()
    {
        return 'evm_ref_ranking'; 
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
