<?php

namespace Project\Evaluation\Models;

class RecommendationResponsibleUnitMap extends Base
{
	public function getSource()
    {
        return 'evm_recommendation_responsible_unit_map'; 
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
