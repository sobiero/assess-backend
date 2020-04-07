<?php

namespace Project\Evaluation\Services;

class Evaluate 
{

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\Evaluation();
  	    $obj->date_created           = \date("Y-m-d H:i:s"); 

        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\Evaluation::findFirst($data['evaluation_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

		$obj->project_type_id    = $data['project_type_id'] ;
		$obj->evaluation_type_id = $data['evaluation_type_id'] ; 
		$obj->project_title      = $data['project_title'] ;
		$obj->project_id         = $data['project_id'] ;

		$obj->project_start_date = $data['project_start_date'] ;
		$obj->project_end_date   = $data['project_end_date'] ;
		$obj->created_by_email   = \getUser() ;
		$obj->deleted            = 0;

		$obj->save();

		return $obj;
	  
    }

	public static function updateStatus($data)
    {

		$obj = \Project\Evaluation\Models\Evaluation::findFirst($data['evaluation_id']);

		$obj->status_id = $data['status_id'];
		$obj->status_update_date = \date("Y-m-d H:i:s"); 
		$obj->status_update_by_email = \getUser() ;

		$obj->save();

		return $obj;
	  
    }


}
