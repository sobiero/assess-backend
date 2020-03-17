<?php

namespace Project\Evaluation\Services;

class AssessmentQualityEvaluationReportResponse 
{

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\AssessmentQualityEvaluationReportResponse();
  	    $obj->date_ranked           = \date("Y-m-d H:i:s"); 

        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\AssessmentQualityEvaluationReportResponse::findFirst($data['record_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

	  $obj->evaluation_id        =  $data['evaluation_id'] ;	  
	  $obj->criteria_section_id  =  $data['criteria_section_id'] ;
	  $obj->draft_report_rating_id   =  $data['draft_report_rating_id'] ;
	  $obj->draft_report_comment     =  $data['draft_report_comment'] ;
	  $obj->complete_report_rating_id  = $data['complete_report_rating_id'] ;
      $obj->complete_report_comment = $data['complete_report_comment'] ;
	  $obj->ranked_by_user_email   = \getUser();
	  $obj->deleted                    =  0;

	  $obj->save();

	  return $obj;
	  
    }

}



