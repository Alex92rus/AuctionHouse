<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";

SessionOperator::logout();
HelperOperator::redirectTo( "../index.php" );
