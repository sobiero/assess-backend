<?php

namespace Project\Evaluation\Models;

class User extends Base
{
	public function getSource()
    {
        return 'evm_user'; 
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

	public static function findRolesInEvaluation($evaluationID)
	{
	
		$di = \Phalcon\DI::getDefault();
		$db = $di->get('db');

		$sql = "
			SELECT
				a.evaluation_id,
				b.alt_email,
				b.un_email,
				c.id AS role_id,
				c.role,
				d.id AS role_type_id,
				d.role_type 
			FROM
				evm_evaluation_user_role_map a
				JOIN evm_user b ON ( a.user_id = b.id )
				JOIN evm_ref_role c ON ( a.role_id = c.id )
				JOIN evm_ref_role_type d ON ( c.role_type_id = d.id ) 
			WHERE
				( b.un_email = '".\getUser()."' OR b.alt_email = '".\getUser()."' ) 
				AND a.evaluation_id = ".(int)$evaluationID." 
				AND b.deleted <> 1
		";
					
		$result_set = $db->query($sql);
        $result_set->setFetchMode( \Phalcon\Db::FETCH_ASSOC );
        $result_set = $result_set->fetchAll($result_set);

		return $result_set ;

	}

}
