<?php

namespace Project\Evaluation\Models;

class AssessmentQualityEvaluationReportResponse extends Base
{
	public function getSource()
    {
        return 'evm_assessment_quality_evaluation_report_response'; 
    }

    public function initialize()
    {
        $this->addBehavior(new \Phalcon\Mvc\Model\Behavior\SoftDelete(
            [
                'field' => 'deleted',
                'value' => 1
            ]
        ));
	   
    }

	public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

	public static function findFullDataByEvaluationID($evaluationID){

		$di = \Phalcon\DI::getDefault();
		$db = $di->get('db');

		$sql = "
			SELECT
				a.id AS criterion_id,
				a.criterion,
				a.parent_id,
				a.`level`,
				a.reporting,
				b.evaluation_id,
				b.id AS response_id,
				b.eval_office_comment,
				b.rating_id,
				b.date_rated,
				b.rated_by_user_email 
			FROM
				evm_ref_assessment_quality_evaluation_report a
				LEFT JOIN evm_assessment_quality_evaluation_report_response b 
				ON ( a.id = b.criterion_id 
				     AND b.evaluation_id = ". (int)$evaluationID ." 
					 AND b.deleted <> 1 
				) 
			WHERE
				a.deleted <> 1 
			ORDER BY
				a.`level`,
				a.`order`

		";

					
		$result_set = $db->query($sql);
        $result_set->setFetchMode( \Phalcon\Db::FETCH_ASSOC );
        $result_set = $result_set->fetchAll($result_set);

		return $result_set ;
	
	}

}
