<?php
require_once "../config/config.php";
require_once "../phpmailer/PHPMailerAutoload.php";


class Email
{
    private $email;
    private $username;
    private $to;
    private $firstName;
    private $lastName;
    private $subject;
    private $message;

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
        $this -> email -> Debugoutput = EMAIL_DEBUG;

        //Whether to use SMTP authentication
        $this -> email -> SMTPAuth = true;

        //Set the encryption system to use - ssl (deprecated) or tls
        $this -> email -> SMTPSecure = EMAIL_ENCRYPTION;

        //Set the hostname of the mail server
        $this -> email -> Host = EMAIL_HOST;

        //Set the SMTP port number - 587 for authenticated TLS
        $this -> email -> Port = EMAIL_SMTP;

        //Username to use for SMTP authentication
        $this -> username = EMAIL_USER;
        $this -> email -> Username = $this -> username;

        //Password to use for SMTP authentication
        $this -> email -> Password = EMAIL_PASSWORD;

        //Set message beginning
        $this -> message  = "<h3>Hello {$this -> firstName} {$this -> lastName},</h3>";
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
        $this -> subject  = "Email Verification";

        // Set message
        $message  = $this -> message;
        $message .= "<h4>We are ready to activate your account. All we need to do is make sure this is your email address.</h4>";
        $message .= "<a href='http://localhost:8888/scripts/confirmation.php?email={$this -> to}&confirm_code=$confirmCode'>Verify Address</a>";
        $message .= "<p>If you did not create a AuctionHouse account, just delete this email and everything will go back to the way it was.</p>";

        $this -> message = $message;
    }

    public function prepareResetEmail()
    {
        // Set subject
        $this -> subject  ="Password Reset";

        // Set message
        $message  = $this -> message;
        $message .= "<h4>Please follow the given link  to change your password</h4>";
        $message .= "<a href='http://localhost:8888/views/change_password_view.php?email={$this -> to}'>Change Password</a>";

        $this -> message = $message;
    }

    public function prepareRegistrationConfirmEmail()
    {
        // Set subject
        $this -> subject = "Registration confirmation";

        // Set message
        $message  = $this -> message;
        $message .= "<h4>Your registration was successful. You are now ready to access your account and start buying and selling auctions.</h4>";
        $message .= "<p>If you did not create a AuctionHouse account, please contact us on this email address <a href='mailto:{$this -> username}'>";
        $message .= "{$this -> username}</a></p>";

        $this -> message = $message;
    }


    public function preparePasswordConfirmEmail()
    {
        // Set subject
        $this -> subject = "Password confirmation";

        // Set message
        $message  = $this -> message;
        $message .= "<h4>You successfully changed your password.</h4>";
        $message .= "<p>If you did not create a AuctionHouse account, please contact us on this email address <a href='mailto:{$this -> username}'>";
        $message .= "{$this -> username}</a></p>";
        $this -> message = $message;
    }


    public function prepareOutbidEmail( $bidPrice, $newHighestBidder, $itemName, $itemBrand, $itemImage )
    {
        // Set subject
        $this -> subject = "You were outbid on an auction";

        // Set message
        $message  = $this -> message;
        $message .= "<p>You were outbid on the following auction:<br><br></p>";
        $message .= "<div><img src=\"cid:itemImage\" style=\"float:left; margin-right:20px; height: 100px; width: inherit\"><p><b>{$itemName}</b><br>{$itemBrand}</p></div>";
        $message .= "<p style='clear:left'><br><br>New highest bid is £{$bidPrice} by <b>{$newHighestBidder}</b></p>";
        $this -> message = $message;

        // Set attachment
        $this -> setAttachment( $itemImage );
    }


    public function prepareAuctionDeletedEmail( $itemName, $itemBrand, $itemImage )
    {
        // Set subject
        $this -> subject = "Auction deleted";

        // Set message
        $message  = $this -> message;
        $message .= "<p>Unfortunately, the following auction was deleted by the seller:<br><br></p>";
        $message .= "<div><img src=\"cid:itemImage\" style=\"float:left; margin-right:20px; height: 100px; width: inherit\"><p><b>{$itemName}</b><br>{$itemBrand}</p></div>";
        $message .= "<p style='clear:left'><br><br>We were told to inform you that the seller apologies sincerely.</b></p>";
        $this -> message = $message;

        // Set attachment
        $this -> setAttachment( $itemImage );
    }


    private function setAttachment( $image )
    {
        $this -> email -> AddEmbeddedImage( "..{$image}", "itemImage" );
    }


    private function prepareBody()
    {
        $message = $this -> message;
        $message = "<html><body><div>" . $message . "</div></body></html>";
        $this -> email -> Body = $message;
        $this -> email -> IsHTML( true );
    }


    public function sentEmail()
    {
        // Set email contents
        $this -> email -> Subject = $this -> subject;
        $this -> prepareBody();

        // Set who the message is to be sent from
        $this -> email -> setFrom( "auctionhouse@gmail.com", "AuctionHouse Service Team" );

        // Set who the message is to be sent to
        $this -> email -> addAddress( $this -> to, $this -> firstName . " " . $this -> lastName );

        // Send email
        $result = $this -> email -> send ();
        $this -> confirmResult( $result );
    }
}
