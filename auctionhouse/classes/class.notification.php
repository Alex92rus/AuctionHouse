<?php

class Notification
{
    private $auctionId;
    private $time;
    private $categoryName;
    private $categoryIcon;
    private $itemName;
    private $itemBrand;


    public function __construct( $details )
    {
        foreach ( $details as $field => $value )
        {
            if(method_exists($this,"set" . ucfirst( $field ))){

                call_user_func( "Notification::" . "set" . ucfirst( $field ), $value );
            }
        }
    }

    /**
     * @return mixed
     */
    public function getAuctionId()
    {
        return $this->auctionId;
    }


    /**
     * @param mixed $auctionId
     */
    public function setAuctionId($auctionId)
    {
        $this->auctionId = $auctionId;
    }


    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }


    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }


    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }


    /**
     * @param mixed $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }


    /**
     * @return mixed
     */
    public function getCategoryIcon()
    {
        return $this->categoryIcon;
    }


    /**
     * @param mixed $categoryIcon
     */
    public function setCategoryIcon($categoryIcon)
    {
        $this->categoryIcon = $categoryIcon;
    }


    /**
     * @return mixed
     */
    public function getItemName()
    {
        return $this->itemName;
    }


    /**
     * @param mixed $itemName
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    }


    /**
     * @return mixed
     */
    public function getItemBrand()
    {
        return $this->itemBrand;
    }


    /**
     * @param mixed $itemBrand
     */
    public function setItemBrand($itemBrand)
    {
        $this->itemBrand = $itemBrand;
    }
}