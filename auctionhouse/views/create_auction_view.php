<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../scripts/user_session.php";
require_once "../classes/class.db_category.php";
require_once "../classes/class.db_condition.php";
require_once "../config/env_variables.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Create New Auction</title>

    <!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="../css/animate.css" rel="stylesheet" type="text/css">
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/bootstrap-select.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
    <link href="../css/main.css" rel="stylesheet">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-notify.min.js"></script>
    <script src="../js/metisMenu.min.js"></script>
    <script src="../js/sb-admin-2.js"></script>
    <script src="../js/custom/search.js"></script>
    <script src="../js/bootstrap.file-input.js"></script>
    <script src="../js/bootstrap-select.min.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/custom/search.js"></script>
    <script src="../js/custom/create_auction.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- navigation start -->
        <?php include_once "../includes/navigation.php" ?>
        <!-- navigation end -->


        <!-- main start -->
        <div id="page-wrapper">

            <!-- profile header start -->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Create New Auction</h3>
                </div>
            </div>
            <!-- profile header end -->

            <!-- display item related input errors (if available) start -->
            <?php if ( ( $errors =  SessionOperator::getAllErrors() ) != null ) :  ?>
                <div class="alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Input error!</strong><br>
                    <ul>
                        <?php
                            foreach ( $errors as $key => $message )
                            {
                                echo "<li>" . $message . "</li>";
                            }
                        ?>
                    </ul>
                </div>
            <?php endif ?>
            <!-- display item related input errors (if available) end -->


            <!-- auction setup start -->
            <form action="../scripts/create_auction.php" method="post" class="row" role="form"  enctype="multipart/form-data">

                <!-- item details start -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Item details</strong>
                    </div>

                    <div class="panel-body row">

                        <!-- left column start -->
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Create a new item or use one of your existing ones</label>
                                <select class="selectpicker form-control" name="item">
                                    <option default>New Item</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="itemName" maxlength="45"
                                    <?php echo 'value = "' . SessionOperator::getFormInput( "itemName" ) . '"'; ?> >
                            </div>

                            <div class="form-group">
                                <label>Brand</label>
                                <input type="text" class="form-control" name="itemBrand" maxlength="45"
                                    <?php echo 'value = "' . SessionOperator::getFormInput( "itemBrand" ) . '"'; ?> >
                            </div>

                            <div class="form-group">
                                <label>Category</label>
                                <select class="selectpicker form-control" name="itemCategory"  data-dropup-auto="false">
                                    <option default>Select</option>
                                    <?php
                                    $itemCategory = SessionOperator::getFormInput( "itemCategory" );
                                    $itemCategories = QueryOperator::getCategoriesList();
                                    foreach( $itemCategories as $value ) {
                                        $value = htmlspecialchars($value);
                                        $selected = "";
                                        if ($value == $itemCategory) {
                                            $selected = "selected";
                                        }
                                        ?>
                                        <option value="<?= $value ?>" title="<?= $value ?>" <?= $selected ?> ><?= $value ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Condition</label>
                                <select class="selectpicker form-control" name="itemCondition"  data-dropup-auto="false">
                                    <option default>Select</option>
                                    <?php
                                    $itemCondition = SessionOperator::getFormInput( "itemCondition" );
                                    $itemConditions = QueryOperator::getConditionsList();

                                    foreach( $itemConditions as $value ) {
                                        $value = htmlspecialchars($value);
                                        $selected = "";
                                        if ($value == $itemCondition) {
                                            $selected = "selected";
                                        }
                                        ?>
                                        <option value="<?= $value ?>" title="<?= $value ?>" <?= $selected ?> ><?= $value ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Email me an auction report: </label>
                                <select class="selectpicker form-control" name="reportFrequency"  data-dropup-auto="false">

                                    <?php
                                    $frequency= SessionOperator::getFormInput( "reportFrequency" );
                                    $frequencies = $_env_reportFrequencies ;

                                    foreach( $frequencies as $key => $value ) {
                                        $name = htmlspecialchars($key);
                                        $selected = "";
                                        if ($frequency === $value) {

                                            $selected = "selected";
                                        }
                                        ?>
                                        <option value="<?= $value ?>" title="<?= $name ?>" <?= $selected ?> ><?= $name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- left column end -->

                            <!-- right column start -->
                            <div class="form-group">
                                <label>Image</label>
                                <div class="input-group image-preview">
                                    <input type="text" class="form-control image-preview-filename" disabled="disabled" >
                                    <span class="input-group-btn">
                                        <!-- image-preview-clear button -->
                                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                            <span class="glyphicon glyphicon-remove"></span> Clear
                                        </button>
                                        <!-- image-preview-input -->
                                        <div class="btn btn-default image-preview-input">
                                            <span class="glyphicon glyphicon-folder-open"></span>
                                            <span class="image-preview-input-title">Browse</span>
                                            <input type="file" accept="image/png, image/jpeg" name="image" >
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <!-- right column end -->

                        </div>

                        <div class="col-xs-7">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control textarea" id="itemDescription" rows="24" name="itemDescription" placeholder="Enter a description" maxlength="2000"><?php echo SessionOperator::getFormInput( "itemDescription" ) ?></textarea>
                                <h6 class="pull-right" id="counter"></h6>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- item details end -->


                <!-- auction details start -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Auction details</strong>
                    </div>

                    <div class="panel-body row">

                        <div class="col-xs-2">
                            <label>Item quantity</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quantity">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </button>
                                    </span>
                                    <input type="text" name="quantity" class="form-control input-number"
                                        <?php
                                        $quantity = SessionOperator::getFormInput( "quantity" );
                                        if ( empty( $quantity ) )
                                        {
                                            echo "value = 1";
                                        }
                                        else
                                        {
                                            echo 'value = "' . $quantity . '"';
                                        }
                                        ?> >
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quantity">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-2">
                            <label>Start price</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">£</span>
                                    <input type="text" class="form-control" name="startPrice" placeholder="10.00" maxlength="10"
                                        <?php echo 'value = "' . SessionOperator::getFormInput( "startPrice" ) . '"'; ?> >
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-2">
                            <label>Reserve price (opt)</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">£</span>
                                    <input type="text" class="form-control" name="reservePrice" placeholder="100.00" maxlength="10"
                                        <?php echo 'value = "' . SessionOperator::getFormInput( "reservePrice" ) . '"'; ?> >
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-3">
                            <label>Start Time</label>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepickerStart'>
                                    <input type='text' class="form-control" name="startTime" readonly
                                        <?php echo 'value = "' . SessionOperator::getFormInput( "startTime" ) . '"'; ?> >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-3">
                            <label>End Time</label>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepickerEnd'>
                                    <input type='text' class="form-control" name="endTime" readonly
                                        <?php echo 'value = "' . SessionOperator::getFormInput( "endTime" ) . '"'; ?> >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- auction details end -->


                <!-- submit auction start -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right" name="startAuction">
                        <span class="glyphicon glyphicon-play-circle"></span> Start Auction
                    </button>
                </div>
                <!-- submit auction end -->

            </form>
            <!-- auction setup end -->


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