<?php

namespace Project\Evaluation\Services;

class EvaluationTimeline 
{

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\EvaluationTimeline();
  	    $obj->date_added           = \date("Y-m-d H:i:s"); 

        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\EvaluationTimeline::findFirst($data['timeline_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

	  $obj->evaluation_id              =  $data['evaluation_id'] ;	  
	  $obj->estimated_initiation_date  =  $data['estimated_initiation_date'] ;
	  $obj->expected_submission_date   =  $data['expected_submission_date'] ;
	  $obj->actual_initiation_date     =  $data['actual_initiation_date'] ;
	  $obj->created_by_email           = \getUser();
	  $obj->deleted                    =  0;

	  $obj->save();

	  return $obj;
	  
    }

}
