<?php
require_once "classes/class.session_operator.php";
require_once "scripts/helperfunctions.php";
require_once "scripts/user_session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/general.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
</head>
<body>
<div class="navbar navbar-default navbar-static-top">
    <div class="container header_container valign">

        <!-- header logo start -->
       <?php include_once("includes/header.php");?>
        <!-- header logo end -->

    </div>
</div>
    <!-- main start -->
    <div class="container">
        <p>You are logged in</p>
    </div>
    <!-- main end -->

    <!-- footer start -->
    <?php include_once( "includes/footer.php" );?>
    <!-- footer end -->
</body>
</html>