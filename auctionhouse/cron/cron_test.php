<?php


// Set up connection
$connection = new mysqli( "localhost", "root", "", "auctionsystem", "3306" );
if ( $connection -> connect_error )
{
    die( "Database connection failed: " . $connection -> connect_error );
}

// SQL for creating auction recommendation for a user
$userId = 1;
$confirmCode = rand( 100000, 100000000 );
$query = "UPDATE recommendations SET recommendations = '$confirmCode' WHERE userId = $userId";
$result = $connection -> query( $query );
if ( !$result )
{
    die( "Failure when updating recommendations for userId " . " $userId. "  . $connection -> connect_error );
}

// Close connection
$connection -> close();