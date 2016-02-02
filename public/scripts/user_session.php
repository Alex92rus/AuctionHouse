<?php

if ( !SessionOperator::isLoggedIn() )
{
    redirectTo( "index.php" );
}