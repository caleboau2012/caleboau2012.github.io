<?php

class SendGridEmail {

    private $sendgrid;

    function __construct() {
        $this->sendgrid = new SendGrid(SENDGRID_USERNAME, SENDGRID_PASSWORD);
        $this->mail = new SendGrid\Email();
        // ADD THE APP FILTERS
        $filters = array (
            "templates" => array (
                "settings" => array (
                    "enable" => 1,
                    "template_id" => "5cd8f05d-dd1c-4d64-be2b-ad87a300519f"
                )
            )
        );
        foreach($filters as $filter => $contents) {
            $settings = $contents['settings'];
            foreach($settings as $key => $value) {
                $this->mail->addFilterSetting($filter, $key, $value);
            }
        }

    }


    /**
     * Send an email after Registration using SendGrid's api
     * @param $recipient
     */

    public function sendRegistrationEmail($recipient,$first_name,$token) {
        $url = VERIFY_ACCOUNT_URL."?email=".$recipient."&token=".$token;
        //$emails = new SendGrid\Email();
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('registration');

        try {
            $this->mail->setSubject('Welcome to Ariya');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Welcome to Ariya</h3>
                <p>Hello "'.$first_name.'"</p>
                <p>Thanks for registering for our service.</p>
                <p>Please visit this <a href="'.$url.'">link</a> to verify your account.</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }


    public function forgotPasswordEmail($recipient,$forgotToken) {
        $url = FORGOT_PASSWORD_URL."?email=".$recipient."&token=".$forgotToken;
        //$emails = new SendGrid\Email();
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('forgot-password');

        try {
            $this->mail->setSubject('Forgotten Password');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello there,</h3><br />
                <p>There was recently a request to change the password for your account.</p>
                <p>If you requested this password change, please click on this <a href="'.$url.'">link</a> to reset your password:</p>
                <p>If clicking the link does not work, please copy and paste the URL into your browser instead.</p>
                <p>URL: '.$url.'</p>
                <p>If you did not make this request, you can ignore this message and your password will remain the same.</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }

    }


    public function verificationEmail($recipient,$first_name,$token) {
        $url = VERIFY_ACCOUNT_URL."?email=".$recipient."&token=".$token;
        //$emails = new SendGrid\Email();
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('verify-email');

        try {
            $this->mail->setSubject('Verify your account');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello "'.$first_name.'",</h3><br />
                <p>Kindly visit this <a href="'.$url.'">link</a> to verify your account.</p>
                <p>If clicking the link does not work, please copy and paste the URL below into your browser instead.</p>
                <p>URL: '.$url.'</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }


    //email to bid winner
    public function bidWinner($recipient, $name) {
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('bid-winner');

        try {
            $this->mail->setSubject('Congratulations, You have won the bid');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello '.$name.'</h3><br />
                <p>Congratulations, You have won the Bid!!!.</p>
                <p>Visit <a href="http://ariya.ng">http://ariya.ng</a> for more information.</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }

    public function bidPropertyOwner($recipient, $name) {
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('bid-concluded');

        try {
            $this->mail->setSubject('Bidding process has ended');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello '.$name.'</h3><br />
                <p>The bidding process for your property has ended.</p>
                <p>Visit <a href="http://ariya.ng">http://ariya.ng</a> for more information.</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }

    public function bidLosers($recipient, $name) {
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('bid-loser');

        try {
            $this->mail->setSubject('You lost the bid');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello '.$name.'</h3><br />
                <p>You have lost a bid.</p>
                <p>Visit <a href="http://ariya.ng">http://ariya.ng</a> for more information.</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }


    public function bookingWinner($recipient, $name) {
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('booking-accepted');

        try {
            $this->mail->setSubject('Your booking request has been accepted');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello '.$name.'</h3><br />
                <p>Congratulations, Your booking has been accepted!!!.</p>
                <p>Visit <a href="http://ariya.ng">http://ariya.ng</a> for more information.</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }

    public function bookingLoser($recipient, $name) {
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('booking-declined');

        try {
            $this->mail->setSubject('Your booking request has been declined');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello '.$name.'</h3><br />
                <p>Your booking request has been declined!!!.</p>
                <p>Visit <a href="http://ariya.ng">http://ariya.ng</a> for more information.</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }

    public function paymentAcceptedPropertyOwner($recipient, $name, $date) {
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('payment-accepted');

        try {
            $this->mail->setSubject('Payment Accepted');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello '.$name.'</h3><br />
                <p>A user just paid to use your property on the '.$date.'</p>
                <p>Visit <a href="http://ariya.ng">http://ariya.ng</a> for more information.</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }

    public function twentyFour($recipient, $name) {
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('twenty-four');

        try {
            $this->mail->setSubject('Payment Reminder');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello '.$name.'</h3><br />
                <p>It has been 24 hours since your request was accepted.</p>
                <p>Hope you have paid for the venue yet. If you haven\'t, please do so immediately.</p>
                <p>Visit <a href="http://ariya.com.ng">http://ariya.com.ng</a> for more information.</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }

    public function twentyFourOnwer($recipient, $name) {
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('twenty-four');

        try {
            $this->mail->setSubject('Payment Reminder');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello '.$name.'</h3><br />
                <p>It has been 24 hours since you accepted a request to use your venue.</p>
                <p>Hope the venue has been paid for?. If not, kindly exercise more patience.</p>
                <p>Visit <a href="http://ariya.com.ng">http://ariya.com.ng</a> for more information.</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }

    //email to bid winner
    public function contact($name, $email, $message) {
        $this->mail->addTo(CONTACT_EMAIL);
        $this->mail->setCc(CONTACT_EMAIL2);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('contact');

        try {
            $this->mail->setSubject('New Contact Message from '.$name);
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Hello Admin,</h3><br />
                <p>An individual with the Name: '.$name.' and Email Address: '.$email.',</p>
                <p>Just posted a Message. Here is the message:</p>
                <p>'.$message.'</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }

    public function elapse($recipient,$token) {
        $url = VERIFY_ACCOUNT_URL."?email=".$recipient."&token=".$token;
        //$emails = new SendGrid\Email();
        $this->mail->addTo($recipient);
        $this->mail->setFrom(SENDGRID_FROM_EMAIL);
        $this->mail->setFromName(SENDGRID_FROM_NAME);
        $this->mail->addCategory('Ariya');

        try {
            $this->mail->setSubject('Successful Registration');
            $this->mail->setText('');
            $this->mail->setHtml('<h3>Welcome to Ariya</h3>
                <p>Thanks for registering for our service.</p>
                <p>Visit this <a href="'.$url.'">LINK</a> to verify your account.</p>
                <p>Thank You!</p><br />');
            //$response = $this->sendgrid->send($email);
            $this->sendgrid->send($this->mail);
            //var_dump($response);
        } catch ( Exception $e ) {
            echo "Unable to send mail: ", $e->getMessage();
        }
    }
//// ADD THE SUBSTITUTIONS
//        $subs = array (
//            "%name%" => array (
//                "Hello ".$recipient
//            )
//        );
//        foreach($subs as $tag => $replacements) {
//            $this->mail->addSubstitution($tag, $replacements);
//        }


}

?>