<?php

class Bid
{
    private $bidderId;
    private $bidderName;
    private $bidderEmail;
    private $bidderFirstName;
    private $bidderLastName;
    private $bidTime;
    private $bidPrice;


    public function __construct( $details )
    {
        foreach ( $details as $field => $value )
        {
            call_user_func( "Bid::" . "set" . ucfirst( $field ), $value );
        }
    }


    public function getBidderId()
    {
        return $this -> bidderId;
    }


    private function setBidderId( $bidderId )
    {
        $this -> bidderId = $bidderId;
    }


    public function getBidderName()
    {
        return $this -> bidderName;
    }


    private function setBidderName( $bidderName )
    {
        $this -> bidderName = $bidderName;
    }


    public function getBidderEmail()
    {
        return $this -> bidderEmail;
    }


    private function setBidderEmail( $bidderEmail )
    {
        $this -> bidderEmail = $bidderEmail;
    }


    public function getBidderFirstName()
{
    return $this -> bidderFirstName;
}


    private function setBidderFirstName( $bidderFirstName )
    {
        $this -> bidderFirstName = $bidderFirstName;
    }


    public function getBidderLastName()
    {
        return $this -> bidderLastName;
    }


    private function setBidderLastName( $bidderLastName )
    {
        $this -> bidderLastName = $bidderLastName;
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
