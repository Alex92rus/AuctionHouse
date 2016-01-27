<?php require "class.session_handler.php" ?>
<!DOCTYPE html>
<html>

<head>
    <title>AuctionHouse</title>
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
    <!-- header start -->
    <div class="navbar navbar-default navbar-static-top">
        <div class="container header_container valign">

            <!-- header logo -->
           <?php include_once("header.php");?>

            <!-- login start -->
            <div id="login" class="col-xs-5 navbar-collapse collapse">
                <form class="navbar-form"  method="post" action="login.php" role="form">
                    <label class="text-danger">&nbsp
                        <?php echo SessionFactory::getInputErrors( "login" ) ?>
                    </label><br>
                    <div class="form-group col-xs-5" style="padding: 3pt;">
                        <input type="text" placeholder="Email" class="form-control" maxlength="30" name="loginEmail" id="loginEmail"
                            <?php echo 'value = "' . SessionFactory::getFormInput( "loginEmail" ) . '"'; ?> >
                    </div>
                    <div class="form-group col-xs-5" style="padding: 3pt;">
                        <input type="password" placeholder="Password" class="form-control" maxlength="30" name="loginPassword" id="loginPassword"
                            <?php echo 'value = "' . SessionFactory::getFormInput( "loginPassword" ) . '"'; ?> >
                    </div>
                    <div class="form-group col-xs-2" style="padding: 3pt;">
                        <button type="submit" class="btn btn-success" name="signIn" id="signIn" >Sign In</button><br>
                    </div>
                </form>
                <a class="col-xs-offset-5 col-xs-5" href="forgotpassword.php" id="forgotPassword">Forgot your password?</a>
            </div>
            <!-- login end -->

        </div>
    </div>
    <!-- header end -->

    <!-- main START -->
    <div class="container">

        <!-- registration start -->
        <form method="post" action="registration.php">
            <h2>Sign Up</h2>
            <p class="p_registration text-justify">
                Do you want to sell or buy auctions in real time? On our platform you can do both. All  you need to do is to register real
                quickly, then sign into your new account and you are ready to go.
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
                        Fill in each field and then click the sign up button
                    </h2>
                </div>
                <!-- registration instructions end -->

                <!-- account details start -->
                <div class="col-xs-8">
                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "username" ) ?>
                        </label>
                        <input type="text" name="username" class="form-control" id="username" maxlength="30" placeholder="Pick a username"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'username' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "email" ) ?>
                        </label>
                        <input type="text" name="email" class="form-control" id="email" maxlength="30" placeholder="Email"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'email' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "firstName" ) ?>
                        </label>
                        <input type="text" name="firstName" class="form-control" id="firstName" maxlength="30" placeholder="First Name"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'firstName' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "lastName" ) ?>
                        </label>
                        <input type="text" name="lastName" class="form-control" id="lastName" maxlength="30" placeholder="Last Name"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'lastName' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "address" ) ?>
                        </label>
                        <input type="text" name="address" class="form-control" id="address" maxlength="50" placeholder="Address"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'address' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "postcode" ) ?>
                        </label>
                        <input type="text" name="postcode" class="form-control" id="postcode" maxlength="30" placeholder="Postcode"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'postcode' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "city" ) ?>
                        </label>
                        <input type="text" name="city" class="form-control" id="city" maxlength="30" placeholder="City"
                            <?php echo 'value = "' . SessionFactory::getFormInput( "city" ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "country" ) ?>
                        </label><br>
                        <input type="text" name="country" class="form-control" id="country" maxlength="30" placeholder="Country"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'country' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "password1" ) ?>
                        </label>
                        <input type="password" name="password1" class="form-control" id="password1" maxlength="30" placeholder="Create a password"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'password1' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getInputErrors( "password2" ) ?>
                        </label>
                        <input type="password" name="password2" class="form-control" id="password2" maxlength="30" placeholder="Repeat password"
                            <?php echo 'value = "' . SessionFactory::getFormInput( 'password2' ) . '"'; ?> >
                    </div>
                </div>
                <!-- account details end -->
            </div><hr>

            <div class="col-xs-12">
                <p class="pull-right">
                    By clicking this 'Sign up for AuctionHouse' button, you agree to our <a href="">terms of service</a> and <a href="">privacy policy</a>
                </p>
            </div>

            <div class="form-group col-xs-12" id="sign_up_button">
                <button type="submit" name="signUp" id="signUp" class="btn btn-success btn-lg pull-right">Sign up for AuctionHouse</button>
            </div>
        </form>
        <!-- registration end -->
    </div>
    <!-- main end -->


    <!-- footer start -->
    <div class="footer navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-text pull-left">
                <p>Copyright &copy; <?php echo date( "Y", time() ); ?> AuctionHouse</p>
            </div>
            <div class="navbar-text pull-right">
                <p><a href="#">About</a> |  <a href="#">Contact</a> |  <a href="#">Privacy & Cookies</a> |  <a href="#">Developers</a></p>
            </div>
        </div>
    </div>
    <!-- footer end -->

</body>

</html>
