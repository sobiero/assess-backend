<?php

namespace Project\Evaluation\Services;

class EvaluatorRecommendation 
{

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\EvaluatorRecommendation();
  	    $obj->date_created           = \date("Y-m-d H:i:s"); 

        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\EvaluatorRecommendation::findFirst($data['budget_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

	  $obj->evaluation_id    = $data['evaluation_id'] ;	  
	  $obj->title            = $data['title'] ;
	  $obj->description      = $data['description'] ;
	  $obj->by_user_email    = \getUser();
	  $obj->deleted          = 0;

	  $obj->save();

	  return $obj;

    }

}
