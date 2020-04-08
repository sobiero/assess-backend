<?php

namespace Project\Evaluation\Services;

class User 
{

    public static function create($data, $app)
    {

		$obj = new \Project\Evaluation\Models\User();
  	    $obj->created_date           = \date("Y-m-d H:i:s"); 

        return self::save($obj, $data, $app);
	   
    }

	public static function update($data, $app)
    {

		$obj = \Project\Evaluation\Models\User::findFirst($data['user_id']);
        return self::save($obj, $data, $app);
	   
    }

	public static function save($obj, $data, $app)
    {

	  //var_dump($data); exit ;
	
	  if($data['role_id'] == 5 || $data['role_id'] == 6 ){

		list($first_name, $last_name) = explode(" ", $data['full_name'], 2);
	
		$data['belongs_to_menu_item_id'] = 3;

		$doc = self::upload($data, $app);
		$obj->first_name           = $first_name;
		$obj->last_name            = $last_name ;
	   
		//$obj->first_name           = $data['first_name'] ;
		//$obj->last_name            = $data['last_name'] ;
		$obj->alt_email            = $data["email"] ;
		$obj->contract_start_date  = $data["contract_start_date"] ;
		$obj->contract_end_date    = $data["contract_end_date"] ;
		$obj->document_id = @$doc[0]->id ;
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

	public static function upload($data, $app) 
	{

		$data['title'] = 'Consultant CV';
		$data['description'] = 'Consultant CV' ;
		$data['publication_date'] = null ;

		$data = \Project\Evaluation\Services\Document::upload($data, $app);

		return $data; 
	
	}

	public static function delete($user_id) 
	{
		$obj = \Project\Evaluation\Models\User::findFirst( $user_id );
		$obj->delete();
        return $obj ;
	
	}

	public static function loggedInUser()
	{
		$email = \getUser();

		$user = @\file_get_contents('https://apps1.unep.org/umoja-v2/staff/get-by-email/' . $email );

		$user = $user ? \json_decode($user, true) : null ;
		$user = $user['data'] ? $user['data'] : $user ;

		$isAdmin = \Project\Evaluation\Models\Admin::findFirst( " un_email = '". $email . "' AND deleted = 0 " );

		return ['user' => $user, 'is_admin' => $isAdmin ? true : false ];
	
	
	}


}
