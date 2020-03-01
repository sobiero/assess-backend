<?php

namespace Project\Evaluation\Models;

class EvaluatorRecommendation extends Base
{
	public function getSource()
    {
        return 'evm_evaluator_recommendation'; 
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
