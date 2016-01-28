<?php


class Database
{
    private $host = "localhost";
    private $user = "root";
    private $password = "root";
    private $database = "auction_house";
    private $port = 8889;
    private $connection;

    function __construct()
    {
        $this -> openConnection();
        if ( $this -> connection -> connect_error )
        {
            die( "Database connection failed: " . $this -> $connection -> connect_error );
        }
    }

    private function openConnection()
    {
        $this -> connection = new mysqli(
            $this -> host,
            $this -> user,
            $this -> password,
            $this -> database,
            $this -> port );
    }

    private function confirmResult( $result, $message )
    {
        if ( !$result )
        {
            die( $message );
        }
    }

    public function selectQuery( $sql )
    {
        $result = $this -> connection -> query( $sql );
        $this -> confirmResult( $result, "Database select query failed." );
        return $result;
    }

    public function insertQuery( $sql, $type, $params )
    {
        $statement = $this -> connection -> prepare( $sql );
        call_user_func_array( array( $statement, "bind_param" ), array_merge( array( $type ), $params ) );
        $result = $statement -> execute();
        $this -> confirmResult( $result, "Database insert query failed." );
        return $statement -> insert_id;
    }

    public function updateQuery( $sql )
    {
        $statement = $this -> connection -> query( $sql );
        $this -> confirmResult( $statement, "Database update query failed." );
        return $statement;
    }

    public function closeConnection()
    {
        if ( isset( $this -> connection ) )
        {
            $this -> connection -> close();
        }
    }
}









