<?php
require_once "scripts/helper_functions.php";
require_once "classes/class.session_operator.php";

if ( !isset( $_GET[ "email" ] ) )
{
    redirectTo( "index.php" );
}

SessionOperator::setEmail( $_GET[ "email" ] );

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">

    <!-- JS -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>

</head>
<body>
    <!-- display feedback (if available) start -->
    <?php
    if ( !is_null( $feedback = SessionOperator::getFeedback() ) ) : ?>
        <script>
            $.notify({
                icon: "glyphicon glyphicon-ok",
                title: <?php echo json_encode( $feedback[ 0 ] ); ?>,
                message: <?php echo json_encode( $feedback[ 1 ] ); ?>
            },{
                type: <?php echo json_encode( $feedback[ 2 ] ); ?>
            });
        </script>
    <?php endif ?>
    <!-- display feedback (if available) end -->

    <!-- header start -->
    <div class="navbar navbar-default navbar-static-top">
        <div class="container header_container">

            <!-- header logo start -->
           <?php include_once("includes/header.php");?>
            <!-- header logo end -->

        </div>
    </div>
    <!-- header end -->

    <!-- main START -->
    <div class="container">

        <!-- instructions start -->
        <div class="col-xs-12">
            <h2>
                <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                Change your password
            </h2>
            <p class="p_instructions">
                If you want to recover your password, enter your new password twice and then click the 'Change Password' button.
            </p>
        </div>
        <!-- instructions end -->

        <!-- change password start -->
        <form method="post" action="scripts/update_password.php">
            <div class="col-xs-4 form-group-lg">
                <label class="text-danger">&nbsp
                    <?php echo SessionOperator::getInputErrors( "password1" ) ?>
                </label>
                <input type="password" name="password1" class="form-control" id="password1" maxlength="23" placeholder="Create a password"
                    <?php echo 'value = "' . SessionOperator::getFormInput( 'password1' ) . '"'; ?> >
            </div>
            <div class="col-xs-4 form-group-lg ">
                <label class="text-danger">&nbsp
                    <?php echo SessionOperator::getInputErrors( "password2" ) ?>
                </label>
                <input type="password" name="password2" class="form-control" id="password2" maxlength="23" placeholder="Repeat password"
                    <?php echo 'value = "' . SessionOperator::getFormInput( 'password2' ) . '"'; ?> >
            </div>
            <div class="col-xs-4">
                <label>&nbsp</label><br>
                <button type="submit" name="changePassword" id="changePassword" class="btn btn-success btn-lg">Change Password</button>
            </div>
        </form>
        <!-- change password end -->

    </div>
    <!-- main end -->

    <!-- footer start -->
    <?php include_once( "includes/footer.php" );?>
    <!-- footer end -->

</body>
</html>