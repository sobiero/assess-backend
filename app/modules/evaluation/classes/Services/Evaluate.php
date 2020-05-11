<?php

namespace Project\Evaluation\Services;

class Evaluate 
{

    public static function create($data, $app = null)
    {
		//check if already exists
        $obj = \Project\Evaluation\Models\Evaluation::findFirst(
		   " project_type_id = " . $data['project_type_id'] 
	      ." AND evaluation_type_id = " . $data['evaluation_type_id']
		  ." AND project_id = " . $data['project_id']
		);

		if(is_object($obj)){ return $obj; }

		$obj = new \Project\Evaluation\Models\Evaluation();
  	    $obj->date_created           = \date("Y-m-d H:i:s"); 

        $obj = self::save($obj, $data);

        if($obj->project_type_id == 1 ){ //If PIMS project
		  self::saveProjectTeam($obj, $app);
		}

		return $obj;
	   
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

		self::saveEvaluationManager($obj, $data, null);

		return $obj;
	  
    }

	public static function updateStatus($data)
    {
       
	   //var_dump($data);exit;

		$obj = \Project\Evaluation\Models\Evaluation::findFirst($data['evaluation_id']);

		$obj->status_id = $data['status_id'];
		$obj->status_update_date = \date("Y-m-d H:i:s"); 
		$obj->status_update_by_email = \getUser() ;

		$obj->save();

		return $obj;
	  
    }

	public static function saveEvaluationManager($obj, $data, $app = null)
	{
		$data['role_id']       = 2 ;
		$data['staff_obj']     = $data['eval_mgr_staff_obj'];
		$data['evaluation_id'] = $obj->id ;

		@\Project\Evaluation\Services\User::create($data, $app);
			
	}

	public static function saveProjectTeam($obj, $app)
	{
		
		$team = \file_get_contents("http://staging1.unep.org/simon/pims-stg/modules/main/evaluation-api/projectteam?project_id=". $obj->project_id) ;
		$team = @\json_decode($team, true);

		foreach ( $team as $t){
			$user_obj = [];

			if($t['status'] != 'former' ){

				switch ($t['role']) {
				  case 'pm_spv':
					  $user_obj['role_id'] = 7;
				  break;
				  case 'pm':
					  $user_obj['role_id'] = 8;
				  break;
				  case 'fmo':
					  $user_obj['role_id'] = 9;
				  break;
				  default:
					  $user_obj['role_id'] = 0;
				}

				list($first_name, $last_name) = explode(" ", $t['fullname'], 2);

				$user_obj['staff_obj'] = \json_encode( [
					'index_no' => null,
					'firstname'=> $first_name,
					'lastname' => $last_name,
					'unite_id' => null,
					'email' => $t['email'],
				] );

				$user_obj['evaluation_id'] = $obj->id ;

				@\Project\Evaluation\Services\User::create($user_obj, $app);

			}
		
		}
			
	}

}
