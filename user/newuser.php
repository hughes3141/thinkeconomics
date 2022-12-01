<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");
  
}

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");
include ($path."/header_tailwind.php");

//$userId = $_SESSION['userid'];

$firstName = $lastName = $username= "";
$username_err = $password_err = "";

//Processing form data when form is submitted
if($_SERVER['REQUEST_METHOD'] == "POST") {

  $firstName = trim($_POST['firstName']);
  $lastName = trim($_POST['lastName']);
  
  //Check if username is already taken
  if(empty(trim($_POST['username']))) {
    $username_err = "Please enter a username";
  } else {
    $username = trim($_POST['username']);

    //Prepare statement to check username:
    $sql = "SELECT username FROM users WHERE username = ?";
    if($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_username);
      
      //Set parameters
      $param_username = $username;
      if($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows>0) {
          $username_err = "<b>".$username."</b> is registered by another user. Please try another username.";
        }
      }
    }
  }

  //Check to see that username fits rules:
  /*
  $regexp = "/^\S*$/"; // a string consisting only of non-whitespaces
  if(!preg_match($regexp, $username)) {
    $username_err = "'<b>$username</b>' is invalid: spaces are not allowed in username.";
  }
  */

  //$regexp = "^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$";
  //$regexp = "/^[a-zA-Z0-9](_(?!(\.|_))|\.(?!(_|\.))|[a-zA-Z0-9]){6,18}[a-zA-Z0-9]$";
  //Follows these rules: Must start with letter, 6-32 characters, Letters and numbers only

  $regexp = "/^[A-Za-z][A-Za-z0-9]{5,31}$/";
  if(!preg_match($regexp, $username)) {
    $username_err = "'<b>$username</b>' is invalid.";
  }

}

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">New User Registration</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">

      <p>This is the form for registering new users.</p>

      <?php
        echo "<p>";
        print_r($_POST);
        echo "<p>";
      ?>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">First Name:</label>
                <input type="text" name="firstName" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="First Name" value="<?php echo ($firstName!=="")? $firstName : ""; ?>">

      </div>   
      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">Last Name:</label>
                <input type="text" name="lastName" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="Last Name" value="<?php echo ($lastName!=="")? $lastName : ""; ?>">

      </div>
      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">Username:</label>
                <input type="text" name="username" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="username" value="<?php 
                  if($username !=="" AND $username_err =="") {
                    echo $username;
                  } else {
                    echo "";
                  }
                  ?>" onchange = "this.form.submit()">
                <span class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $username_err; ?></span>

      </div> 
      <div class="form-group">
                <input type="submit" class=" bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" value="Sign Up!">
      </div>

      </form>
    

          
          <h1 class="font-mono text-xl bg-pink-300 pl-1"></h1>
          

        </div>
</div>


<?php include "../footer_tailwind.php"; ?>

