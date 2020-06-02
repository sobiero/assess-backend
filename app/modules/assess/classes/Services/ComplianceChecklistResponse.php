<?php

namespace Project\Evaluation\Services;

class ComplianceChecklistResponse 
{
	public static function createOrUpdate($data, $evaluation_id)
	{
      
	  $dt =[];
	  $recs = [];
      
	  foreach($data['response_id'] as $k => $v ){

          $dt['evaluation_id'] = $evaluation_id ;
          $dt['response_id'] = $v ;
		  $dt['criterion_id'] = $k ;
		  $dt['compliance'] = $data['compliance'][$k];
		  $dt['comment']  = $data['comment'][$k];

		  if( !isset($dt['compliance']) && !isset($dt['comment']) ) {

			  if(isset($dt['response_id'])){
				  $recs[] = self::update($dt);
			  }
		  
		  } else {

			  if(isset($dt['response_id'])){

				  $recs[] = self::update($dt);
			  
			  }else{
			      $recs[] = self::create($dt);
			  }
		  
		  }
	  
	  }

	  return $recs ;
      
	}

    public static function create($data)
    {

		$obj = new \Project\Evaluation\Models\ComplianceChecklistResponse();
  	    
        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\ComplianceChecklistResponse::findFirst($data['response_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

	  $obj->evaluation_id =  $data['evaluation_id'] ;	  
	  $obj->criterion_id  =  $data['criterion_id'] ;
	  $obj->compliance    =  $data['compliance'] ;
	  $obj->comment    =  trim($data['comment']) == '' ? null : $data['comment'] ;
	  $obj->response_by_user_email = \getUser();
	  $obj->response_date = \date("Y-m-d H:i:s"); 
  	  $obj->deleted = 0;

	  $obj->save();

	  return $obj;
	  
    }

}
