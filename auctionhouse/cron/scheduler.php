<?php
require_once "../classes/class.query_operator.php";

$auctionIds = QueryOperator::test();

foreach ( $auctionIds as $auctionId ) {
    QueryOperator::addAuctionEvent( $auctionId[ "endTime" ], $auctionId[ "userId" ],  $auctionId[ "auctionId" ] );
}