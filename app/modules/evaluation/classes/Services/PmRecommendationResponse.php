<?php

namespace Project\Evaluation\Services;

class PmRecommendationResponse 
{

    public static function create($data, $app)
    {

		$obj = new \Project\Evaluation\Models\PmRecommendationResponse();
  	    $obj->date_created           = \date("Y-m-d H:i:s"); 

        return self::save($obj, $data, $app);
	   
    }

	public static function update($data, $app)
    {

		$obj = \Project\Evaluation\Models\PmRecommendationResponse::findFirst($data['recommendation_response_id']);
        return self::save($obj, $data, $app);
	   
    }

	public static function save($obj, $data, $app)
    {

		$doc = self::upload($data, $app);
		$obj->evaluator_recommendation_id    = $data['evaluator_recommendation_id'] ;
		$obj->accepted = $data['accepted'] ; 
		$obj->acceptance_rejection_statement      = $data['acceptance_rejection_statement'] ;
		$obj->justification = $data['justification'] ;
		$obj->what_will_be_done = $data['what_will_be_done'] ;
		$obj->measures_taken = $data['measures_taken'] ;
		$obj->expected_completion_date = $data['expected_completion_date'] ;
		$obj->document_id = @$doc[0]->id ;
		$obj->pm_user_email   = \getUser() ;
		$obj->deleted            = 0;

		$obj->save();

		return $obj;
	  
    }

	public static function upload($data, $app) 
	{

		$data['title'] = null;
		$data['description'] = null ;
		$data['publication_date'] = null ;

		$data = \Project\Evaluation\Services\Document::upload($data, $app);

		return $data; 
	
	}

}