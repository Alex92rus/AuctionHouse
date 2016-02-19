<?php
require_once "classes/class.session_operator.php" ;
require_once "classes/class.query_operator.php" ;
require_once "config/config.php";

?>
<!DOCTYPE html>
<html>

<head>
    <title>AuctionHouse</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css">

    <!-- CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-select.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href="css/general.css" rel="stylesheet" type="text/css">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
</head>

<body>
    <!-- display feedback (if available) start -->
    <?php require_once "includes/feedback.php" ?>
    <!-- display feedback (if available) end -->


    <!-- header start -->
    <div class="navbar navbar-default navbar-static-top">
        <div class="container header_container valign">

            <!-- header logo start -->
            <?php include_once "includes/header.php";?>
            <!-- header logo end -->

            <!-- login start -->
            <div id="login" class="navbar-collapse collapse">
                <form class="navbar-form pull-right" method="post" action="scripts/login.php" role="form">
                    <label class="text-danger">&nbsp
                        <?php echo SessionOperator::getInputErrors( "login" ) ?>
                    </label><br>
                    <div class="input-group col-xs-5" style="padding: 1pt;">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" placeholder="Email" class="form-control" maxlength="30" name="loginEmail" id="loginEmail"
                            <?php echo 'value = "' . SessionOperator::getFormInput( "loginEmail" ) . '"'; ?> >
                    </div>
                    <div class="input-group col-xs-5" style="padding: 1pt;">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" placeholder="Password" class="form-control" maxlength="30" name="loginPassword" id="loginPassword"
                            <?php echo 'value = "' . SessionOperator::getFormInput( "loginPassword" ) . '"'; ?> >
                    </div>
                    <button type="submit" class="btn btn-success" name="signIn" id="signIn" >Sign In</button><br>
                </form>
                <a class="col-xs-offset-6 col-xs-5" href="views/forgot_password_view.php" id="forgotPassword">Forgot your password?</a>
            </div>
            <!-- login end -->

        </div>
    </div>
    <!-- header end -->

    <!-- main START -->
    <div class="container">

        <!-- registration start -->
        <form method="post" action="scripts/registration.php">
            <h2>
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                Sign Up
            </h2>
            <p class="p_instructions text-justify">
                Do you want to sell or buy auctions in real time? On our platform you can do both. All  you need to do is to register real
                quickly, then sign into your new account and you are ready to go.
            </p><hr>

            <div class="valign">
                <!-- registration instructions start -->
                <div class="col-xs-4" id="register_instructions">
                    <h2 class="col-xs-offset-2 col-xs-8 text-center">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" id="register_icon"></span><br>
                        Fill in each field and then click the sign up button
                    </h2>
                </div>
                <!-- registration instructions end -->

                <!-- account details start -->
                <div class="col-xs-8">
                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "username" ) ?>
                        </label>
                        <input type="text" name="username" class="form-control" id="username" maxlength="45" placeholder="Pick a username"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'username' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "email" ) ?>
                        </label>
                        <input type="text" name="email" class="form-control" id="email" maxlength="45" placeholder="Email"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'email' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "firstName" ) ?>
                        </label>
                        <input type="text" name="firstName" class="form-control" id="firstName" maxlength="45" placeholder="First Name"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'firstName' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "lastName" ) ?>
                        </label>
                        <input type="text" name="lastName" class="form-control" id="lastName" maxlength="45" placeholder="Last Name"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'lastName' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "address" ) ?>
                        </label>
                        <input type="text" name="address" class="form-control" id="address" maxlength="90" placeholder="Address"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'address' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "postcode" ) ?>
                        </label>
                        <input type="text" name="postcode" class="form-control" id="postcode" maxlength="45" placeholder="Postcode"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'postcode' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "city" ) ?>
                        </label>
                        <input type="text" name="city" class="form-control" id="city" maxlength="45" placeholder="City"
                            <?php echo 'value = "' . SessionOperator::getFormInput( "city" ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "country" ) ?>
                        </label><br>
                        <select name="country" class="selectpicker form-control" data-dropup-auto="false">
                            <option default>Country</option>
                            <?php
                                $country = SessionOperator::getFormInput( "country" );
                                $countries = QueryOperator::getCountriesList();
                                foreach( $countries as $value ) {
                                  $selected = "";
                                  if ($value == $country) {
                                    $selected = "selected";
                                  }
                            ?>
                            <option value="<?= $value ?>" title="<?= htmlspecialchars($value) ?>" <?= $selected ?> ><?= htmlspecialchars($value) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "password1" ) ?>
                        </label>
                        <input type="password" name="password1" class="form-control" id="password1" maxlength="23" placeholder="Create a password"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'password1' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-xs-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "password2" ) ?>
                        </label>
                        <input type="password" name="password2" class="form-control" id="password2" maxlength="23" placeholder="Repeat password"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'password2' ) . '"'; ?> >
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
    <?php include_once "includes/footer.php";?>
    <!-- footer end -->

</body>
</html>
