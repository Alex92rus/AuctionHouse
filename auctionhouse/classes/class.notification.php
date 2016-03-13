<?php

class Notification
{
    private $notificationId;
    private $auctionId;
    private $time;
    private $categoryName;
    private $categoryIcon;
    private $message;


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
    public function getNotificationId()
    {
        return $this->notificationId;
    }


    /**
     * @param mixed $notificationId
     */
    public function setNotificationId($notificationId)
    {
        $this->notificationId = $notificationId;
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
        require_once "../config/config.php";
        $time = new DateTime( $this->time, new DateTimeZone( TIMEZONE ) );
        $now = new DateTime( "now", new DateTimeZone( TIMEZONE ) );
        $interval = $now->diff( $time );
        return $interval -> format('%h h %i min ago');
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
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}