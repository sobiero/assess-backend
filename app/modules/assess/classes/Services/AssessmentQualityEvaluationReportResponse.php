<?php

namespace Project\Evaluation\Services;

class AssessmentQualityEvaluationReportResponse 
{

	public static function createOrUpdate($data, $evaluation_id)
	{
      
	  $dt = [];
	  $recs = [];
      
	  foreach($data['response_id'] as $k => $v ){

          $dt['evaluation_id'] = $evaluation_id ;
          $dt['response_id'] = $v ;
		  $dt['criterion_id'] = $k ;
		  $dt['rating_id'] = $data['rating_id'][$k];
		  $dt['eval_office_comment']  = $data['eval_office_comment'][$k];

		  if( !isset($dt['rating_id']) && !isset($dt['eval_office_comment']) ) {

			  if(isset($dt['response_id'])){
				  $recs[] = self::update($dt);
			  }
		  
		  } else {

			  if(isset($dt['response_id'])){

				  $recs[] = self::update($dt);
			  
			  }else{
			      $recs[] = self::create($dt);
			  }
		  
		  }
	  
	  }

	  return $recs ;
      
	}

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\AssessmentQualityEvaluationReportResponse();

        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\AssessmentQualityEvaluationReportResponse::findFirst($data['response_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

	  $obj->evaluation_id =  $data['evaluation_id'] ;	  
	  $obj->criterion_id  =  $data['criterion_id'] ;
	  $obj->eval_office_comment =  trim($data['eval_office_comment']) != "" ? null : trim($data['eval_office_comment']) ;
	  $obj->rating_id  = $data['rating_id'] ;
      $obj->date_rated = \date("Y-m-d H:i:s"); 
	  $obj->rated_by_user_email   = \getUser();
	  $obj->deleted    =  0;

	  $obj->save();

	  return $obj;
	  
    }

}
