<?php

$path = $_SERVER['DOCUMENT_ROOT'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require $path.'/PHPMailer-master/src/Exception.php';
require $path.'/PHPMailer-master/src/PHPMailer.php';
require $path.'/PHPMailer-master/src/SMTP.php';

//echo $path;

echo "This is trying email";

$mail = new PHPMailer(true); // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'mail.thinkeconomics.co.uk'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    
    $mail->Username   = 'no_reply@thinkeconomics.co.uk';   // SMTP username
    $mail->Password   = '';       // SMTP password

    

    $mail->SMTPSecure = 'tls'; // Enable SSL encryption, TLS also accepted with port 465
    $mail->Port = 465; // TCP port to connect to
    //Recipients
    $mail->setFrom('no_reply@thinkeconomics.co.uk', 'ThinkEconomics Support'); //This is the email your form sends From

    $mail->addAddress('hughes.ryan@gmail.com', 'Ryan Hughes'); // Add a recipient address
    //Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Subject line goes here';
    $mail->Body    = 'Body text goes here';
    $mail->send();
    echo 'Message has been sent';
    
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}


// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
//mail("hughes.ryan@gmail.com","My subject",$msg);

//echo $msg;

//phpinfo();

?>