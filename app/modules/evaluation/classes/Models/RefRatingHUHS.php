<?php

namespace Project\Evaluation\Models;

//Highly Unsatis to Highly Satis

class RefRatingHUHS extends Base
{
	public function getSource()
    {
        return 'evm_ref_rating_hu_hs'; 
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
