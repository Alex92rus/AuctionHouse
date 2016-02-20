<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../scripts/helper_functions.php";
require_once "../scripts/user_session.php";
require_once "../config/config.php";
require_once "../classes/class.db_country.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User Profile</title>

    <!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="../css/animate.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-select.css" rel="stylesheet" type="text/css">
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-notify.min.js"></script>
    <script src="../js/metisMenu.min.js"></script>
    <script src="../js/sb-admin-2.js"></script>
    <script src="../js/bootstrap-select.min.js"></script>
    <script src="../js/bootstrap.file-input.js"></script>
    <script src="../js/custom/search.js"></script>
    <script src="../js/custom/profile.js"></script>
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
                <div class="col-xs-12">
                    <h2 class="page-header"><i class="fa fa-user fa-fw"></i> My Profile</h2>
                </div>
            </div>
            <!-- profile header end -->

            <div class="row">
                <!-- profile image start -->
                <div class="col-xs-3">
                    <!-- image start -->
                    <br><img src="
                        <?php
                    if ( empty( $imageName = SessionOperator::getUser() -> getImage() ) )
                        echo "../uploads/profile_images/blank_profile.png";
                    else
                        echo "../uploads/profile_images/" . $imageName; ?>" class="img-responsive img-rounded">
                    <!-- image end -->

                    <!-- menu start -->
                    <form action="../scripts/update_profile.php" method="post" class="text-center" enctype="multipart/form-data">
                        <label class="text-danger col-xs-12 text-center" style="margin-top: 5px">&nbsp
                            <?php echo SessionOperator::getInputErrors( "upload" ) ?>
                        </label>
                        <?php if ( !empty( SessionOperator::getUser() -> getImage() ) ) : ?>
                            <a href="../scripts/delete_image.php" class="btn btn-danger col-xs-12" style="margin-bottom: 5px"><span class="glyphicon glyphicon-remove"></span> Delete Profile Picture</a>
                        <?php endif ?>
                        <input class="col-xs-12" type="file" data-filename-placement="inside" name="image" accept="image/png, image/jpeg">
                        <button type="submit" class="btn btn-primary col-xs-12" name="upload" style="margin-top: 5px"><span class="glyphicon glyphicon-upload"></span> Upload</button>
                    </form>
                    <!-- menu end -->

                </div>
                <!-- profile image end -->

                <!-- profile details start -->
                <form action="../scripts/update_profile.php" method="post" class="col-xs-9 form-horizontal" role="form">
                    <label class="col-xs-offset-2 text-danger">&nbsp
                        <?= SessionOperator::getInputErrors( "username" ) ?>
                    </label>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Username</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" name="username" maxlength="45"
                                   value= "<?= htmlspecialchars( SessionOperator::getUser() -> getUsername() ) ?>" >
                        </div>
                    </div>
                    <label class="col-xs-offset-2 text-danger">&nbsp
                    </label>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Email</label>
                        <div class="col-xs-10">
                            <input disabled="disabled" type="text" class="form-control" name="email" maxlength="45"
                                   value= "<?= htmlspecialchars( SessionOperator::getUser() -> getEmail() ) ?>" >
                        </div>
                    </div>
                    <label class="col-xs-offset-2 text-danger">&nbsp
                        <?= SessionOperator::getInputErrors( "firstName" ) ?>
                    </label>
                    <div class="form-group" >
                        <label class="col-xs-2 control-label">First Name</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" name="firstName" maxlength="45"
                                   value= "<?= htmlspecialchars( SessionOperator::getUser() -> getFirstName() ) ?>" >
                        </div>
                    </div>
                    <label class="col-xs-offset-2 text-danger">&nbsp
                        <?= SessionOperator::getInputErrors( "lastName" ) ?>
                    </label>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Last Name</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" name="lastName" maxlength="45"
                                   value= "<?= htmlspecialchars( SessionOperator::getUser() -> getLastName() ) ?>" >
                        </div>
                    </div>
                    <label class="col-xs-offset-2 text-danger">&nbsp
                        <?= SessionOperator::getInputErrors( "address" ) ?>
                    </label>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Address</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" name="address" maxlength="90"
                                   value= "<?= htmlspecialchars( SessionOperator::getUser() -> getAddress() ) ?>" >
                        </div>
                    </div>
                    <label class="col-xs-offset-2 text-danger">&nbsp
                        <?= SessionOperator::getInputErrors( "postcode" ) ?>
                    </label>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Postcode</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" name="postcode" maxlength="45"
                                   value= "<?= htmlspecialchars( SessionOperator::getUser() -> getPostcode() ) ?>" >
                        </div>
                    </div>
                    <label class="col-xs-offset-2 text-danger">&nbsp
                        <?= SessionOperator::getInputErrors( "city" ) ?>
                    </label>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">City</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" name="city" maxlength="45"
                                   value= "<?= htmlspecialchars( SessionOperator::getUser() -> getCity() ) ?>" >
                        </div>
                    </div>
                    <label class="col-xs-offset-2 text-danger">&nbsp
                        <?= SessionOperator::getInputErrors( "country" ) ?>
                    </label>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Country</label>
                        <div class="col-xs-10">
                            <select name="country" class="selectpicker form-control" data-dropup-auto="false">
                                <option default>Country</option>
                                <?php
                                    $country = SessionOperator::getUser() -> getCountry();
                                    $countries = DbCountry::withConditions()->getListOfColumn("countryName");
                                    print_r($countries);
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
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-2 col-xs-10">
                            <br>
                            <button type="submit" class="btn btn-lg btn-primary pull-right" name="save"><span class="glyphicon glyphicon-save"></span> Save Changes</button>
                        </div>
                    </div>
                </form>
                <!-- profile details end -->
            </div>

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