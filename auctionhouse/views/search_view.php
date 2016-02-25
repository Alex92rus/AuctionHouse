<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../scripts/user_session.php";

$currentSort = SessionOperator::getSearchSettings( SessionOperator::SORT );
$currentCategoryFilter = SessionOperator::getSearchSettings( SessionOperator::CATEGORY_FILTER );
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Search Results</title>

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

            <!-- search header start -->
            <div class="row" id="search-header">

                <label class="col-xs-8" id="search-total-results">12 results for <span class="text-danger">"mac book pro"</span></label>

                <div class="col-xs-4 text-right">
                    <label id="search-sort">Sort by </label>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary"><?= $currentSort ?></button>
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                            $sortOptions = QueryOperator::getSortOptionsList();

                            foreach ( $sortOptions as $option )
                            {
                                $option = htmlspecialchars( $option );
                                $active = "";
                                if ( $option == $currentSort )
                                {
                                    $active = "active";
                                }
                                ?>
                                <li class="<?= $active ?>"><a href="../scripts/rearrange_auctions.php?sort=<?= $option ?>"><?= $option ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- search header end -->


            <!-- search main start -->
            <div class="row" id="search-main">

                <!-- filtering menu start -->
                <div class="col-xs-3">

                    <!-- categories filtering start -->
                    <h4>Categories</h4>
                    <?php
                    $itemCategories = QueryOperator::getCategoriesList();
                    array_unshift( $itemCategories, "All" );
                    $show = 10;

                    echo "<strong><p><a id='current-category' href=\" ../scripts / rearrange_auctions . php ? categoryFilter = $currentCategoryFilter\">$currentCategoryFilter</a></p></strong>";
                    foreach ( $itemCategories as $index => $category )
                    {
                        $value = htmlspecialchars( $category );
                        if ( $index < $show ) {
                            if ( $category != $currentCategoryFilter ) {
                                echo "<p><a href=\"../scripts/rearrange_auctions.php?categoryFilter=$category\">$category</a></p>";
                            }
                        }
                    }
                    ?>
                    <div id="moreCategories" class="collapse">
                        <?php
                        $itemCategories = QueryOperator::getCategoriesList();

                        foreach ( $itemCategories as $index => $category )
                        {
                            $value = htmlspecialchars( $category );
                            if ( $index >= $show ) {
                                if ( $category != $currentCategoryFilter ) {
                                    echo "<p><a href=\"../scripts/rearrange_auctions.php?categoryFilter=$category\">$category</a></p>";
                                }
                            }
                        }
                        ?>
                    </div>
                    <p><strong><a href="#" data-toggle="collapse" id="showCategories" data-target="#moreCategories">Show more categories</a></strong></p>
                    <hr>
                    <!-- categories filtering end -->

                </div>
                <!-- filtering menu end -->


                <!-- live auctions list start -->
                <div class="col-xs-9">

                </div>
                <!-- live auctions list end -->


            </div>
            <!-- search main end -->


        </div>
        <!-- main end -->


    </div>
    <!-- /#wrapper -->

</body>

</html>