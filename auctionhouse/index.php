<?php require "class.session_factory.php" ?>
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

            <!-- header logo start -->
            <div class="ol-xs-7 navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#login">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="index.php">
                    <img src="images/logo.png" alt="logo">
                </a>
            </div>
            <!-- header logo end -->

            <!-- login start -->
            <div id="login" class="col-xs-5 navbar-collapse collapse">
                <form class="navbar-form" method="" action="" role="form">
                    <div class="form-group">
                        <input type="text" placeholder="Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Sign In</button>
                </form>
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
                            <?php echo SessionFactory::getRegistrationErrors( "username" ) ?>
                        </label>
                        <input type="text" name="username" class="form-control" id="username" maxlength="30" placeholder="Pick a username"
                            <?php echo 'value = "' . SessionFactory::getInput( 'username' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getRegistrationErrors( "email" ) ?>
                        </label>
                        <input type="text" name="email" class="form-control" id="email" maxlength="30" placeholder="Email"
                            <?php echo 'value = "' . SessionFactory::getInput( 'email' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getRegistrationErrors( "firstName" ) ?>
                        </label>
                        <input type="text" name="firstName" class="form-control" id="firstName" maxlength="30" placeholder="First Name"
                            <?php echo 'value = "' . SessionFactory::getInput( 'firstName' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getRegistrationErrors( "lastName" ) ?>
                        </label>
                        <input type="text" name="lastName" class="form-control" id="lastName" maxlength="30" placeholder="Last Name"
                            <?php echo 'value = "' . SessionFactory::getInput( 'lastName' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getRegistrationErrors( "address" ) ?>
                        </label>
                        <input type="text" name="address" class="form-control" id="address" maxlength="50" placeholder="Address"
                            <?php echo 'value = "' . SessionFactory::getInput( 'address' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getRegistrationErrors( "postcode" ) ?>
                        </label>
                        <input type="text" name="postcode" class="form-control" id="postcode" maxlength="30" placeholder="Postcode"
                            <?php echo 'value = "' . SessionFactory::getInput( 'postcode' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getRegistrationErrors( "city" ) ?>
                        </label>
                        <input type="text" name="city" class="form-control" id="city" maxlength="30" placeholder="City"
                            <?php echo 'value = "' . SessionFactory::getInput( "city" ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getRegistrationErrors( "country" ) ?>
                        </label><br>
                        <input type="text" name="country" class="form-control" id="country" maxlength="30" placeholder="Country"
                            <?php echo 'value = "' . SessionFactory::getInput( 'country' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getRegistrationErrors( "password1" ) ?>
                        </label>
                        <input type="password" name="password1" class="form-control" id="password1" maxlength="30" placeholder="Create a password"
                            <?php echo 'value = "' . SessionFactory::getInput( 'password1' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionFactory::getRegistrationErrors( "password2" ) ?>
                        </label>
                        <input type="password" name="password2" class="form-control" id="password2" maxlength="30" placeholder="Repeat password"
                            <?php echo 'value = "' . SessionFactory::getInput( 'password2' ) . '"'; ?> >
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
                <button type="submit" name="signup" id="signup" class="btn btn-success btn-lg pull-right">Sign up for AuctionHouse</button>
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
