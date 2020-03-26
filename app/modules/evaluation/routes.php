<?php

//print_r( $app->getDI()->get('auth')->data('email') ); exit ;

$app->get('/evaluation', function () use ($app) {

    $data = [ 'data' => 'Project Evaluation Module API', 'error' => null ];
    return sendResponse( 200, $data );
 
});

$app->get('/evaluation/list', function () use ($app) {

   try {

      $data = null; 

      $data = \Project\Evaluation\Models\Evaluation::find('deleted = 0');
     
      $data =['data' => $data , 'error' => null ];
      return sendResponse( 200, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 
 
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

         case 'assessment-report-quality':
            $data = \Project\Evaluation\Models\AssessmentQualityEvaluationReportResponse::findFullDataByEvaluationID( $evaluationId );
            break; 

		case 'compliance-checklist':
            $data = \Project\Evaluation\Models\ComplianceChecklistResponse::findFullDataByEvaluationID( $evaluationId );
            break; 
		
		case 'evaluation-ratings':
            $data = \Project\Evaluation\Models\EvaluationCriteriaResponse::findFullDataByEvaluationID( $evaluationId );
            break; 

		case 'recommendations':
            $data = \Project\Evaluation\Models\EvaluatorRecommendation::findFullDataByEvaluationID( $evaluationId );
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
			
         case 'assessment-report-quality':
            $reqData = \json_decode($_POST['form-data'], true ) ;

   			$data =  \Project\Evaluation\Services\AssessmentQualityEvaluationReportResponse::createOrUpdate($reqData, $evaluationId) ;

            break; 

		 case 'compliance-checklist':

			$reqData = \json_decode($_POST['form-data'], true ) ;
            $data = \Project\Evaluation\Services\ComplianceResponse::createOrUpdate($reqData, $evaluationId) ;
            break;
		
		 case 'evaluation-ratings':

			$reqData = \json_decode($_POST['form-data'], true ) ;
            $data = \Project\Evaluation\Services\SectionRanking::createOrUpdate($reqData, $evaluationId) ;
            break; 	

		case 'recommendations':

			$reqData = \json_decode($_POST['form-data'], true ) ;

   			$data = !empty($reqData['recommendation_id']) ? 
				    \Project\Evaluation\Services\EvaluatorRecommendation::update($reqData) :
				    \Project\Evaluation\Services\EvaluatorRecommendation::create($reqData) ;

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

$app->post('/evaluation/{evaluationId}/recommendations/{recommendation_id}/acceptance', function ( $evaluationId, $recommendation_id ) use ($app) {

    try {

      $data = null; 

	  	$reqData = \json_decode($_POST['form-data'], true ) ;

   		$data = !empty($reqData['recommendation_response_id']) ? 
				    \Project\Evaluation\Services\PmRecommendationResponse::update($reqData, $app) :
				    \Project\Evaluation\Services\PmRecommendationResponse::create($reqData, $app) ;

                  
      $data =['data' => $data , 'error' => null ];
      return sendResponse( 201, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});

$app->get('/evaluation/{evaluationId}/recommendations/{recommendation_id}/assignment', function ( $evaluationId, $recommendation_id ) use ($app) {

    try {

        $data = null; 

   		$data = \Project\Evaluation\Models\RecommendationResponsibleEntityMap::find(' evaluator_recommendation_id = '. $recommendation_id .' AND deleted = 0');
               
        $data =['data' => $data , 'error' => null ];
        return sendResponse( 200, $data );

   } catch (\Exception $er) {
      
        $data =['data' => null, 'error' => $er->getMessage()];
        return sendResponse( 500, $data );

   } 

});

$app->post('/evaluation/{evaluationId}/recommendations/{recommendation_id}/assignment', function ( $evaluationId, $recommendation_id ) use ($app) {

    try {

        $data = null; 

	  	$reqData = \json_decode($_POST['form-data'], true ) ;

   		$data =   \Project\Evaluation\Services\RecommendationResponsibleEntityMap::create($reqData) ;

                  
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
            
         case 'evaluation-criteria':
            $data = \Project\Evaluation\Models\RefEvaluationCriteria::find('deleted = 0');
            break;   
		 
		 case 'menu-item':
            $data = \Project\Evaluation\Models\RefMenuItem::find('deleted = 0');
            break;   

         case 'project-type':
            $data = \Project\Evaluation\Models\RefProjectType::find('deleted = 0');
            break;   

         case 'rating-hu-hs':
            $data = \Project\Evaluation\Models\RefRatingHUHS::find();
            break;  

         case 'responsible-entity-type':
            $data = \Project\Evaluation\Models\RefResponsibleEntityType::find('deleted = 0');
            break;  

         case 'role':
            $data = \Project\Evaluation\Models\RefRole::find('deleted = 0');
            break;  

         case 'assessment-report-quality':
            $data = \Project\Evaluation\Models\RefQualitativeAssessmentEvaluationReport::find('deleted = 0');
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

	  $reqData = \json_decode($_POST['form-data'], true);

	  $data = !empty($reqData['evaluation_id']) ? 
				    \Project\Evaluation\Services\Evaluate::update($reqData) :
				    \Project\Evaluation\Services\Evaluate::create($reqData) ;
           
      $data =['data' => $data , 'error' => null ];
      return sendResponse( 201, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});

$app->post('/evaluation/document', function () use ($app) {
   
   try {

	$reqData = \json_decode($_POST['form-data'], true);

	$docs = \Project\Evaluation\Services\Document::upload($reqData, $app);
	
	if (empty($docs)) {

		$data =['data' => $docs , 'error' => 'Incomplete details provided. Resource not created' ];
        return sendResponse( 406, $data );
	
	}
           
    $data =['data' => $docs , 'error' => null ];
    return sendResponse( 201, $data );

   } catch (\Exception $er) {
      
        $data =['data' => null, 'error' => $er->getMessage()];
        return sendResponse( 500, $data );

   } 

});

$app->delete('/evaluation/{evaluationId}/{section}/delete/{record_id}', function ( $evaluationId, $section, $record_id ) use ($app) {

 try {

      $data = null; 

      switch ($section) {

         case 'team':

   			$data =  \Project\Evaluation\Services\User::delete( $record_id ) ;

            break;  
			
		 case 'recommendations':

   			$data =  \Project\Evaluation\Services\EvaluatorRecommendation::delete( $record_id ) ;

            break;   
			

         default:
            return sendResponse( 404, [ 'data' => $data , 'error' => 'Not Found' ] );
            break;
      }
            
      $data =['data' => $data , 'error' => null ];
      return sendResponse( 202, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});

$app->delete('/evaluation/{evaluationId}/{section}/{recommendation_id}/assignment/delete/{record_id}', function ( $evaluationId, $section, $recommendation_id, $record_id ) use ($app) {

 try {

      $data = null; 

      switch ($section) {
	
		 case 'recommendations':

   			$data =  \Project\Evaluation\Services\RecommendationResponsibleEntityMap::delete( $record_id ) ;

            break;   
			
         default:
            return sendResponse( 404, [ 'data' => $data , 'error' => 'Not Found' ] );
            break;
      }
            
      $data =['data' => $data , 'error' => null ];
      return sendResponse( 202, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 

});
