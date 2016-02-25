<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../scripts/user_session.php";

$search_result = SessionOperator::getSearchSetting( SessionOperator::SEARCH_RESULT );
$sort = SessionOperator::getSearchSetting( SessionOperator::SORT );

$sortOptions = QueryOperator::getSortOptionsList();
$subCategories = QueryOperator::getCategoriesList();

$user = SessionOperator::getUser();
$liveAuctions = QueryOperator::getLiveAuctions( $user -> getUserId(), $user -> getCountry() );

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
    <script src="../js/jquery.countdown.min.js"></script>
    <script src="../js/custom/search.js"></script>

</head>

<body>

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
                        <button type="button" class="btn btn-primary"><?= $sort ?></button>
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                            foreach ( $sortOptions as $option ) {
                                $option = htmlspecialchars( $option );
                                $active = "";
                                if ( $option == $sort ) {
                                    $active = "active";
                                }
                                ?>
                                <li class="<?= $active ?>"><a href="../scripts/search.php?sort=<?= urlencode( $option ) ?>"><?= $option ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- search header end -->


            <!-- search main start -->
            <div class="row" id="search-main">

                <!-- categories menu start -->
                <div class="col-xs-3">

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4>Categories</h4>
                            <hr id="categories">
                            <?php
                            if ( !empty( $search_result ) ) {
                                // Display all super categories
                                if (in_array("All", $search_result[0])) {
                                    foreach ($superCategories as $category) {
                                        $category = htmlspecialchars($category);
                                        echo "<p><a href=\"../scripts/search.php?searchCategory=" . urlencode($category) . "\">$category</a></p>";
                                    }
                                    // Display some super categories
                                } else if (count($search_result) == 2) {
                                    $categories = $search_result[0];
                                    foreach ($categories as $superCategoryId) {
                                        $category = htmlspecialchars($superCategories[$superCategoryId - 1]);
                                        echo "<p><a href=\"../scripts/search.php?searchCategory=" . urlencode($category) . "\">$category</a></p>";
                                    }
                                    // Display a super category with its sub categories
                                } else if (count($search_result) == 3) {
                                    $superCategory = $superCategories[$search_result[0][0] - 1];
                                    $categories = $search_result[1];
                                    echo "<h4 id=\"super-category\">" . $superCategory . "</h4>";
                                    foreach ($categories as $subCategoryId) {
                                        $category = htmlspecialchars($subCategories[$subCategoryId - 1]);
                                        $element = "<p><a href=\"../scripts/search.php?searchCategory=" . urlencode($category) . "\">$category</a></p>";
                                        $element = str_replace("<p>", "<p class=\"a-subcategory\">", $element);
                                        if ($category == $searchCategory) {
                                            $element = "<strong>" . $element . "</strong>";
                                        }
                                        echo $element;
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <!-- categories menu end -->


                <!-- live auctions list start -->
                <div class="col-xs-9">
                    <?php
                    if ( empty( $search_result ) ) {
                        echo "<h4>No auctions found</h4>";
                    } else {
                        //$auctions = $search_result[ count( $search_result ) - 1 ];
                        foreach ( $liveAuctions as $liveAuction ) {
                            $_ENV[ "liveAuction" ] = $liveAuction;
                            include "../includes/live_auction_to_buyer.php";
                        }
                    }
                    ?>
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