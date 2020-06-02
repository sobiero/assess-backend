<?php

namespace Project\Evaluation\Models;

class ComplianceChecklistResponse extends Base
{
	public function getSource()
    {
        return 'evm_compliance_checklist_response'; 
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
			a.reporting,
			a.`level`,
			b.id AS response_id,
			`b`.`evaluation_id` AS `evaluation_id`,
			`b`.`compliance` AS `compliance`,
			`b`.`comment` AS `comment`,
			`b`.`response_date` AS `response_date`,
			`b`.`response_by_user_email` AS `response_by_user_email` 
		FROM
			evm_ref_compliance_checklist a
			LEFT JOIN evm_compliance_checklist_response b 
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
