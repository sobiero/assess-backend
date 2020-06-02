<?php

namespace Project\Evaluation\Models;

class EvaluationUserRoleMap extends Base
{
	public function getSource()
    {
        return 'evm_evaluation_user_role_map'; 
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

	public static function findFullDataByEvaluationID($evaluationID){

		$di = \Phalcon\DI::getDefault();
		$db = $di->get('db');

		$sql = "
				SELECT
				    `a`.`evaluation_id` AS `evaluation_id`,
					`a`.`role_id` AS `role_id`,
					`c`.`role` AS `role`,
                    `c`.`role_type_id` AS `role_type_id`,
					`a`.`user_id` AS `user_id`,
					`b`.`first_name` AS `first_name`,
					`b`.`last_name` AS `last_name`,
					`b`.`functional_title` AS `functional_title`,
					`b`.`un_email` AS `un_email`,
					`b`.`alt_email` AS `alt_email`,
					`b`.`index_nbr` AS `index_nbr`,
					`b`.`unite_id` AS `unite_id`,
					`b`.`contract_start_date` AS `contract_start_date`,
					`b`.`contract_end_date` AS `contract_end_date`,
					`b`.`created_date` AS `created_date`,
					`b`.`created_by_email` AS `created_by_email`,
					`d`.id AS doc_id,
					`d`.original_name AS doc_original_name,
                    `d`.type AS doc_type,
					`d`.saved_name AS doc_saved_name,
					`d`.size_in_bytes AS doc_size_in_bytes
				FROM
					`evm_evaluation_user_role_map` `a`
					JOIN `evm_user` `b` ON `a`.`user_id` = `b`.`id`
					JOIN `evm_ref_role` `c` ON `a`.`role_id` = `c`.`id`
					LEFT JOIN `evm_document` `d` ON `b`.`document_id` = `d`.`id`
				WHERE `b`.`deleted` <> 1 AND `a`.`evaluation_id` = " . (int)$evaluationID;

		$result_set = $db->query($sql);
        $result_set->setFetchMode( \Phalcon\Db::FETCH_ASSOC );
        $result_set = $result_set->fetchAll($result_set);

		return $result_set ;
	
	}

}
