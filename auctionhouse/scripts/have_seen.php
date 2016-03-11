<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";

// Mark notification as seen
if ( isset( $_GET[ "notificationId" ] ) )
{
    $id = $_GET[ "notificationId" ];
    QueryOperator::haveSeen( SessionOperator::getUser() -> getUserId(), $id );
}