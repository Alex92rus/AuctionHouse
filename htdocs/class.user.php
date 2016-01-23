<?php


Class User
{
    private $username;
    private $email;
    private $firstName;
    private $lastName;
    private $address;
    private $postcode;
    private $city;
    private $country;
    private $password1;
    private $password2;

    public function __construct( $username, $email, $firstName, $lastName, $address, $postcode, $city, $country, $password1, $password2 )
    {
        $this -> username = $username;
        $this -> email = $email;
        $this -> firstName = $firstName;
        $this -> lastName = $lastName;
        $this -> address = $address;
        $this -> postcode = $postcode;
        $this -> city = $city;
        $this -> country = $country;
        $this -> password1 = $password1;
        $this -> password2 = $password2;
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

    public function getPassword1()
    {
        return $this -> password1;
    }

    public function getPassword2()
    {
        return $this -> password2;
    }

    public function getMemberField( $memberField )
    {
        switch ( $memberField )
        {
            case "username": return $this -> getUsername();
            case "email": return $this -> getEmail();
            case "firstName": return $this -> getFirstName();
            case "lastName": return $this -> getLastName();
            case "address": return $this -> getAddress();
            case "postcode": return $this -> getPostcode();
            case "city": return $this -> getCity();
            case "country": return $this -> getCountry();
            case "password1": return $this -> getPassword1();
            case "password2": return $this -> getPassword2();
        }
    }

    public function getObjectVars()
    {
        return get_object_vars( $this );
    }
}