<?php

namespace Project\Evaluation\Models;

class EvaluatorRecommendation extends Base
{
	public function getSource()
    {
        return 'evm_evaluator_recommendation'; 
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
					`a`.`id` AS `recommendation_id`,
					`a`.`evaluation_id` AS `evaluation_id`,
					`a`.`nbr` AS `recommendation_nbr`,
					`a`.`priority_id` AS `recommendation_priority_id`,
					`a`.`recommendation` AS `recommendation`,
					`a`.`recommendation_context` AS `recommendation_context`,
					`a`.`by_user_email` AS `recommended_by_user_email`,
					`a`.`date_created` AS `recommendation_date_created`,
					`b`.`id` AS `recommendation_response_id`,
					`b`.`accepted` AS `accepted`,
					`b`.`acceptance_rejection_statement` AS `acceptance_rejection_statement`,
					`b`.`justification` AS `justification`,
					`b`.`what_will_be_done` AS `what_will_be_done`,
					`b`.`measures_taken` AS `measures_taken`,
					`b`.`expected_completion_date` AS `expected_completion_date`,
	
					`b`.`pm_user_email` AS `pm_user_email`,
					`b`.`date_created` AS `response_date_created`,
					GROUP_CONCAT(DISTINCT `d`.`responsible_entity_id` SEPARATOR ', ') AS `assigned_entity_ids`,
					GROUP_CONCAT(DISTINCT `d`.`responsible_entity_name` SEPARATOR ', ') AS `assigned_entity_names`
				FROM
					`evm_evaluator_recommendation` `a`
					LEFT JOIN `evm_pm_recommendation_response` `b` 
					ON ( `a`.`id` = `b`.`evaluator_recommendation_id` AND `b`.deleted <> 1 )
					
					LEFT JOIN evm_recommendation_responsible_entity_map d ON (a.id = d.evaluator_recommendation_id AND d.deleted <> 1)
				WHERE `a`.`deleted` <> 1 AND `a`.`id` IS NOT NULL AND `a`.`evaluation_id` = " . (int)$evaluationID . " GROUP BY `a`.`id` ";

				// print $sql; exit ;
				/*
					`b`.`document_id` AS `doc_id`,
					`c`.`original_name` AS `doc_original_name`,
					`c`.`size_in_bytes` AS `doc_size_in_bytes`,

					LEFT JOIN `evm_document` `c` ON (
					`c`.`id` = `b`.`document_id` 
					AND `c`.deleted <> 1)
				*/

		$result_set = $db->query($sql);
        $result_set->setFetchMode( \Phalcon\Db::FETCH_ASSOC );
        $result_set = $result_set->fetchAll($result_set);

		return $result_set ;
	
	}

}
