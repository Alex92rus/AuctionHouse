<?php


// Redirect to a page
function redirectTo( $page )
{
    header( "Location: " . $page );
    exit();
}