<?php

namespace Project\Evaluation\Services;

class FinalEvaluationReportComment 
{

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\FinalEvaluationReportComment();

        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\FinalEvaluationReportComment::findFirst($data['comment_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {
	
	 // var_dump( $data ); exit ;

	  $obj->evaluation_id = $data['evaluation_id'] ;	  
	  $obj->role_type_id = $data['role_type_id'] ;
	  $obj->comment = trim($data['comment']) != "" ? $data['comment'] : null ;
	  $obj->by_user_email = \getUser();
	  $obj->comment_date = \date("Y-m-d H:i:s"); 
	  $obj->deleted = 0;

	  $obj->save();

	  return $obj;

    }

	public static function delete($comment_id) 
	{
		$obj = \Project\Evaluation\Models\FinalEvaluationReportComment::findFirst( $comment_id );
		$obj->delete();
        return $obj ;
	
	}

}
