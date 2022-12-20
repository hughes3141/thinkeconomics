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

//Very little file that only contains the vairabble $version to be ouput to database.
include ("privacy_version.php");


//$userId = $_SESSION['userid'];

$firstName = $lastName = $username= $email_name = $privacy_bool = $usertype = "";
$username_err = $username_avail = $password_err = $email_err = $name_err= $privacy_err = $usertype_err= "";
$name_validate = $username_validate = $password_vaidate = $email_validate = 0;
$fn_validate = $ln_validate = $user_avail_validate = $user_rule_validate = $pass_match_validate = $pass_rule_validate = $privacy_validate = $usertype_validate = 0;

//Processing form data when form is submitted
if($_SERVER['REQUEST_METHOD'] == "POST") {

  //First Name and Last Name
  //Check to see that first and last names are entered in
  if(empty(trim($_POST['firstName']))) {
    $name_err = "Please enter a name";
  } else {
    $firstName = trim($_POST['firstName']);
    $fn_validate = 1;
  }

  if(empty(trim($_POST['lastName']))) {
    $name_err = "Please enter a name";
  } else {
    $lastName = trim($_POST['lastName']);
    $ln_validate = 1;
  }

  if($fn_validate ==1 AND $ln_validate ==1) {
    $name_validate = 1;
  }

  //USERNAME  
  //Check if username is already taken
  if(empty(trim($_POST['username']))) {
    $username_err = "Please enter a username";
  } else {
    $username = trim($_POST['username']);

    //Prepare statement to check username:
    $sql = "SELECT LOWER(username) FROM users WHERE username = ?";
    if($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_username);
      
      //Set parameters
      $param_username = strtolower($username);
      if($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows>0) {
          $username_err = "<b>".$username."</b> is registered by another user. Please try another username.";
        } else {
          $username_avail = "Success! <b>".$username."</b> is available!";
          $user_avail_validate = 1;
        }
      }
    }
  }

  //Check to see that username fits rules:
  
  /*
  //$regexp = "^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$";

  From: https://stackoverflow.com/questions/12018245/regular-expression-to-validate-username
  //$regexp = "/^[a-zA-Z0-9](_(?!(\.|_))|\.(?!(_|\.))|[a-zA-Z0-9]){6,18}[a-zA-Z0-9]$";
  //The above means it's Only contains alphanumeric characters, underscore and dot, Underscore and dot can't be at the end or start of a username (e.g _username / username_ / .username / username.)., Underscore and dot can't be next to each other (e.g user_.name)., Underscore or dot can't be used multiple times in a row (e.g user__name / user..name)., Number of characters must be between 8 to 20.

  //Follows these rules: Must start with letter, 6-32 characters, Letters and numbers only
  //$regexp = "/^[A-Za-z][A-Za-z0-9]{5,31}$/";
  */
  $regexp = "/^[a-zA-Z0-9](_(?!(\.|_))|\.(?!(_|\.))|[a-zA-Z0-9]){4,18}[a-zA-Z0-9]$/";

  if($username != "") {
    if(!preg_match($regexp, $username)) {
      $username_err = "'<b>$username</b>' is invalid.";
      $username_avail = "";
    } else {
      $user_rule_validate = 1;
    }
  }

  if ($user_avail_validate ==1 and $user_rule_validate ==1) {
    $username_validate = 1;
  }


  //PASSWORD
  //Check to see if password meets criteria:
    if(empty(trim($_POST['password1'])) and empty(trim($_POST['password1']))) {
      $password_err = "Please enter a password";
    } else {
      $password1 = trim($_POST['password1']);
      $password2 = trim($_POST['password2']);

      if ($password1 != $password2) {
        $password_err = "Passwords to not match";
      }
      else {
        $pass_match_validate = 1;
        /*
        https://stackoverflow.com/questions/19605150/regex-for-password-must-contain-at-least-eight-characters-at-least-one-number-a

        Minimum eight characters, at least one uppercase letter, one lowercase letter and one number:
        "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$"
      
        Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character:
        "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
        
        Modified from previous two:  Minimum eight characters, at least one uppercase letter, one lowercase letter and one number, MAY CONTAIN SPECIAL CHARACTERS
        "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/"

        */
      $regexp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/";


        if(!preg_match($regexp, $password1)) {
          $password_err = "This password does not fit the criteria.";
        } else {
          $pass_rule_validate = 1;
        }
        
      }

    }
    if ($pass_match_validate ==1 and $pass_rule_validate==1) {
      $password_vaidate = 1;
    }

    //EMAIL
    //check to ensure valid email format:
      if(empty(trim($_POST['email']))) {
        $email_err = "Please enter an email address";
      } else {
        $email_name = trim($_POST['email']);

        if (!filter_var($email_name, FILTER_VALIDATE_EMAIL)) {
          $email_err = "<b>".$email_name."</b> is not a valid email address";
        } else {
            //Prepare statement to check email:
            $sql = "SELECT email FROM users WHERE email = ?";
            if($stmt = $conn->prepare($sql)) {
              $stmt->bind_param("s", $param_username);
              
              //Set parameters
              $param_username = $email_name;
              if($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows>0) {
                  $email_err = "This email address is already in use. Please try another.";
                } else {
                  $email_validate =1;
                }
              }
            }
        }
      }
    

    //User Type
    //check to make sure user_type has been selected
    
    if(empty($_POST['user_type'])) {
      $usertype_err = "Please select an option from above.";
    } else {
      $usertype_validate = 1;
      $usertype = $_POST['user_type'];
    }


    //Privacy Policy
    //check to make sure that privacy policy has been agreed
    if(empty($_POST['privacy_agree'])) {
      $privacy_err = "You must agree to the privacy policy before registering.";
    } else {
      $privacy_validate = 1;
      $privacy_bool = 1;
    }




  //PROCESS VALIDATED INFORMATION
  if($name_validate ==1 AND $username_validate==1 AND $password_vaidate == 1 AND $email_validate == 1 AND $privacy_validate = 1 AND $usertype_validate == 1) {

    //Enter new user information into users table
    $sql = "INSERT INTO users (name_first, name_last, username, password_hash, usertype, permissions, userInput_userType, email, active, time_added, privacy_agree, privacy_date, privacy_vers) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    
    $stmt = $conn->prepare($sql);
    
    $password_hash = password_hash($password1, PASSWORD_DEFAULT);
    $usertype_std =$permissions = "student";
    $active = 1;
    $datetime = date("Y-m-d H:i:s");

    $stmt->bind_param("ssssssssisiss", $firstName, $lastName, $username, $password_hash, $usertype_std, $permissions, $usertype, $email_name, $active, $datetime, $privacy_bool, $datetime, $version);
    $stmt->execute();


    //Send to a new page
    echo "<script>window.location = '/'</script>";
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
                <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $name_err; ?></p>
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
                <p class="ml-3 mt-1 py-0 text-pink-400 border-sky-300"><?php echo $username_avail; ?></p>

      </div> 
      <h2>Password</h2>
      <p>Passwords must:
          <ul>
            <li>Have minimum 8 characters</li>
            <li>At least one uppercase letter</li>
            <li>At least one lowercase letter</li>
            <li>At least one number</li>

          </ul>
        </p>
      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">Password:</label>
                <input type="password" name="password1" id="password1" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="Password"  onchange = "//checkTwoPasswords()">


      </div> 
      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">Confirm Password:</label>
                <input type="password" name="password2" id="password2" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="Password"  onchange = "//checkTwoPasswords()">
                <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $password_err; ?></p>

                <?php //value="<?= (($password2 != "") AND $password_err ="") ? $password2 : "";?>

      </div> 
      <h2>email</h2>
      <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">Email:</label>
                <input type="text" name="email" id="email" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="Email" value = "<?= $email_name !="" ? $email_name : "";?>">
                <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $email_err; ?></p>

      </div>
      <h2>User Type</h2>
      <div class="form-group">
      <p>I am interested in regigtering for this website as a:</p>
        <input type="radio" id="student_radio" name="user_type" value="student" checked>
        <label for="student_radio">Student</label><br>
        <input type="radio" id="teacher_radio" name="user_type" value="teacher" <?=($_POST['user_type']=="teacher") ? "checked" : ""?>>
        <label for="teacher_radio">Teacher</label>
        <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $usertype_err; ?></p>
      </div>


      <h2>Privacy Policy</h2>
      <div class="form-group">
        <input type="checkbox" id="privacy_checkbox" name="privacy_agree" value="1" <?php
        if(isset($_POST['privacy_agree'])) {
          echo "checked";
        }
        ?>
        >
        <label for="privacy_checkbox">I agree to this website's <a>privacy policy</a></label>
        <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $privacy_err; ?></p>
      </div>
    
      <div class="form-group">
                <input type="submit" class=" bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" value="Sign Up!">

      </div>

      </form>
    

          <h1 class="font-mono text-xl bg-pink-300 pl-1"></h1>
          

        </div>
</div>

<?//= $name_validate."||".$username_validate."||".$password_vaidate."||".$email_validate; ?>



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



