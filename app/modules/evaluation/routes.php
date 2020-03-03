<?php

$app->get('/evaluation', function () use ($app) {

    $data = [ 'data' => 'Project Evaluation Module API', 'error' => null ];
    return sendResponse( 200, $data );
 
});

$app->get('/evaluation/{evaluationId}/{section}', function ( $evaluationId, $section ) use ($app) {
   
   try {

      $data = null; 

      switch ($section) {
         case 'budget':
            $data = \Project\Evaluation\Models\EvaluationBudget::findFirst(' evaluation_id = '. $evaluationId .' AND deleted = 0');
            break;
         
         case 'tor':
            $data = \Project\Evaluation\Models\Document::find(' evaluation_id = '. $evaluationId .' AND belongs_to_menu_item_id = 2 AND deleted = 0');
            break;   

         case 'team':
            $data = \Project\Evaluation\Models\EvaluationUserRoleMap::findFullDataByEvaluationID( $evaluationId );
            break;   
			
         case 'timeline':
            $data = \Project\Evaluation\Models\EvaluationTimeline::findFirst(' evaluation_id = '. $evaluationId .' AND deleted = 0');
            break;  
			
         case 'inception-report':
            $data = \Project\Evaluation\Models\Document::find(' evaluation_id = '. $evaluationId .' AND belongs_to_menu_item_id = 5 AND deleted = 0');
            break;   

         case 'draft-main-report':
            $data = \Project\Evaluation\Models\Document::find(' evaluation_id = '. $evaluationId .' AND belongs_to_menu_item_id = 6 AND deleted = 0');
            break;   

         case 'complete-report':
            $data = \Project\Evaluation\Models\Document::find(' evaluation_id = '. $evaluationId .' AND belongs_to_menu_item_id = 7 AND deleted = 0');
            break; 

         case 'qualitative-assessment':
            $data = \Project\Evaluation\Models\QaCriteriaSectionRanking::findFullDataByEvaluationID( $evaluationId );
            break; 

		case 'compliance-checklist':
            $data = \Project\Evaluation\Models\ComplianceResponse::findFullDataByEvaluationID( $evaluationId );
            break; 
		
		case 'evaluation-ratings':
            $data = \Project\Evaluation\Models\SectionRanking::findFullDataByEvaluationID( $evaluationId );
            break; 

         default:
            return sendResponse( 404, [ 'data' => $data , 'error' => 'Not Found' ] );
            break;
      }
            
      $data =['data' => $data , 'error' => null ];
      return sendResponse( 200, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});

$app->post('/evaluation/{evaluationId}/{section}', function ( $evaluationId, $section ) use ($app) {
   
   try {

      $data = null; 

      switch ($section) {
         case 'budget':

			$reqData = \json_decode($_POST['form-data'], true ) ;

   			$data = !empty($reqData['budget_id']) ? 
				    \Project\Evaluation\Services\EvaluationBudget::update($reqData) :
				    \Project\Evaluation\Services\EvaluationBudget::create($reqData) ;

            break; 

         case 'team':

            $reqData = \json_decode($_POST['form-data'], true ) ;

   			$data = !empty($reqData['user_id']) ? 
				    \Project\Evaluation\Services\User::update($reqData) :
				    \Project\Evaluation\Services\User::create($reqData) ;

            break;   
			
         case 'timeline':

            $reqData = \json_decode($_POST['form-data'], true ) ;

   			$data = !empty($reqData['timeline_id']) ? 
				    \Project\Evaluation\Services\EvaluationTimeline::update($reqData) :
				    \Project\Evaluation\Services\EvaluationTimeline::create($reqData) ;

            break; 
			
         case 'inception-report':
            $data = \Project\Evaluation\Models\Document::find(' evaluation_id = '. $evaluationId .' AND belongs_to_menu_item_id = 5 AND deleted = 0');
            break;   

         case 'draft-main-report':
            $data = \Project\Evaluation\Models\Document::find(' evaluation_id = '. $evaluationId .' AND belongs_to_menu_item_id = 6 AND deleted = 0');
            break;   

         case 'complete-report':
            $data = \Project\Evaluation\Models\Document::find(' evaluation_id = '. $evaluationId .' AND belongs_to_menu_item_id = 7 AND deleted = 0');
            break; 

         case 'qualitative-assessment':
            $reqData = \json_decode($_POST['form-data'], true ) ;

   			$data = !empty($reqData['record_id']) ? 
				    \Project\Evaluation\Services\QaCriteriaSectionRanking::update($reqData) :
				    \Project\Evaluation\Services\QaCriteriaSectionRanking::create($reqData) ;

            break; 

		 case 'compliance-checklist':

			$reqData = \json_decode($_POST['form-data'], true ) ;
            $data = \Project\Evaluation\Services\ComplianceResponse::createOrUpdate($reqData, $evaluationId) ;
            break;
		
		 case 'evaluation-ratings':

			$reqData = \json_decode($_POST['form-data'], true ) ;
            $data = \Project\Evaluation\Services\SectionRanking::createOrUpdate($reqData, $evaluationId) ;
            break; 	
		

         default:
            return sendResponse( 404, [ 'data' => $data , 'error' => 'Not Found' ] );
            break;
      }
            
      $data =['data' => $data , 'error' => null ];
      return sendResponse( 201, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});

$app->delete('/evaluation/{evaluationId}/{section}/delete/{user_id}', function ( $evaluationId, $section, $user_id ) use ($app) {

 try {

      $data = null; 

      switch ($section) {

         case 'team':

   			$data =  \Project\Evaluation\Services\User::delete( $user_id ) ;

            break;   
			

         default:
            return sendResponse( 404, [ 'data' => $data , 'error' => 'Not Found' ] );
            break;
      }
            
      $data =['data' => $data , 'error' => null ];
      return sendResponse( 201, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});

$app->get('/evaluation/ref/{refTable}', function ($refTable) use ($app) {
   
   try {

      $data = null; 

      switch ($refTable) {
         case 'compliance-checklist':
            $data = \Project\Evaluation\Models\RefComplianceChecklist::find('deleted = 0');
            break;
         
         case 'evaluation-type':
            $data = \Project\Evaluation\Models\RefEvaluationType::find();
            break;   
            
         case 'criteria-section':
            $data = \Project\Evaluation\Models\RefCriteriaSection::find('deleted = 0');
            break;   
		 
		 case 'menu-item':
            $data = \Project\Evaluation\Models\RefMenuItem::find('deleted = 0');
            break;   

         case 'project-type':
            $data = \Project\Evaluation\Models\RefProjectType::find('deleted = 0');
            break;   

         case 'ranking':
            $data = \Project\Evaluation\Models\RefRanking::find();
            break;  

         case 'responsible-entity-type':
            $data = \Project\Evaluation\Models\RefResponsibleEntityType::find('deleted = 0');
            break;  

         case 'role':
            $data = \Project\Evaluation\Models\RefRole::find('deleted = 0');
            break;  

         case 'section':
            $data = \Project\Evaluation\Models\RefSection::find('deleted = 0');
            break;  

         default:
            return sendResponse( 404, [ 'data' => $data , 'error' => 'Not Found' ] );
            break;
      }
            
      $data =['data' => $data , 'error' => null ];
      return sendResponse( 200, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});

$app->post('/evaluation/evaluate', function () use ($app) {
   
   try {

	  $data = \json_decode($_POST['form-data'], true);
	  $evaluation = new \Project\Evaluation\Models\Evaluation();

	  $evaluation->project_type_id    = $data['project_type_id'] ;
	  $evaluation->evaluation_type_id = $data['evaluation_type_id'] ; 
	  $evaluation->project_title      = $data['project_title'] ;
	  $evaluation->project_id         = $data['project_id'] ;

	  $evaluation->project_start_date = $data['project_start_date'] ;
	  $evaluation->project_end_date   = $data['project_end_date'] ;
	  $evaluation->created_by_email   = getUser() ;

      $evaluation->save();
           
      $data =['data' => [ $evaluation ] , 'error' => null ];
      return sendResponse( 201, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});

$app->post('/evaluation/document', function () use ($app) {
   
   try {

	$prop = \json_decode($_POST['form-data'], true);
	$docs = [];
     
	if ($app->request->hasFiles() == true) {

        $x = 0;

		foreach ($app->request->getUploadedFiles() as $file) {

			$saved_name = uniqid() . "_" .$file->getName() ;
			
			if ( @$file->moveTo($app->config->app->upload_dir . $saved_name ) ) {
			
				//$doc = new \Project\Evaluation\Models\Document();

				$doc = !empty($prop['doc_id']) ? 
				    \Project\Evaluation\Models\Document::findFirst($prop['doc_id']) :
				    new \Project\Evaluation\Models\Document() ;

				$doc->evaluation_id           = $prop['evaluation_id'];
				$doc->belongs_to_menu_item_id = $prop['belongs_to_menu_item_id'];
				$doc->title                   = $prop['title'];
				$doc->description             = $prop['description'];
				$doc->publication_date        = $prop['publication_date'];
				$doc->original_name           = $file->getName();
				$doc->saved_name              = $saved_name ;
				$doc->size_in_bytes           = $file->getSize();
				$doc->upload_by_user_email    = getUser();

				$doc->save();

				$docs[$x] = $doc ;

				$x++;

			} else {

				throw new Exception('Error saving file in the server');
			
			}

		}
    } else {

		if ( !empty($prop['doc_id']) ) {

			$doc = \Project\Evaluation\Models\Document::findFirst($prop['doc_id']) ;

			$doc->title                   = $prop['title'];
			$doc->description             = $prop['description'];
			$doc->publication_date        = $prop['publication_date'];
			$doc->save();
		
		    $docs[0] = $doc ;
		}
	
	}

	if (empty($docs)) {

		$data =['data' => [$docs] , 'error' => 'Incomplete details provided. Resource not created' ];
        return sendResponse( 406, $data );
	
	}
           
    $data =['data' => [$docs] , 'error' => null ];
    return sendResponse( 201, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});

/*
$app->put('/evaluation/document', function () use ($app) {
   
   try {

      $data = \file_get_contents('php://input'); 

	  print_r( $_FILES ); exit; 
	  
	    if ($app->request->hasFiles() == true) {
            // Print the real file names and sizes
            foreach ($app->request->getUploadedFiles() as $file) {

                //Print file details
                echo $file->getName(), " ", $file->getSize(), "\n"; exit;

                //Move the file into the application
                //$file->moveTo('files/');
            }
        }
	  
	  //var_dump($_GET); 
	  //print_r($data); exit;
	  //$data = \json_decode($data, true);
 	  //$data = \json_decode($data['data'], true);;

           
      $data =['data' => [$data] , 'error' => null ];
      return sendResponse( 201, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});
*/

