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
        return $result;
    }

    public function selectQuery( $sql )
    {
        $result = $this -> connection -> query( $sql );
        return $this -> confirmResult( $result, "Database select query failed." );
    }

    public function insertQuery( $sql, $type, $params )
    {
        $statement = $this -> connection -> prepare( $sql );
        call_user_func_array( array( $statement, "bind_param" ), array_merge( array( $type ), $params ) );
        $result = $statement -> execute();
        return $this -> confirmResult( $result, "Database insert query failed." );
    }

    public function updateQuery( $sql )
    {
        $result = $this -> connection -> query( $sql );
        return $this -> confirmResult( $result, "Database update query failed." );
    }

    public function closeConnection()
    {
        if ( isset( $this -> connection ) )
        {
            $this -> connection -> close();
        }
    }
}









