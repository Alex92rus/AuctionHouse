<?php
require_once "user_session.php";
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

        <!-- header logo -->
       <?php include_once("header.php");?>

        <!-- logout start -->
        <div id="login" class="col-xs-5 navbar-collapse collapse">
            <form class="navbar-form"  method="post" action="login.php" role="form">
                <div class="form-group col-xs-2" style="padding: 3pt;">
                    <button type="submit" class="btn btn-success" name="signIn" id="signIn" >LogOut</button><br>
                </div>
            </form>
            <a class="col-xs-offset-5 col-xs-5" href="#" id="forgotPassword">Forgot your password?</a>
        </div>
        <!-- logout finish -->
    </div>
</div>
            <!-- login end -->
    <p>You are logged in</p>
</body>
</html>