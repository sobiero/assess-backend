<?php

namespace Project\Evaluation\Models;

class RefComplianceChecklist extends Base
{
	public function getSource()
    {
        return 'evm_ref_compliance_checklist'; 
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

}