<?php

class Auction
{
    private $auctionId;
    private $userName;
    private $quantity;
    private $startPrice;
    private $reservePrice;
    private $startTime;
    private $endTime;
    private $itemName;
    private $itemBrand;
    private $itemDescription;
    private $image;
    private $categoryName;
    private $conditionName;
    private $country;


    public function __construct( $details )
    {
        foreach ( $details as $field => $value )
        {
            call_user_func( "Auction::" . "set" . ucfirst( $field ), $value );
        }
    }


    public function getAuctionId()
    {
        return $this->auctionId;
    }


    private function setAuctionId($auctionId)
    {
        $this->auctionId = $auctionId;
    }


    public function getUsername()
    {
        return $this->userName;
    }


    private function setUsername($userName)
    {
        $this->userName = $userName;
    }


    public function getQuantity()
    {
        return $this->quantity;
    }


    private function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }


    public function getStartPrice()
    {
        return $this->startPrice;
    }


    private function setStartPrice($startPrice)
    {
        $this->startPrice = $startPrice;
    }


    public function getReservePrice()
    {
        return $this->reservePrice;
    }


    private function setReservePrice($reservePrice)
    {
        $this->reservePrice = $reservePrice;
    }


    public function getStartTime()
    {
        return $this->startTime;
    }


    private function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }


    public function getEndTime()
    {
        return $this->endTime;
    }


    private function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }


    public function getItemName()
    {
        return $this->itemName;
    }


    private function setItemName($itemName)
    {
        $this->itemName = $itemName;
    }


    public function getItemBrand()
    {
        return $this->itemBrand;
    }


    private function setItemBrand($itemBrand)
    {
        $this->itemBrand = $itemBrand;
    }


    public function getItemDescription()
    {
        return $this->itemDescription;
    }


    private function setItemDescription($itemDescription)
    {
        $this->itemDescription = $itemDescription;
    }


    public function getImage()
    {
        return $this->image;
    }


    private function setImage($image)
    {
        $this->image = $image;
    }


    public function getCategoryName()
    {
        return $this->categoryName;
    }


    private function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }


    public function getConditionName()
    {
        return $this->conditionName;
    }


    private function setConditionName($conditionName)
    {
        $this->conditionName = $conditionName;
    }


    public function getCountry()
    {
        return $this->country;
    }


    private function setCountry($country)
    {
        $this->country = $country;
    }
}