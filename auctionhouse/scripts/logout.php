<?php
require_once "helperfunctions.php";
require_once "../classes/class.session_operator.php";

SessionOperator::logout();
redirectTo( "../index.php" );
