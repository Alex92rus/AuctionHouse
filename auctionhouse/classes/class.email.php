<?php
require_once "../phpmailer/PHPMailerAutoload.php";


class Email
{
    private $email;
    private $username;
    private $to;
    private $firstName;
    private $lastName;

    function __construct( $to, $firstName, $lastName )
    {
        $this -> to = $to;
        $this -> firstName = $firstName;
        $this -> lastName = $lastName;

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
        $this -> username = "auction.house.ucl@gmail.com";
        $this -> email -> Username = $this -> username;

        //Password to use for SMTP authentication
        $this -> email -> Password = "Bidder2016!";

        //Set who the message is to be sent from
        $this -> email -> setFrom( "auctionhouse@gmail.com", "AuctionHouse Team");
    }

    private function buildBody( $position )
    {
        return ( $position == 0 ) ? "<html><body><div>" : "</div></body></html>";
    }

    private function confirmResult( $result )
    {
        // Error with mailer
        if ( !$result )
        {
            die( "Mailer Error: " . $this -> email -> ErrorInfo );
        }
    }

    public function prepareVerificationEmail( $confirmCode )
    {
        // Set subject
        $subject  = "Email Verification";
        $this -> email -> Subject = $subject;

        // Set message
        $message  = $this -> buildBody( 0 );
        $message .= "<h3>Hello {$this -> firstName} {$this -> lastName},</h3>";
        $message .= "<h4>We are ready to activate your account. All we need to do is make sure this is your email address.</h4>";
        $message .= "<a href='http://localhost:8888/scripts/confirmation.php?email={$this -> to}&confirm_code=$confirmCode'>Verify Address</a>";
        $message .= "<p>If you did not create a AuctionHouse account, just delete this email and everything will go back to the way it was.</p>";
        $message .= $this -> buildBody( 1 );
        $this -> email -> Body = $message;
        $this -> email -> IsHTML( true );
    }

    public function prepareResetEmail()
    {
        // Set subject
        $subject  = "Password Reset";
        $this -> email -> Subject = $subject;

        // Set message
        $message  = $this -> buildBody( 0 );
        $message .= "<h3>Hello {$this -> firstName} {$this -> lastName},</h3>";
        $message .= "<h4>Please follow the given link  to change your password</h4>";
        $message .= "<a href='http://localhost:8888/changepassword.php?email={$this -> to}'>Change Password</a>";
        $message .= $this -> buildBody( 1 );
        $this -> email -> Body = $message;
        $this -> email -> IsHTML( true );
    }

    public function prepareRegistrationConfirmEmail()
    {
        // Set subject
        $subject  = "Registration confirmation";
        $this -> email -> Subject = $subject;

        // Set message
        $message  = $this -> buildBody( 0 );
        $message .= "<h3>Hello {$this -> firstName} {$this -> lastName}</h3>";
        $message .= "<h4>Your registration was successful. You are now ready to access your account and start buying and selling auctions.</h4>";
        $message .= "<p>If you did not create a AuctionHouse account, please contact us on this email address <a href='mailto:{$this -> username}'>";
        $message .= "{$this -> username}</a></p>";
        $message .= $this -> buildBody( 1 );
        $this -> email -> Body = $message;
        $this -> email -> IsHTML( true );
    }

    public function preparePasswordConfirmEmail()
    {
        // Set subject
        $subject  = "Password confirmation";
        $this -> email -> Subject = $subject;

        // Set message
        $message  = $this -> buildBody( 0 );
        $message .= "<h3>Hello {$this -> firstName} {$this -> lastName}</h3>";
        $message .= "<h4>Your successfully changed your password.</h4>";
        $message .= "<p>If you did not create a AuctionHouse account, please contact us on this email address <a href='mailto:{$this -> username}'>";
        $message .= "{$this -> username}</a></p>";
        $message .= $this -> buildBody( 1 );
        $this -> email -> Body = $message;
        $this -> email -> IsHTML( true );
    }

    public function sentEmail()
    {
        // Set who the message is to be sent from
        $this -> email -> setFrom( "auctionhouse@gmail.com", "AuctionHouse Service Team");

        // Set who the message is to be sent to
        $this -> email -> addAddress( $this -> to, $this -> firstName . " " . $this -> lastName );

        // Send email
        $result = $this -> email -> send ();
        $this -> confirmResult( $result );
    }
}
