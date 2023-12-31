<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


echo "activate";

//print_r($_GET);

echo (isset($_GET['email']));

if(isset($_GET['email']) && isset($_GET['activation_code'])) {
  // sanitize the email & activation code
  /*
    [$inputs, $errors] = filter($_GET, [
      'email' => 'string | required | email',
      'activation_code' => 'string | required'
    ]);
    */

  $inputs = array(
    'email' => $_GET['email'],
    'activation_code' => $_GET['activation_code']
  );

  //print_r($inputs);

  $user = find_unverified_user($inputs['activation_code'], $inputs['email']);

  //print_r($user);

  if($user && activate_user($user['id'])) {
    //Send to a new page
    echo "<script>window.location = '/user/user3.0.php'</script>";
  }


}





?>
