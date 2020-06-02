<?php

//print_r( $app->getDI()->get('auth')->data('email') ); exit ;

$app->get('/assess', function () use ($app) {

    $data = [ 'data' => 'Project assess Module API', 'error' => null ];
    return sendResponse( 200, $data );
 
});

$app->get('/assess/list', function () use ($app) {

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

$app->get('/assess/user', function () use ($app) {

   try {

      $data = null; 

      $data = \Project\Evaluation\Services\User::loggedInUser();
     
      $data =['data' => $data , 'error' => null ];
      return sendResponse( 200, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 
 
});

$app->get('/assess/logout', function () use ($app) {

   

   try {

	  $auth = $app['auth'];

	  $data = $auth->data();

	  
      $data['iat'] = strtotime('-1 day'); 

  
      $data =['data' => 'Token Expired' , 'error' => null ];
      return sendResponse( 200, $data );

   } catch (\Exception $er) {
      
      $data =['data' => null, 'error' => $er->getMessage()];
      return sendResponse( 500, $data );

   } 
 
});

$app->post('/assess/{evaluationId}/{section}', function ( $evaluationId, $section ) use ($app) {
   
   try {

      $data = null; 

      switch ($section) {
         case 'budget':

			$reqData = \json_decode($_POST['form-data'], true ) ;

			//var_dump( $reqData  ); exit ;

   			$data = !empty($reqData['budget_id']) ? 
				    \Project\Evaluation\Services\EvaluationBudget::update($reqData) :
				    \Project\Evaluation\Services\EvaluationBudget::create($reqData) ;

            break; 

         case 'team':

            $reqData = \json_decode($_POST['form-data'], true ) ;

   			$data = !empty($reqData['user_id']) ? 
				    \Project\Evaluation\Services\User::update($reqData, $app) :
				    \Project\Evaluation\Services\User::create($reqData, $app) ;

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
            $data = \Project\Evaluation\Services\ComplianceChecklistResponse::createOrUpdate($reqData, $evaluationId) ;
            break;
		
		 case 'evaluation-ratings':

			$reqData = \json_decode($_POST['form-data'], true ) ;
            $data = \Project\Evaluation\Services\EvaluationCriteriaResponse::createOrUpdate($reqData, $evaluationId) ;
            break; 	

		case 'recommendations':

			$reqData = \json_decode($_POST['form-data'], true ) ;

   			$data = !empty($reqData['recommendation_id']) ? 
				    \Project\Evaluation\Services\EvaluatorRecommendation::update($reqData) :
				    \Project\Evaluation\Services\EvaluatorRecommendation::create($reqData) ;

            break; 

		case 'final-evaluation-report-comment':

			$reqData = \json_decode($_POST['form-data'], true ) ;

   			$data = !empty($reqData['comment_id']) ? 
				    \Project\Evaluation\Services\FinalEvaluationReportComment::update($reqData) :
				    \Project\Evaluation\Services\FinalEvaluationReportComment::create($reqData) ;

            break; 

		case 'review-finalize-evaluation':

			$reqData = \json_decode($_POST['form-data'], true ) ;

   			$data = \Project\Evaluation\Services\Evaluate::updateStatus($reqData) ;

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
