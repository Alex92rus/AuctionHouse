<?php
require_once  "class.query_factory.php";
require_once  "helperfunctions.php";

updatePass();

function  updatePass() {
	$userDetails = [
	        "email"     => $_POST[ "email" ],
	        "password1" => $_POST[ "password1" ],
	     	  "password2" => $_POST[ "password2" ] ];
	$validData = checkPasswords($userDetails["password1"], $userDetails["password2"]);
	echo $userDetails["password1"];
	if (!$validData) {
		  redirectTo("changepassword.php?email=$userDetails[email]");
	} else {
		  QueryFactory::updatePassword($userDetails["email"], $userDetails["password1"]);
	}
}
 ?>