<?php

namespace Project\Evaluation\Models;

class RefRatingScale extends Base
{
	public function getSource()
    {
        return 'evm_ref_rating_scale'; 
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
