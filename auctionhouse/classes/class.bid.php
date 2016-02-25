<?php

class Bid
{
    private $bidderName;
    private $bidTime;
    private $bidPrice;


    public function __construct( $details )
    {
        foreach ( $details as $field => $value )
        {
            call_user_func( "Bid::" . "set" . ucfirst( $field ), $value );
        }
    }


    public function getBidderName()
    {
        return $this -> bidderName;
    }


    private function setBidderName( $bidderName )
    {
        $this -> bidderName = $bidderName;
    }


    public function getBidTime()
    {
        return $this -> bidTime;
    }


    private function setBidTime( $bidTime )
    {
        $this -> bidTime = $bidTime;
    }


    public function getBidPrice()
    {
        return $this -> bidPrice;
    }


    private function setBidPrice( $bidPrice )
    {
        $this -> bidPrice = $bidPrice;
    }
}
