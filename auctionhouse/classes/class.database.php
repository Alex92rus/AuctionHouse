<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/config/config.php' );


class Database
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;
    private $connection;


    public function __construct()
    {
        $this -> host = DB_HOST;
        $this -> user = DB_USER;
        $this -> password = DB_PASSWORD;
        $this -> database = DB_NAME;
        $this -> port = DB_PORT;
    }


    public function issueQuery( $sql, $insertType = null, $params = null )
    {
        $result = null;

        // Determine query type
        $queryType = explode( " ", trim( $sql ) );
        $queryType = strtoupper( $queryType[ 0 ] );

        // Open database connection
        $this -> openConnection();

        // Perform query
        switch( $queryType )
        {
            case "SELECT":
                $result = $this -> selectQuery( $sql );
                break;
            case "INSERT":
                $result = $this -> insertQuery( $sql, $insertType, $params );
                break;
            case "UPDATE":
                if ( $insertType == null && $params === null )
                    $this->otherQuery( $sql );
                else
                    $result = $this->updateQueryAdvanced( $sql, $insertType, $params );
                break;
            case "DELETE":
                $this -> otherQuery( $sql );
                break;
            default:
                $this -> otherQuery( $sql );
                break;
        }

        // Close database connection
        $this -> closeConnection();

        // Return result ( null -> no result, otherwise -> result )
        return $result;
    }


    private function openConnection()
    {
        $this -> connection = new mysqli(
            $this -> host,
            $this -> user,
            $this -> password,
            $this -> database,
            $this -> port );

        if ( $this -> connection -> connect_error )
        {
            die( "Database connection failed: " . $this -> $connection -> connect_error );
        }
    }


    private function closeConnection()
    {
        if ( isset( $this -> connection ) )
        {
            $this -> connection -> close();
        }
    }


    private function confirmResult( $result, $message )
    {
        if ( !$result )
        {
            echo mysqli_error( $this->connection );
            die( $message );
        }
    }


    private function selectQuery( $sql )
    {
        $result = $this -> connection -> query( $sql );
        $this -> confirmResult( $result, "Database select query failed." );
        return $result;
    }


    private function insertQuery( $sql, $type, $params )
    {
        $statement = $this -> connection -> prepare( $sql );
        $refs = array();
        foreach ( $params as $key => $value )
        {
            $refs[ $key ] = &$params[ $key ];
        }
        call_user_func_array( array( $statement, "bind_param" ), array_merge( array( $type ), $refs ) );
        $result = $statement -> execute();
        $this -> confirmResult( $result, "Database insert query failed." );
        return $statement -> insert_id;
    }


    private function otherQuery( $sql )
    {
        $result = $this -> connection -> query( $sql );
        $this -> confirmResult( $result, "Database update query failed." );
    }


    private function updateQueryAdvanced( $sql,$type, $params)
    {
        $statement = $this -> connection -> prepare( $sql );
        $refs = array();
        foreach ($params as $key => $value)
        {
            $refs[$key] = &$params[$key];
        }
        call_user_func_array( array( $statement, "bind_param" ), array_merge( array( $type ),$refs ));
        return $statement -> execute();
    }
}










