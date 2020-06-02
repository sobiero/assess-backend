<?php

namespace Project\Evaluation\Services;

class EvaluationCriteriaResponse 
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
		  $dt['summary_assessment'] = $data['summary_assessment'][$k];

		  if ( !isset($dt['rating_id']) && !isset($dt['summary_assessment']) ) {

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

		$obj = new \Project\Evaluation\Models\EvaluationCriteriaResponse();
        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\EvaluationCriteriaResponse::findFirst($data['response_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

	  $obj->evaluation_id =  $data['evaluation_id'] ;	  
	  $obj->criterion_id  =  $data['criterion_id'] ;
	  $obj->rating_id =  $data['rating_id'] ;
	  $obj->summary_assessment  =  trim($data['summary_assessment']) == "" ? null : $data['summary_assessment'] ;
	  $obj->rated_by_user_email = \getUser();
	  $obj->date_rated = \date("Y-m-d H:i:s"); 

	  $obj->save();

	  return $obj;
	  
    }

}
