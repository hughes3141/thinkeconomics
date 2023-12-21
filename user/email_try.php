<?php

echo "This is trying email";

// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("hughes.ryan@gmail.com","My subject",$msg);

echo $msg;

phpinfo();

?>