<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_entity.php' );

class QueryBuilder
{
    private $query;
    private $class;


    public function __construct($query, $class)
    {
        $this->query = $query;
        $this->class = $class;
        //var_dump($this->class);

    }


    private function executeQuery()
    {
        return DbEntity::findDbEntityList($this->query);
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

    public function getListOfColumn($fieldType)
    {
        $result = $this->get(array($fieldType));
        $values = array();
        foreach ($result as $value ){
            $values[] = $value[$fieldType];
        }
        return $values;
    }

    public function count()
    {
        $this->query = "SELECT COUNT(*) AS num_rows " . $this->query;
        var_dump($this->query);
        die();
        return $this->executeQuery()->fetch_assoc()["num_rows"];

    }

    public function exists()
    {
        return $this->count() > 0 ? true:false;
    }

    public function first()
    {
        $this->query = "SELECT * " . $this->query;
        $result = $this->executeQuery();
        $classInstance = null;
        if ($row = $result->fetch_assoc()){
            $classInstance = new $this->class($row);
        }
        return $classInstance;
    }
}