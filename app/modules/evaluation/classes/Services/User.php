<?php

namespace Project\Evaluation\Services;

class User 
{

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\User();
  	    $obj->created_date           = \date("Y-m-d H:i:s"); 

        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\User::findFirst($data['user_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {
	
	  if($data['role_id'] == 5 || $data['role_id'] == 6 ){
	   
		$obj->first_name           = $data['first_name'] ;
		$obj->last_name            = $data['last_name'] ;
		$obj->alt_email            = $data["email"] ;
		$obj->contract_start_date  = $data["contract_start_date"] ;
		$obj->contract_end_date    = $data["contract_end_date"] ;
		$obj->created_by_email     = \getUser();
		$obj->deleted              = 0;
		$obj->save();

		$role = new \Project\Evaluation\Models\EvaluationUserRoleMap();
		$role->evaluation_id =  $data['evaluation_id'] ;	 
		$role->user_id       =  $obj->id ;	 
		$role->role_id       =  $data['role_id'] ;
		$role->save();

		return ['user'=>$obj, 'role'=>$role];

	  } else {

		$staff = \json_decode($data['staff_obj'], true);

		$obj->first_name        = $staff["firstname"] ;
		$obj->last_name         = $staff["lastname"] ;
		$obj->un_email          = $staff["email"] ;
		$obj->index_nbr         = $staff["index_no"] ;
		$obj->unite_id          = $staff["unite_id"] ;
		$obj->created_by_email  = \getUser();
		$obj->deleted           = 0;
		$obj->save();

		$role = new \Project\Evaluation\Models\EvaluationUserRoleMap();
		$role->evaluation_id =  $data['evaluation_id'] ;	 
		$role->user_id       =  $obj->id ;	 
		$role->role_id       =  $data['role_id'] ;
		$role->save();

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
