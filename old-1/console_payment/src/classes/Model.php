<?php

namespace Apo100l\Quest;

require_once 'QuestAbstract.php';


class Model extends QuestAbstract
{
    protected $db;

    public function init()
    {
        $this->db = $this->getDb();
    }

    public function getStatistics(array $params, array $dates = null)
    {
        $between = null;

        if(!empty($dates['start']) or !empty($dates['end']))
        {
            if(!$dates['start'])
                $dates['start'] = '2000-01-01';

            if(!$dates['end'])
                $dates['end'] = date('Y-m-d');

            $dates['end'] .= ' 23:59:59';

            $dates = array_map(function($value){
                return str_replace("'", '', $value);
            }, $dates);

            $between = "AND payments.create_ts BETWEEN '{$dates['start']}' and '{$dates['end']}'";
        }

        //Документы которые присутствуют в таблице documents для платежей (сформированы)
        if (in_array('with-documents', $params))
        {
            $query = "SELECT COUNT(*) AS count, SUM(amount) AS amount FROM payments, documents  WHERE payments.id = documents.entity_id $between";

            $results['with-documents'] = $this->db->query($query);
            
            foreach ($results['with-documents'] as $values)
                $results['with-documents'] = $values;
        }


        //Документы которые отсутствуют в таблице documents для платежей (не сформированы)
        if (in_array('without-documents', $params))
        {
            $query = "SELECT COUNT(*) AS count, SUM(amount) AS amount FROM payments WHERE NOT EXISTS (SELECT id FROM documents WHERE entity_id = payments.id) $between";

            $results['without-documents'] = $this->db->query($query);

            foreach ($results['without-documents'] as $values)
                $results['without-documents'] = $values;
        }

        if(!isset($results))
            return false;
        else
            return $results;
    }
}