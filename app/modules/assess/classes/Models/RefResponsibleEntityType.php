<?php

namespace Project\Evaluation\Models;

class RefResponsibleEntityType extends Base
{
	public function getSource()
    {
        return 'evm_ref_responsible_entity_type'; 
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

}
