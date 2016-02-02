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
    private $countryId;
    private $imageName;

    public function __construct( $userId, $username, $email, $firstName, $lastName, $address, $postcode, $city, $countryId, $imageName )
    {
        $this -> userId = $userId;
        $this -> username = $username;
        $this -> email = $email;
        $this -> firstName = $firstName;
        $this -> lastName = $lastName;
        $this -> address = $address;
        $this -> postcode = $postcode;
        $this -> city = $city;
        $this -> countryId = $countryId;
        $this -> imageName = $imageName;
    }

    public function getUserId()
    {
        return $this -> userId;
    }

    public function setUsername( $update )
    {
        $this -> username = $update;
    }

    public function getUsername()
    {
        return $this -> username;
    }

    public function setEmail( $update )
    {
        $this -> email = $update;
    }

    public function getEmail()
    {
        return $this -> email;
    }

    public function setFirstName( $update )
    {
        $this -> firstName = $update;
    }

    public function getFirstName()
    {
        return $this -> firstName;
    }

    public function setLastName( $update )
    {
        $this -> lastName = $update;
    }

    public function getLastName()
    {
        return $this -> lastName;
    }

    public function setAddress( $update )
    {
        $this -> address = $update;
    }

    public function getAddress()
    {
        return $this -> address;
    }

    public function setPostcode( $update )
    {
        $this -> postcode = $update;
    }

    public function getPostcode()
    {
        return $this -> postcode;
    }

    public function setCity( $update )
    {
        $this -> city = $update;
    }

    public function getCity()
    {
        return $this -> city;
    }

    public function setCountryId( $update )
    {
        $this -> countryId = $update;
    }

    public function getCountryId()
    {
        return $this -> countryId;
    }

    public function setImageName( $update )
    {
        $this -> imageName = $update;
    }

    public function getImageName()
    {
        return $this -> imageName;
    }
}