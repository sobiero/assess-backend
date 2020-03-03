<?php

namespace Project\Evaluation\Services;

class SectionRanking 
{
	public static function createOrUpdate($data, $evaluation_id)
	{
      
	  $dt =[];
	  $recs = [];
      
	  foreach($data['record_id'] as $k => $v ){

          $dt['evaluation_id'] = $evaluation_id ;
          $dt['record_id'] = $v ;
		  $dt['section_id'] = $k ;
		  $dt['ranking_id'] = $data['ranking_id'][$k];
		  //$dt['comment']  = $data['comment'][$k];

		  if( empty($dt['response']) && empty($dt['comment']) ) {

			  if(!empty($dt['record_id'])){
				  $recs[] = self::update($dt);
			  }
		  
		  } else {

			  if(!empty($dt['record_id'])){

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

		$obj = new \Project\Evaluation\Models\SectionRanking();
  	    
        return self::save($obj, $data);
	   
    }

	public static function update($data)
    {

		$obj = \Project\Evaluation\Models\SectionRanking::findFirst($data['record_id']);
        return self::save($obj, $data);
	   
    }

	public static function save($obj, $data)
    {

	  $obj->evaluation_id           =  $data['evaluation_id'] ;	  
	  $obj->section_id          =  $data['section_id'] ;
	  $obj->ranking_id       =  $data['ranking_id'] ;
	  //$obj->comment    =  trim($data['comment']) == "" ? null : $data['comment'] ;
	  $obj->ranked_by_user_email = \getUser();
	  $obj->rank_date          = \date("Y-m-d H:i:s"); 

	  $obj->save();

	  return $obj;
	  
    }

}
