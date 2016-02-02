<?php
require_once "classes/class.session_operator.php";
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
    <link href="css/general.css" rel="stylesheet" type="text/css">
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
    <?php list( $title, $info ) = SessionOperator::getFeedback(); if ( $title != null && $info != null ) : ?>
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
    <!-- display feedback (if available) end -->

    <!-- header start -->
    <div class="navbar navbar-default navbar-static-top">
        <div class="container header_container">

            <!-- header logo start -->
           <?php include_once "includes/header.php";?>
            <!-- header logo end -->

        </div>
    </div>
    <!-- header end -->

    <!-- main START -->
    <div class="container">

        <!-- instructions start -->
        <div class="col-xs-12">
            <h2>
                <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                Forgot your password
            </h2>
            <p class="p_instructions">
                If you forgot your password for your account, enter your email and click the 'Reset Password' button. You will then
                receive an email to change your password.
            </p>
        </div>
        <!-- instructions end -->

        <!-- forgot password start -->
        <form method="post" action="scripts/resetpassword.php">
            <div class="col-xs-4 form-group-lg">
                <label class="text-danger">&nbsp
                    <?php echo SessionOperator::getInputErrors( "email" ); ?>
                </label>
                <input type="text" name="email" class="form-control" id="email" maxlength="30" placeholder="Enter your email here"
                    <?php echo 'value = "' . SessionOperator::getFormInput( "email" ) . '"'; ?> >
            </div>
            <div class="col-xs-8">
                <label>&nbsp</label><br>
                <button type="submit" name="signUp" id="signUp" class="btn btn-success btn-lg">Reset Password</button>
            </div>
        </form>
        <!-- forgot password end -->

    </div>
    <!-- main end -->

    <!-- footer start -->
    <?php include_once "includes/footer.php";?>
    <!-- footer end -->

</body>
</html>