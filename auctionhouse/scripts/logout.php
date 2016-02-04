<?php
require_once "helper_functions.php";
require_once "../classes/class.session_operator.php";

SessionOperator::logout();
redirectTo( "../index.php" );
