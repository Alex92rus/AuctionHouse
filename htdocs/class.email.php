<?php
require_once "phpmailer/PHPMailerAutoload.php";


class Email
{
    private $email;

    function __construct()
    {
        //Create a new PHPMailer instance
        $this -> email = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $this -> email -> isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this -> email -> SMTPDebug = 0;

        //Ask for HTML-friendly debug output
        $this -> email -> Debugoutput = "html";

        //Whether to use SMTP authentication
        $this -> email -> SMTPAuth = true;

        //Set the encryption system to use - ssl (deprecated) or tls
        $this -> email -> SMTPSecure = "tls";

        //Set the hostname of the mail server
        $this -> email -> Host = "smtp.gmail.com";

        //Set the SMTP port number - 587 for authenticated TLS
        $this -> email -> Port = 587;

        //Username to use for SMTP authentication
        $this -> email -> Username = "auction.house.ucl@gmail.com";

        //Password to use for SMTP authentication
        $this -> email -> Password = "Bidder2016!";

        //Set who the message is to be sent from
        $this -> email -> setFrom( "auctionhouse@gmail.com", "AuctionHouse Team");
    }

    private function confirmResult( $result )
    {
        // Error with mailer
        if ( !$result )
        {
            die( "Mailer Error: " . $this -> email -> ErrorInfo );
        }
    }

    private function setRecipient( $to, $firstName, $lastName )
    {
        $this -> email -> addAddress( $to, $firstName . " " . $lastName );
    }

    public function prepareVerificationEmail( $to, $firstName, $lastName, $confirmId )
    {
        // Set subject
        $subject  = "Email Verification mail";
        $this -> email -> Subject = $subject;

        // Set message
        $message  = "<html><body>";
        $message .= "<div>";
        $message .= "<h3>Hello $firstName $lastName,</h3>";
        $message .= "<h4>We are ready to activate your account. All we need to do is make sure this is your email address.</h4>";
        $message .= "<a href='http://localhost:8888/confirmation.php?email=$to&confirmation_code=$confirmId'>Verify Address</a>";
        $message .= "<p>If you did not create a AuctionHouse account, just delete this email and everything will go back to the way it was.</p>";
        $message .= "</div>";
        $message .= "</body></html>";
        $this -> email -> Body = $message;
        $this -> email -> IsHTML( true );

        // Set who the message is to be sent to
        $this -> setRecipient( $to, $firstName, $lastName );
    }

    public function sentEmail()
    {
        // Set who the message is to be sent from
        $this -> email -> setFrom( "auctionhouse@gmail.com", "AuctionHouse Team");

        // Send email
        $result = $this -> email -> send ();
        $this -> confirmResult( $result );
    }
}
