<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.helper_operator.php";

if ( !SessionOperator::isLoggedIn() )
{
    HelperOperator::redirectTo( "../index.php" );
}