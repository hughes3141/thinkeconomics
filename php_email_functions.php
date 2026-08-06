<?php

/*
This asset will use information from /php_header.php
Make sure that when this is called in a page it is done after:
  $path = $_SERVER['DOCUMENT_ROOT'];
  include('/php_header.php')
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//$path = $_SERVER['DOCUMENT_ROOT'];
//include($path."/php_header.php");

require $path.'/PHPMailer-master/src/Exception.php';
require $path.'/PHPMailer-master/src/PHPMailer.php';
require $path.'/PHPMailer-master/src/SMTP.php';

function send_activation_email(string $emailAddress, string $name, string $activation_code, int $expiryHours = 24): void
{

    global $emailPasswordNoReply;
    // create the activation link
    $activation_link = "https://thinkeconomics.co.uk/user/activate.php?email=$emailAddress&activation_code=$activation_code";

    $mail = new PHPMailer(true); // Passing `true` enables exceptions
    try {

        //Server settings
        //$mail->SMTPDebug = 2; // Enable verbose debug output
        $mail->SMTPDebug = 0; // No debugging; used for production
        $mail->isSMTP(); // Set mailer to use SMTP
        //$mail->isMail(); 
        $mail->Host = 'mail.thinkeconomics.co.uk'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
    
        
        $mail->Username   = 'no-reply@thinkeconomics.co.uk';   // SMTP username
        $mail->Password   = $emailPasswordNoReply;       // SMTP password
        //Passsword found in secrets

        

        $mail->SMTPSecure = 'tls'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 587; // TCP port to connect to (587 is the standard STARTTLS submission port)
        //Recipients
        $mail->setFrom('no-reply@thinkeconomics.co.uk', 'ThinkEconomics Support'); //This is the email your form sends From

        $mail->addAddress($emailAddress, $name); // Add a recipient address
        //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'ThinkEconomics: Please activate your account '.date('d/m/Y H:i');
        $mail->Body    = <<<MESSAGE
Hi $name,
<p>Thanks for signing up to ThinkEconomics! Please click the link below to activate your account and get started:</p>
<p><a target = "_blank" href="$activation_link">$activation_link</a></p>
<p>This link will expire in $expiryHours hours, so be sure to activate your account soon.</p>
<p>If you didn't sign up for a ThinkEconomics account, you can safely ignore this email.</p>
<p>Thanks,<br>The ThinkEconomics Team</p>
MESSAGE;
        $mail->send();

    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }

}

function send_password_reset_email(string $emailAddress, string $name, string $resetCode, int $expiryHours = 1): void
{
    global $emailPasswordNoReply;
    $reset_link = "https://thinkeconomics.co.uk/user/password_reset.php?email=$emailAddress&reset_code=$resetCode";

    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mail.thinkeconomics.co.uk';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@thinkeconomics.co.uk';
        $mail->Password = $emailPasswordNoReply;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('no-reply@thinkeconomics.co.uk', 'ThinkEconomics Support');
        $mail->addAddress($emailAddress, $name);
        $mail->isHTML(true);
        $mail->Subject = 'ThinkEconomics: Password change request '.date('d/m/Y H:i');
        $mail->Body    = <<<MESSAGE
Hi $name,
<p>We received a request to change the password on your ThinkEconomics account. Click the link below to choose a new password:</p>
<p><a target = "_blank" href="$reset_link">$reset_link</a></p>
<p>This link will expire in $expiryHours hour(s).</p>
<p>If you didn't request this, you can safely ignore this email - your password won't be changed unless you click the link above and set a new one.</p>
<p>Thanks,<br>The ThinkEconomics Team</p>
MESSAGE;
        $mail->send();

    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}

?>