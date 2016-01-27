<?php
require_once "helperfunctions.php";
require_once "class.session_factory.php";
if ( !isset( $_GET[ "email" ] ) ) {
    redirectTo("index.php");
}
$email = $_GET[ "email" ];
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
       
    </div>
</div>
<!-- login end -->
        <!-- main START -->
            <div class="container">

        <!-- registration start -->
                    <form method="post" action="updatepassword.php">
                            <h2>Change your Password</h2>
                    <p class="p_registration text-justify">
                            Give and confirm your new Password
                    </p><hr>
                    <p class="p_registration text-justify">
                            What is yo?
                    </p><hr>
                    <!-- display registration status if available -->
                    <?php list( $title, $info ) = SessionFactory::getRegistrationStatus(); if ( $title != null && $info != null ) : ?>
                        <script>
                            $.notify({
                                icon: "glyphicon glyphicon-ok",
                                title: <?php echo json_encode( $title ); ?>,
                                message: <?php echo json_encode( $info ); ?>
                            },{
                                type: "success"
                            });
                        </script>
                    <?php endif ?>

                    <div class="valign">
                        <!-- registration instructions start -->
                        <div class="col-xs-4" id="register_instructions">
                            <h2 class="col-xs-offset-2 col-xs-8 text-center">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true" id="register_icon"></span><br>
                                Fill in your email and then click the  'Recover Password' button
                            </h2>
                        </div>
                        <!-- registration instructions end -->

                        <!-- account details start -->
                   <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "password1" ) ?>
                        </label>
                        <input type="password" name="password1" class="form-control" id="password1" maxlength="30" placeholder="Create a password"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'password1' ) . '"'; ?> >
                    </div>
                        <input type="hidden" name="email"  <?php echo "value = $email "; ?>
                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "password2" ) ?>
                        </label>
                        <input type="password" name="password2" class="form-control" id="password2" maxlength="30" placeholder="Repeat password"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'password2' ) . '"'; ?> >
                    </div>
                        <!-- account details end -->
                    </div><hr>

                    <div class="col-xs-12">
                        <p class="pull-right">
                            By clicking this 'Change Password' button, you  will change your account password</a>
                        </p>
                    </div>

                    <div class="form-group col-xs-12" id="sign_up_button">
                        <button type="submit" name="signUp" id="signUp" class="btn btn-success btn-lg pull-right">Change Password</button>
                    </div>
        </form>
        <!-- registration end -->
    </div>
    <!-- main end -->
    
</body>
</html>