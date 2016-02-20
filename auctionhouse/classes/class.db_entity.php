<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/class.query_builder.php' );


abstract class DbEntity
{
    public $fieldValues;
    public $queryBuilder;
    private static $database;

    private static function getDatabaseInstance()
    {
        if ( is_null( self::$database ) )
        {
            self::$database = new Database();
        }
    }


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


    public static function withConditions($whereArgs = null)
    {
        $query = " FROM " . static::$tableName . " " . $whereArgs;
        //var_dump(get_called_class());
        return new QueryBuilder($query, get_called_class());

    }


    public static function find($id)
    {
        $obj = self::findDbEntity(static::$primaryKeyName, static::$tableName, $id);
        //var_dump($obj);
        if($obj != null){
            $classType = get_called_class();
            $class = new $classType();
            $class->setFields($obj);
            return $class;
        }
        return null;
    }


    public static function listIds()
    {
        $array = self::withConditions(null)->get(array(static::$primaryKeyName));
        $values = array();
        foreach ($array as $value ){
            $values[] = $value[static::$primaryKeyName];
        }
        return $values;
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
        $success = self::updateDbEntity($pkColumn, $id, static::$tableName,
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
        $itemId = self::insertDbEntity(static::$tableName,
            $fieldNames, $fieldTypes, $refs);
        //var_dump($itemId);
        $this->setField($pkColumn, $itemId);

    }


    public function delete()
    {
        $pkColumn = static::$primaryKeyName;
        $tableName = static::$tableName;
        $result = self::deleteDbEntity($pkColumn, $this->getId(), $tableName);
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


    /**
     * @param $primaryKeyName
     * @param $tableName
     * @param $id
     * @return mixed
     *
     * returns the row from the database.
     *
     * e.g. find <auction> item with id 1:
     * findDbEntity("auctionId", "auctions", 1)
     *
     * This function is called from a child instance of DbEntity class where $primaryKeyName and
     * $tableName are inferred
     */
    private static function findDbEntity($primaryKeyName, $tableName, $id)
    {
        self::getDatabaseInstance();
        $query = "SELECT * from `" . $tableName . "` WHERE "
            . $primaryKeyName . " = " .$id;
        $result = self::$database->issueQuery($query);
        if($result != null) {
            $result = $result->fetch_assoc();
        }
        return $result;


    }


    public static function findDbEntityList($query){
        self::getDatabaseInstance();
        $result = self::$database->issueQuery($query);
        return $result;
    }
    /**
     * @param $primaryKeyName
     * @param $id
     * @param $tableName
     * @param $fieldNames
     * @param $fieldTypes
     * @param $fieldValues
     * @return mixed
     *
     * saves the object instance to database.
     * This method is called by a child instance of DbEntity class through the save() method e.g. $item->save()
     * This method is not intended to be called manually.
     * returns true or false depending on success or failure
     */
    private static function updateDbEntity($primaryKeyName, $id, $tableName, $fieldNames, $fieldTypes, $fieldValues)
    {
        self::getDatabaseInstance();
        $statement = "UPDATE `" . $tableName . "` SET ";
        $prepare = "";
        foreach ($fieldNames as $field){
            $prepare .= "`".$field. "`=?,";
        }
        //remove last 2 characters
        $prepare = substr($prepare, 0, -1);
        $statement .= $prepare;
        $statement .= " WHERE `" . $primaryKeyName . "` = " .$id;
        $result= self::$database->issueQuery($statement, $fieldTypes, $fieldValues);

        return $result;

    }


    private static function insertDbEntity($tableName, $fieldNames, $fieldTypes, $fieldValues)
    {
        self::getDatabaseInstance();
        $statement = "INSERT INTO `" . $tableName  . "` (";
        foreach ($fieldNames as $name){
            $statement .= "`". $name . "`," ;
        }
        $statement = substr($statement, 0, -1) . ")";
        $statement .= " VALUES (";
        for ($i= 0 ; $i < count($fieldNames) ; $i++){
            $statement .= "?,";
        }
        $statement = substr($statement, 0, -1) . ")";
        return self::$database->issueQuery($statement, $fieldTypes, $fieldValues);
    }


    private static function deleteDbEntity($primaryKeyName, $id, $tableName)
    {
        self::getDatabaseInstance();
        $statement = "DELETE FROM`" . $tableName . "` WHERE `". $primaryKeyName
            ."`=" .$id;
        var_dump($statement);

        return self::$database->issueQuery($statement);
    }
}