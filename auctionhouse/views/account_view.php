<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../scripts/user_session.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Account Settings</title>

    <!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="../css/animate.css" rel="stylesheet" type="text/css">
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-notify.min.js"></script>
    <script src="../js/metisMenu.min.js"></script>
    <script src="../js/sb-admin-2.js"></script>
    <script src="../js/bootstrap.file-input.js"></script>
    <script src="../js/custom/search.js"></script>
</head>

<body>
    <!-- display feedback (if available) start -->
    <?php require_once "../includes/feedback.php" ?>
    <!-- display feedback (if available) end -->


    <div id="wrapper">

        <!-- navigation start -->
        <?php include_once "../includes/navigation.php" ?>
        <!-- navigation end -->


        <!-- main start -->
        <div id="page-wrapper">
            <!-- profile header start -->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><i class="fa fa-cog fa-fw"></i> Account Settings</h3>
                </div>
            </div>
            <!-- profile header end -->

            <!-- change password start -->
            <form action="../scripts/password.php" method="post" class="form-horizontal col-xs-7" role="form" >

                <label class="col-xs-offset-3 text-danger">&nbsp
                    <?= SessionOperator::getInputErrors( "currentPassword" ) ?>
                </label>
                <div class="form-group">
                    <label class="col-xs-3 control-label">Current password</label>
                    <div class="col-xs-9">
                        <input type="password" class="form-control" name="currentPassword" maxlength="23"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'currentPassword' ) . '"'; ?> >
                    </div>
                </div>

                <label class="col-xs-offset-3 text-danger">&nbsp
                    <?= SessionOperator::getInputErrors( "password1" ) ?>
                </label>
                <div class="form-group">
                    <label class="col-xs-3 control-label">New Password</label>
                    <div class="col-xs-9">
                        <input type="password" class="form-control" name="password1" maxlength="23"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'password1' ) . '"'; ?> >
                    </div>
                </div>

                <label class="col-xs-offset-3 text-danger">&nbsp
                    <?= SessionOperator::getInputErrors( "password2" ) ?>
                </label>
                <div class="form-group">
                    <label class="col-xs-3 control-label">Repeat new password</label>
                    <div class="col-xs-9">
                        <input type="password" class="form-control" name="password2" maxlength="23"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'password2' ) . '"'; ?> >
                    </div>
                </div>

                <div class="form-group">
                    <div class="pull-right">
                        <br>
                        <button type="submit" class="btn btn-primary pull-right" name="changePasswordSignedIn" id="changePasswordSignedIn">
                            <span class="glyphicon glyphicon-save"></span> Change Password
                        </button>
                    </div>
                </div>

            </form>
            <!-- change password end -->

            <!-- footer start -->
            <div class="footer">
                <div class="container">
                </div>
            </div>
            <!-- footer end -->
        </div>
        <!-- main end -->


    </div>
    <!-- /#wrapper -->

</body>

</html>