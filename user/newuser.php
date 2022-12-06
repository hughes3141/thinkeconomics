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
  //The above means it's Only contains alphanumeric characters, underscore and dot, Underscore and dot can't be at the end or start of a username (e.g _username / username_ / .username / username.)., Underscore and dot can't be next to each other (e.g user_.name)., Underscore or dot can't be used multiple times in a row (e.g user__name / user..name)., Number of characters must be between 8 to 20.

  //Follows these rules: Must start with letter, 6-32 characters, Letters and numbers only
  //$regexp = "/^[A-Za-z][A-Za-z0-9]{5,31}$/";

  
  $regexp = "/^[a-zA-Z0-9](_(?!(\.|_))|\.(?!(_|\.))|[a-zA-Z0-9]){4,18}[a-zA-Z0-9]$/";

  if($username != "") {
    if(!preg_match($regexp, $username)) {
      $username_err = "'<b>$username</b>' is invalid.";
    }
  }

  //Check to see if password meets criteria:
    if(empty(trim($_POST['password1'])) and empty(trim($_POST['password1'])) and $username !="" and $username_err == "") {
      $password_err = "";
    } else {
      $password1 = trim($_POST['password1']);
      $password2 = trim($_POST['password2']);

      if ($password1 != $password2) {
        $password_err = "Passwords to not match";
      }
      else {

      $regexp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

        if($password1 != "") {
          if(!preg_match($regexp, $password1)) {
            $password_err = "This password does not fit the criteria.";
          }
        }
      }


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

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="inputForm">

      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">First Name:</label>
                <input type="text" name="firstName" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="First Name" value="<?php echo ($firstName!=="")? $firstName : ""; ?>">

      </div>   
      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">Last Name:</label>
                <input type="text" name="lastName" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="Last Name" value="<?php echo ($lastName!=="")? $lastName : ""; ?>">

      </div>
      <h2>Create Username</h2>
        <p>A username is unique to your account. It must be:
          <ul>
            </li>Between 6 and 20 characters.</li>
            <li>Begin with a letter</li>
            <li>Contain only letters, numbers, underscore (_), and full stop (.)</li>
          </ul>
        </p>
      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">Username:</label>
                <input type="text" name="username" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="username" value="<?php 
                  if($username !=="" AND $username_err =="") {
                    echo $username;
                  } else {
                    echo "";
                  }
                  ?>" onchange = "this.form.submit()">
                <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $username_err; ?></p>

      </div> 
      <h2>Password</h2>
      <p>Passwords must:
          <ul>
            <li>Have minimum 8 characters</li>
            <li>At least one uppercase letter</li>
            <li>At least one lowercase letter</li>
            <li>At least one number</li>
            <li>At least one special character</li>
          </ul>
        </p>
      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">Password:</label>
                <input type="password" name="password1" id="password1" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="Password" value="" onchange = "checkTwoPasswords()">


      </div> 
      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">Confirm Password:</label>
                <input type="password" name="password2" id="password2" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="Password" value="" onchange = "checkTwoPasswords()">
                <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $password_err; ?></p>

      </div> 
    
      <div class="form-group">
                <input type="submit" class=" bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" value="Sign Up!">
      </div>

      </form>
    

          
          <h1 class="font-mono text-xl bg-pink-300 pl-1"></h1>
          

        </div>
</div>


<script>

  function checkTwoPasswords() {
    let pass1 = document.getElementById("password1");
    let pass2 = document.getElementById("password2");
    let form = document.getElementById("inputForm");

    if((pass1.value !="")&&(pass2.value !="")) {

      form.submit();
    }


  }

  function submitForm() {
    let form = document.getElementById("inputForm");
    form.submit()
  }
</script>

<?php include "../footer_tailwind.php"; ?>



