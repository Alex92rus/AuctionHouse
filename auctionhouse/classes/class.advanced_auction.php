<?php
require_once "class.auction.php";
require_once "class.bid.php";


class AdvancedAuction
{
    private $auction;
    private $bids;
    private $views;
    private $watches;


    public function __construct( $auction, $bids, $views, $watches )
    {
        $this -> auction = $auction;
        $this -> bids = $bids;
        $this -> views = $views;
        $this -> watches = $watches;
    }


    public function getAuction()
    {
        return $this -> auction;
    }


    public function getBids()
    {
        return $this -> bids;
    }


    public function getViews()
    {
        return $this -> views;
    }


    public function getWatches()
    {
        return $this -> watches;
    }
}