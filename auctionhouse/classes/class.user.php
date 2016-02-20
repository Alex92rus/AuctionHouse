<?php


Class User
{
    private $userId;
    private $username;
    private $email;
    private $firstName;
    private $lastName;
    private $address;
    private $postcode;
    private $city;
    private $country;
    private $image;

    public function __construct( $account )
    {
        $this -> userId = $account[ "userId" ];
        $this -> username = $account[ "username" ];
        $this -> email = $account[ "email" ];
        $this -> firstName = $account[ "firstName" ];
        $this -> lastName = $account[ "lastName" ];
        $this -> address = $account[ "address" ];
        $this -> postcode = $account[ "postcode" ];
        $this -> city = $account[ "city" ];
        $this -> country = $account[ "countryName" ];
        $this -> image = $account[ "image" ];
    }

    public function getUserId()
    {
        return $this -> userId;
    }

    public function getUsername()
    {
        return $this -> username;
    }

    public function getEmail()
    {
        return $this -> email;
    }

    public function getFirstName()
    {
        return $this -> firstName;
    }

    public function getLastName()
    {
        return $this -> lastName;
    }

    public function getAddress()
    {
        return $this -> address;
    }

    public function getPostcode()
    {
        return $this -> postcode;
    }

    public function getCity()
    {
        return $this -> city;
    }

    public function getCountry()
    {
        return $this -> country;
    }

    public function getImage()
    {
        return $this -> image;
    }
}