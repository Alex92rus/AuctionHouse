<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/class.query_operator.php' );

/**
 * Created by PhpStorm.
 * User: mlloyd
 * Date: 20/02/16
 * Time: 11:26
 */
class QueryBuilder
{

    public $query;
    private $class;

    public function __construct($query, $class)
    {
        $this->query = $query;
        $this->class = $class;
        //var_dump($this->class);

    }

    public function get($array = null)
    {
        if ($array == null){
            $this->query = "SELECT * " . $this->query;

        }else{

            $fieldList = "";
            foreach ($array as $field){
                $field = "`" . $field . "`,";
                $fieldList .= $field;
            }
            $fieldList = substr($fieldList, 0, -1);

            $this->query = "SELECT " . $fieldList . $this->query;
        }
        $result = $this->executeQuery();
        $resultArray = array();
        while ($row = $result->fetch_assoc()){
            $resultArray[] = $row;
        }
        return $resultArray;

    }

    private function executeQuery()
    {
        return QueryOperator::findDbEntityList($this->query);
    }

    public function getAsClasses()
    {
        $this->query = "SELECT * " . $this->query;
        $result = $this->executeQuery();
        $resultArray = array();
        while ($row = $result->fetch_assoc()){
            $classInstance = new $this->class($row);
            $resultArray[] = $classInstance;
        }
        return $resultArray;

    }


}