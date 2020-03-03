<?php

namespace Project\Evaluation\Models;

class SectionRanking extends Base
{
	public function getSource()
    {
        return 'evm_section_ranking'; 
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
					`a`.`id` AS `section_id`,
					`a`.`title` AS `section_title`,
					`b`.`evaluation_id` AS `evaluation_id`,
					`b`.`id` AS `record_id`,
					`b`.`ranking_id` AS `ranking_id`,
					`b`.`rank_date` AS `rank_date`,
					`b`.ranked_by_user_email AS ranked_by_user_email 
				FROM
					`evm_ref_section` `a`
					LEFT JOIN `evm_section_ranking` `b` 
					ON ( `a`.`id` = `b`.`section_id` 
					AND `b`.`evaluation_id` = ". (int)$evaluationID ."
					AND `b`.`deleted` <> 1 ) 
				WHERE
					`a`.`deleted` <> 1";
					
		$result_set = $db->query($sql);
        $result_set->setFetchMode( \Phalcon\Db::FETCH_ASSOC );
        $result_set = $result_set->fetchAll($result_set);

		return $result_set ;
	
	}

}
