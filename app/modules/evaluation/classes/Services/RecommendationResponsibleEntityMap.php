<?php

namespace Project\Evaluation\Services;

class RecommendationResponsibleEntityMap 
{

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\RecommendationResponsibleEntityMap();
        $obj->assigned_date = \date("Y-m-d H:i:s"); 
        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\RecommendationResponsibleEntityMap::findFirst($data['record_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

		switch ($data['responsible_entity_type_id'] ) {

         case '1':

			$tmp = \json_decode( $data['responsible_entity_staff_obj'], true );
   			$responsible_entity_id   = $tmp['email'];
   			$responsible_entity_name = $tmp['firstname'] . ' ' . $tmp['lastname'] ;

            break;  
			
		 case '2':
		 case '3':

			//$tmp = \json_decode( $data['responsible_entity_branch_obj'], true );
   			$responsible_entity_id   = $data['responsible_entity_branch_obj']['id'];
   			$responsible_entity_name = $data['responsible_entity_branch_obj']['branch'];

            break;   
		
		 case '4':

			//$tmp = \json_decode( $data['responsible_entity_division_obj'], true );
   			$responsible_entity_id   = $data['responsible_entity_division_obj']['division_id'];
   			$responsible_entity_name = $data['responsible_entity_division_obj']['division'];

            break;  

         default:
            break;
        }

		$obj->evaluator_recommendation_id    = $data['evaluator_recommendation_id'] ;
		$obj->responsible_entity_type_id     = $data['responsible_entity_type_id'] ; 
		$obj->responsible_entity_id          = $responsible_entity_id ;
		$obj->responsible_entity_name        = $responsible_entity_name ;

	    $obj->assigned_date = \date("Y-m-d H:i:s"); 
		$obj->assigned_by_user_email   = \getUser() ;
		$obj->deleted            = 0;

		$obj->save();

		return $obj;
	  
    }

	public static function delete($id)
    {

		$obj = \Project\Evaluation\Models\RecommendationResponsibleEntityMap::findFirst($id);
        $obj->delete();

	    return $obj ;
    }

}
