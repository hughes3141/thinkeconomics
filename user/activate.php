<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");
include($path."/php_email_functions.php");
include ($path."/header_tailwind.php");
include ($path."/php_tutorial_libs/filter.php");
include ($path."/php_tutorial_libs/sanitization.php");

if (is_get_request()) {

  /*

  // sanitize the email & activation code
  [$inputs, $errors] = filter($_GET, [
      'email' => 'string | required | email',
      'activation_code' => 'string | required'
  ]);
  */

  $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
  $activation_code= filter_var($_GET['activation_code'], FILTER_SANITIZE_STRING);

  echo $email;
  echo "<br>";
  echo $activation_code;

  $errors = null;


  if (!$errors) {

      $user = find_unverified_user($activation_code, $email);

      // if user exists and activate the user successfully
      if ($user && activate_user($user['id'])) {
        echo "this user is unverified"
        /*
          redirect_with_message(
              'login.php',
              'You account has been activated successfully. Please login here.'
          );
          */
      }
  }
}

?>
