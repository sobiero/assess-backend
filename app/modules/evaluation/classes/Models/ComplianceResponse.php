<?php

namespace Project\Evaluation\Models;

class ComplianceResponse extends Base
{
	public function getSource()
    {
        return 'evm_compliance_response'; 
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

	    $sql = "SELECT
					`a`.`id` AS `compliance_checklist_id`,
					`a`.`compliance_issue` AS `compliance_issue`,
					`a`.`type` AS `type`,
					`a`.`deleted` AS `deleted`,
					`b`.`id` AS `record_id`,
					`b`.`evaluation_id` AS `evaluation_id`,
					`b`.`response` AS `response`,
					`b`.`comment` AS `comment`,
					`b`.`response_date` AS `response_date`,
					`b`.`response_by_user_email` AS `response_by_user_email` 
				FROM
					`evm_ref_compliance_checklist` `a`
						LEFT JOIN `evm_compliance_response` `b` ON (
							`a`.`id` = `b`.`compliance_checklist_id` 									
					AND `b`.`evaluation_id` = ". (int)$evaluationID .")";
					

		$result_set = $db->query($sql);
        $result_set->setFetchMode( \Phalcon\Db::FETCH_ASSOC );
        $result_set = $result_set->fetchAll($result_set);

		return $result_set ;
	
	}

}
