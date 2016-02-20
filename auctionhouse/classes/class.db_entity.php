<?php


abstract class DbEntity
{

    public $fieldValues;

    public function __construct($initValues = null)
    {

        $array= array_keys(static::$fields);
        $array[] = static::$primaryKeyName;
        $this->fieldValues = array_fill_keys($array, null);

        if($initValues != null){
            //constructing a new object with the initialised values
            foreach ($this->fieldValues as $key => $value){

                if(array_key_exists($key, $initValues)){

                    $this->fieldValues[$key] = $initValues[$key];
                }
            }

        }
    }

    public function getId()
    {
        if(isset($this->fieldValues[static::$primaryKeyName])){
            return $this->fieldValues[static::$primaryKeyName];
        }
        return null;
    }

    public function setField($fieldName, $fieldValue)
    {
        if(array_key_exists($fieldName, $this->fieldValues)){
            $this->fieldValues [$fieldName] = $fieldValue;
        }
    }

    public function setFields($fieldValues)
    {
        foreach($fieldValues as $key => $value){
            $this->setField($key, $value);
        }
    }

    public function getField($fieldName)
    {
        if(isset($this->fieldValues [$fieldName])){
            return $this->fieldValues [$fieldName];
        }
        return null;
    }

    public function toArray()
    {
        return $this->fieldValues;

    }

    public static function find($id)
    {
        $obj = QueryOperator::findDbEntity(static::$primaryKeyName, static::$tableName, $id);
        //var_dump($obj);
        if($obj != null){
            $classType = get_called_class();
            $class = new $classType();
            $class->setFields($obj);
            return $class;
        }
        return null;
    }

    public function save()
    {
        //the primary key column
        $pkColumn = static::$primaryKeyName;
        //and the actual id
        $id = $this->getField($pkColumn);

        //all information without the primary key and empty values
        $objToArray = array_filter($this->toArray());
        unset($objToArray[$pkColumn]);

        //the fields Names to update
        $fieldNames = array_keys($objToArray);

        //the values to insert
        $values = array_values($objToArray);

        //and their types joined into string for prepare statement e.g. "iisssiii"
        //$fieldTypes =implode("", array_values(static::$fields));
        $fieldTypes =$this->getTypesString($fieldNames);

        //var_dump($values);
        $success = QueryOperator::saveDbEntity($pkColumn, $id, static::$tableName,
            $fieldNames, $fieldTypes, $values);

        return $success;

    }

    public function create()
    {
        $pkColumn = static::$primaryKeyName;
        $objToArray = array_filter($this->toArray());
        unset($objToArray[$pkColumn]);
        $fieldNames = array_keys($objToArray);

        //the values to insert
        $values = array_values($objToArray);
        $refs = array();
        foreach ($values as $key => $value)
        {
            $refs[$key] = &$values[$key];
        }
        $fieldTypes =$this->getTypesString($fieldNames);
        $itemId = QueryOperator::createDbEntity(static::$tableName,
            $fieldNames, $fieldTypes, $refs);
        //var_dump($itemId);
        $this->setField($pkColumn, $itemId);

    }

    public function delete()
    {
        $pkColumn = static::$primaryKeyName;
        $tableName = static::$tableName;
        $result = QueryOperator::deleteDbEntity($pkColumn, $this->getId(), $tableName);
        return $result;



    }

    private function getTypesString($fieldNames)
    {
        $types = "";

        foreach($fieldNames as $key){
            $types .= static::$fields[$key];
        }
        return $types;

    }
}