<?php

namespace Project\Evaluation\Services;

class Admin 
{

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\Admin();
  	    $obj->created_date = \date("Y-m-d H:i:s"); 

        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\Admin::findFirst($data['admin_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {
	
		$obj->first_name        = $data["firstname"] ;
		$obj->last_name         = $data["lastname"] ;
		$obj->un_email          = $data["email"] ;
		$obj->index_nbr         = $data["index_no"] ;
		$obj->unite_id          = $data["unite_id"] ;
		$obj->created_by_email  = \getUser();
		$obj->deleted           = 0;
		$obj->save();

		return ['user'=>$obj, 'role'=>$role];
	  
	  }
	  
    }

	public static function delete($user_id) 
	{
		$obj = \Project\Evaluation\Models\User::findFirst( $user_id );
		$obj->delete();
        return $obj ;
	
	}

}