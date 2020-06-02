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

		$obj = \Project\Evaluation\Models\EvaluatorRecommendation::findFirst($data['recommendation_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

	  $obj->evaluation_id    = $data['evaluation_id'] ;	  
	  $obj->nbr            = $data['nbr'] ;
	  $obj->priority_id            = $data['priority_id'] ;
	  $obj->recommendation      = $data['recommendation'] ;
	  $obj->recommendation_context      = $data['recommendation_context'] ;

	  $obj->by_user_email    = \getUser();
	  $obj->deleted          = 0;

	  $obj->save();

	  return $obj;

    }

	public static function delete($recommendation_id) 
	{
		$obj = \Project\Evaluation\Models\EvaluatorRecommendation::findFirst( $recommendation_id );
		$obj->delete();
        return $obj ;
	
	}

}
