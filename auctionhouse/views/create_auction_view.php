<?php
require_once "../classes/class.session_operator.php";
require_once "../scripts/helper_functions.php";
require_once "../scripts/user_session.php";
require_once "../config/config.php";
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
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet" type="text/css">
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/bootstrap-select.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/general.css" rel="stylesheet" type="text/css">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-notify.min.js"></script>
    <script src="../js/metisMenu.min.js"></script>
    <script src="../js/sb-admin-2.js"></script>
    <script src="../js/bootstrap.file-input.js"></script>
    <script src="../js/bootstrap-select.min.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/custom/search.js"></script>
    <script src="../js/custom/auction.js"></script>

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
                    <h2 class="page-header"><span class="glyphicon glyphicon-plus-sign"></span> Create New Auction</h2>
                </div>
            </div>
            <!-- profile header end -->


            <!-- auction setup start -->
            <form action="xxx" method="post" class="row" role="form">

                <!-- item details start -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Item details</strong>
                    </div>

                    <div class="panel-body row">

                        <!-- left column start -->
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Create a new item or use one of your already existing one</label>
                                <select class="selectpicker form-control" name="item">
                                    <option default>New Item</option>
                                    <option>Item 1</option>
                                    <option>Item 2</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Name</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "itemName" ) ?>
                                </label>
                                <input type="text" class="form-control" name="itemName" maxlength="45" value= "" >
                            </div>

                            <div class="form-group">
                                <label>Brand</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "itemBrand" ) ?>
                                </label>
                                <input type="text" class="form-control" name="itemBrand" maxlength="45" value= "" >
                            </div>

                            <div class="form-group">
                                <label>Category</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "itemCategory" ) ?>
                                </label>
                                <select class="selectpicker form-control" name="category" >
                                    <option default>Select category</option>
                                    <?php
                                    $itemCategory = SessionOperator::getFormInput( "itemCategory" );
                                    foreach( ITEM_CATEGORIES_ARRAY as $value ) {
                                        $selected = "";
                                        if ($value == $itemCategory) {
                                            $selected = "selected";
                                        }
                                        ?>
                                        <option value="<?= $value ?>" title="<?= htmlspecialchars($value) ?>" <?= $selected ?> ><?= htmlspecialchars($value) ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Condition</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "itemCondition" ) ?>
                                </label>
                                <select class="selectpicker form-control" name="category" >
                                    <option default>Select category</option>
                                    <?php
                                    $itemCondition = SessionOperator::getFormInput( "itemCondition" );
                                    foreach( CONDITION_CATEGORIES_ARRAY as $value ) {
                                        $selected = "";
                                        if ($value == $itemCondition) {
                                            $selected = "selected";
                                        }
                                        ?>
                                        <option value="<?= $value ?>" title="<?= htmlspecialchars($value) ?>" <?= $selected ?> ><?= htmlspecialchars($value) ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- left column end -->

                            <!-- right column start -->
                            <div class="form-group">
                                <label>Image</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "itemImage" ) ?>
                                </label>
                                <div class="input-group image-preview">
                                    <input type="text" class="form-control image-preview-filename" disabled="disabled">
                                    <span class="input-group-btn">
                                        <!-- image-preview-clear button -->
                                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                            <span class="glyphicon glyphicon-remove"></span> Clear
                                        </button>
                                        <!-- image-preview-input -->
                                        <div class="btn btn-default image-preview-input">
                                            <span class="glyphicon glyphicon-folder-open"></span>
                                            <span class="image-preview-input-title">Browse</span>
                                            <input type="file" accept="image/png, image/jpeg, image/gif" name="input-file-preview" />
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <!-- right column end -->

                        </div>

                        <div class="col-xs-7">
                            <div class="form-group">
                                <label>Description</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "itemDescription" ) ?>
                                </label>
                                <textarea class="form-control textarea" id="description" rows="24" name="description" placeholder="Enter a description" maxlength="2000"></textarea>
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

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-xs-4">
                                <label>Item quantity</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "quantity" ) ?>
                                </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                        </span>
                                        <input type="text" name="quant[2]" class="form-control input-number" value="1">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <label>Start Time</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "startTime" ) ?>
                                </label>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepickerStart'>
                                        <input type='text' class="form-control" readonly />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <label>End Time</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "endTime" ) ?>
                                </label>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepickerEnd'>
                                        <input type='text' class="form-control" readonly />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">
                                <label>Start price</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "startPrice" ) ?>
                                </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">£</span>
                                        <input type="text" class="form-control" placeholder="10.00">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <label>Reserve price</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "reservePrice" ) ?>
                                </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">£</span>
                                        <input type="text" class="form-control" placeholder="100.00">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <label>Shipping costs</label>
                                <label class="pull-right text-danger">&nbsp
                                    <?= SessionOperator::getInputErrors( "shippingCosts" ) ?>
                                </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">£</span>
                                        <input type="text" class="form-control" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- auction details end -->


                <!-- submit auction start -->
                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-primary pull-right" name="startAuction">
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