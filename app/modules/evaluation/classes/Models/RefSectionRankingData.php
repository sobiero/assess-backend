<?php

namespace Project\Evaluation\Models;

class RefSectionRankingData extends Base
{
	public function getSource()
    {
        return 'evm_section_ranking_data'; 
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
