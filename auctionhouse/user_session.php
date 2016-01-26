<?php
require_once "helperfunctions.php";
require_once "class.session_factory.php";


if ( !SessionFactory::isLoggedIn() )
{
    redirectTo( "index.php" );
}