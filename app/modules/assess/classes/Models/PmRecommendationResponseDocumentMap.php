<?php

namespace Project\Evaluation\Models;

class PmRecommendationResponseDocumentMap extends Base
{
	public function getSource()
    {
        return 'evm_pm_recommendation_response_document_map'; 
    }

    public function initialize()
    {
	   
    }

	public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

	public static function getDocumentsByEvaluationResponseID($recommendation_response_id)
    {
        $di = \Phalcon\DI::getDefault();
		$db = $di->get('db');

		$sql = "
				SELECT
					`a`.`pm_recommendation_response_id` AS `pm_recommendation_response_id`,
					`a`.`document_id` AS `doc_id`,
					`b`.`evaluation_id` AS `evaluation_id`,
					`b`.`belongs_to_menu_item_id` AS `belongs_to_menu_item_id`,
					`b`.`title` AS `doc_title`,
					`b`.`description` AS `doc_description`,
					`b`.`publication_date` AS `publication_date`,
					`b`.`commenting_due_date` AS `commenting_due_date`,
					`b`.`original_name` AS `doc_original_name`,
					`b`.`type` AS `doc_type`,
					`b`.`saved_name` AS `doc_saved_name`,
					`b`.`size_in_bytes` AS `doc_size_in_bytes`,
					`b`.`upload_by_user_email` AS `upload_by_user_email`,
					`b`.`upload_date` AS `upload_date`,
					`b`.`deleted` AS `deleted` 
				FROM
					`evm_pm_recommendation_response_document_map` `a`
					JOIN `evm_document` `b` ON (
						`a`.`document_id` = `b`.`id` 
					AND `a`.`pm_recommendation_response_id` = ". (int)$recommendation_response_id ."
					) WHERE `b`.`deleted` <> 1" ;

		$result_set = $db->query($sql);
        $result_set->setFetchMode( \Phalcon\Db::FETCH_ASSOC );
        $result_set = $result_set->fetchAll($result_set);

		return $result_set ;
    }



}
