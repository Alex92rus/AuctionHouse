<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/config/config.php' );


class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    private $port = DB_PORT;
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
            echo mysqli_error( $this->connection );
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
        $result = $this -> connection -> query( $sql );
        $this -> confirmResult( $result, "Database update query failed." );
    }

    public function closeConnection()
    {
        if ( isset( $this -> connection ) )
        {
            $this -> connection -> close();
        }
    }
}









