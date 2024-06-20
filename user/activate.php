<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");
include($path."/php_email_functions.php");
include ($path."/header_tailwind.php");

if (is_get_request()) {

  // sanitize the email & activation code
  [$inputs, $errors] = filter($_GET, [
      'email' => 'string | required | email',
      'activation_code' => 'string | required'
  ]);

  if (!$errors) {

      $user = find_unverified_user($inputs['activation_code'], $inputs['email']);

      // if user exists and activate the user successfully
      if ($user && activate_user($user['id'])) {
          redirect_with_message(
              'login.php',
              'You account has been activated successfully. Please login here.'
          );
      }
  }
}

?>
