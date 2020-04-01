<?php

namespace Project\Evaluation\Services;

class EvaluationBudget 
{

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\EvaluationBudget();

        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\EvaluationBudget::findFirst($data['budget_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

      $obj->evaluation_id = $data['evaluation_id'] ;	
	  $obj->deleted = 0;
 
	  if($data['logged_in_user_role']['id'] === 1 || $data['logged_in_user_role']['id'] === 3 ){
		  $obj->eval_funds_from_project = $data['eval_funds_from_project'] ;

          if ( $obj->eval_funds_from_project != $data['eval_funds_from_project'] ) {
		     // \Project\Evaluation\Services\EmailNotification::
		  }

		  $obj->umoja_coding_block_for_eval_funds = $data['umoja_coding_block_for_eval_funds'] ;
		  $obj->grant_expiry_date = $data['grant_expiry_date'] ;
		  
		  if($data['logged_in_user_role']['id'] === 3){ 
			$obj->update_by_pm_user_email = \getUser(); 
		    $obj->update_date_pm = \date("Y-m-d H:i:s"); 
		  }
	  } else if ( $data['logged_in_user_role']['id'] === 1 || $data['logged_in_user_role']['id'] === 2 ) {
	     $obj->estimate_total_eval_cost = $data['estimate_total_eval_cost'] ;
	     $obj->is_budget_sufficient = $data['is_budget_sufficient'] ;
	     $obj->em_comment = $data['em_comment'] ;
	
         if($data['logged_in_user_role']['id'] === 2){ 
		    $obj->update_by_em_user_email = \getUser(); 
			$obj->update_date_em = \date("Y-m-d H:i:s"); 
		  }
	  
	  }

	  $obj->save();

	  return $obj;
	  
    }

}
