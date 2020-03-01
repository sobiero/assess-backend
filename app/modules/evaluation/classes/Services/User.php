<?php

namespace Project\Evaluation\Services;

class User 
{

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\User();
  	    $obj->date_added           = \date("Y-m-d H:i:s"); 

        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\User::findFirst($data['user_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

	  $obj->evaluation_id           =  $data['evaluation_id'] ;	  
	  $obj->total_budget            =  $data['total_budget'] ;
	  $obj->portion_available       =  $data['portion_available'] ;
	  $obj->portion_supplemented    =  $data['portion_supplemented'] ;
	  $obj->pm_user_email           = \getUser();
	  $obj->deleted                 = 0;

	  $obj->save();

	  return $obj;
	  
    }

}
