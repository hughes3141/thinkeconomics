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

function send_activation_email(string $emailAddress, string $name, string $activation_code): void
{

    global $emailPassword;
    // create the activation link
    $activation_link = "/activate.php?email=$emailAddress&activation_code=$activation_code";

    $mail = new PHPMailer(true); // Passing `true` enables exceptions
    try {

        //Server settings
        $mail->SMTPDebug = 2; // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        //$mail->isMail(); 
        $mail->Host = 'mail.thinkeconomics.co.uk'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
    
        
        $mail->Username   = 'no_reply@thinkeconomics.co.uk';   // SMTP username
        $mail->Password   = $emailPassword;       // SMTP password
        //Passsword found in secrets

        

        $mail->SMTPSecure = 'tls'; // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 26; // TCP port to connect to
        //Recipients
        $mail->setFrom('no_reply@thinkeconomics.co.uk', 'ThinkEconomics Support'); //This is the email your form sends From

        $mail->addAddress($emailAddress, $name); // Add a recipient address
        //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Subject line goes here '.date('m/d/Y h:i:s a');
        $mail->Body    = 'Body text goes here\n'.$activation_link;
        $mail->send();
        echo 'Message has been sent';
        
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }





}


?>