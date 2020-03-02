<?php

namespace Project\Evaluation\Models;

class QaCriteriaSectionRanking extends Base
{
	public function getSource()
    {
        return 'evm_qa_criteria_section_ranking'; 
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
					`a`.`id` AS `criteria_section_id`,
					`a`.`criteria` AS `criteria`,
					`a`.`question` AS `question`,
					`a`.`class` AS `class`,
					`b`.`id` AS `ranking_id`,
					`b`.`evaluation_id` AS `evaluation_id`,
					`b`.`draft_report_rating_id` AS `draft_report_rating_id`,
					`b`.`draft_report_comment` AS `draft_report_comment`,
					`b`.`complete_report_rating_id` AS `complete_report_rating_id`,
					`b`.`complete_report_comment` AS `complete_report_comment`,
					`b`.`date_ranked` AS `date_ranked`,
					`b`.`ranked_by_user_email` AS `ranked_by_user_email` 
				FROM
					`evm_ref_criteria_section` `a`
					LEFT JOIN `evm_qa_criteria_section_ranking` `b` ON (
							`a`.`id` = `b`.`criteria_section_id` 
							AND `b`.`deleted` <> 1  
							AND `b`.`evaluation_id` = ". (int)$evaluationID ." ) 
				WHERE
					`a`.`deleted` <> 1 ";

		$result_set = $db->query($sql);
        $result_set->setFetchMode( \Phalcon\Db::FETCH_ASSOC );
        $result_set = $result_set->fetchAll($result_set);

		return $result_set ;
	
	}

}
