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
$name_validate = $username_validate = $password_validate = $email_validate = 0;
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

  $results = validateUsername($_POST['username']);
  $username_err = $results['username_err'];
  $username_avail = $results['username_avail'];
  $username_validate = $results['username_validate'];
  $username = $results['username'];


  //PASSWORD

  $results = validatePassword($_POST['password1'], $_POST['password2']);
  $password_err = $results['password_err'];
  $password_validate = $results['password_validate'];
  $password1 = $results['password'];




  //EMAIL

  $results=validateEmail($_POST['email']);
  $email_err = $results['email_err'];
  $email_validate = $results['email_validate'];
  $email_name = $results['email'];

    

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
  if($name_validate ==1 AND $username_validate==1 AND $password_validate == 1 AND $email_validate == 1 AND $privacy_validate == 1 AND $usertype_validate == 1) {

    $permissions = "student";
    if($usertype == "teacher"){
      $permissions .= ", teacher";
    }

    //Enter new user information into users table.
    //Store newly-minted 'username' and 'time_added' to $entry array, which is ['username'=> , 'datetime'=> ]

    $entry = insertNewUserIntoUsers($firstName, $lastName, $username, $password1, $usertype, $email_name, $version, $privacy_bool, $usertype, $permissions);

    //Set session userid to newly-minted userid:
    $userid = getUserByUsernameDatetime($entry);
    $_SESSION['userid'] = $userid;

    //Register login at login_log table:
    login_log($userid);


    //Send to a new page
    echo "<script>window.location = '/user/user3.0.php'</script>";
    //unset($_SESSION['userid']);
    
  }


  

}

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">New User Registration</h1>
    <div class=" container mx-auto mt-2 bg-white text-black mb-5 p-4">



      <?php
      /*
        echo "<p>";
        print_r($_POST);
        echo "<p>";
      */
 
      ?>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="inputForm" autocomplete="off" >
      <div class="md:flex /*space-y-5*/ md:space-y-0 md:space-x-4">
        <div class="form-group w-full">
                  <label for = "firstName" class ="/*text-gray-600*/ pb-1  pt-1">First Name:</label>
                  <div class="mt-1.5">
                    <input type="text" name="firstName" id="firstName" class="border px-3 py-2  text-sm w-full mb-2  rounded" placeholder ="First Name" value="<?php echo ($firstName!=="")? $firstName : ""; ?>" onchange="usernameSuggest();">
                  </div>
        </div>   
        <div class="form-group w-full">
                  <label for="lastName" class ="/*text-gray-600*/ pb-1 pt-1">Last Name:</label>
                  <div class="mt-1.5">
                    <input type="text" name="lastName" id="lastName" class="border px-3 py-2  text-sm w-full mb-2 rounded" placeholder ="Last Name" value="<?php echo ($lastName!=="")? $lastName : ""; ?>" onchange="usernameSuggest();">
                  </div>
        </div>
      </div>
      <div>
        <p class=" mt-1 pl-1 text-red-600 bg-lime-300 rounded"><?php echo $name_err; ?></p>
      </div>

      <div class="form-group w-full">
          <label for="userName" class ="/*text-gray-600*/ pb-1 mb-2 pt-1">Username:</label>
          <div class="mt-1.5">
            <input type="text" id="userName" name="username" class="border px-3 py-2  text-sm w-full mb-2 rounded" placeholder ="username" value="<?php 
              if($username !=="" AND $username_err =="") {
                echo $username;
              } else {
                echo "";
              }
              ?>" onchange = "//this.form.submit()">
            <p class=" mt-1 pl-1 text-red-600 bg-lime-300 rounded"><?php echo $username_err; ?></p>
            <p class=" mt-1 pl-1 text-pink-400 border-sky-300 rounded"><?php echo $username_avail; ?></p>
          </div>

      </div> 
        <p>A username is unique to your account. It must be:
          <ul class="list-disc list-oustide">
            <li class="ml-6">Between 6 and 20 characters.</li>
            <li class="ml-6">Begin with a letter</li>
            <li class="ml-6">Contain only letters, numbers, underscore (_), and full stop (.)</li>
          </ul>
        </p>


      <div class="form-group w-full">
                <label for = "password1" class ="/*text-gray-600*/ pb-1 mb-2 pt-1">Password:</label>
                <div class="mt-1.5">
                  <input type="password" name="password1" id="password1" class="border px-3 py-2  text-sm w-full mb-2 rounded" placeholder ="Password"  onchange = "validatePassword();">
                </div>


      </div> 
      <div class="form-group w-full">
                <label for ="password2" class ="/*text-gray-600*/ pb-1 mb-2 pt-1">Confirm Password:</label>
                <div>
                  <input type="password" name="password2" id="password2" class="border px-3 py-2  text-sm w-full mb-2 rounded" placeholder ="Password"  onchange = "validatePassword();">
                </div>


                <?php //value="<?= (($password2 != "") AND $password_err ="") ? $password2 : "";?>

      </div> 
      <p id="internalPasswordMessage1" class="hidden mt-1 pl-1 rounded"></p>
      <p id="internalPasswordMessage" class=" mt-1 py-0 pl-1 text-red-600 bg-lime-300 rounded"><?php echo $password_err; ?></p>
      <p>Passwords must:
          <ul class="list-disc list-oustide">
            <li class="ml-6">Have minimum 6 characters</li>
            <li class="ml-6">At least one uppercase letter</li>
            <li class="ml-6">At least one lowercase letter</li>
            <li class="ml-6">At least one number</li>

          </ul>
        </p>


      <div class="form-group w-full">
                <label class ="/*text-gray-600*/ pb-1  mb-2 pt-1">Email:</label>
                <div>
                  <input type="text" name="email" id="email" class="border px-3 py-2  text-sm w-full mb-2 rounded" placeholder ="Email" value = "<?= $email_name !="" ? $email_name : "";?>">
                </div>
                <p class="pl-1 mt-1 py-0 text-red-600 bg-lime-300 rounded"><?php echo $email_err; ?></p>

      </div>

      <div class="form-group">
      <p>I am interested in registering for this website as a:</p>
        <select class="w-full rounded" name="user_type">
          <option value= "student" <?=(isset($_POST['user_type']) && $_POST['user_type']=="student") ? "selected" : ""?> >Student</option>
          <option value= "teacher" <?=(isset($_POST['user_type']) && $_POST['user_type']=="teacher") ? "selected" : ""?> >Teacher</option>
        </select>
        
        <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300 rounded"><?php echo $usertype_err; ?></p>
      </div>


      <h2>Privacy Policy</h2>
      <div class="form-group">
        <input type="checkbox" id="privacy_checkbox" name="privacy_agree" value="1" <?php
        if(isset($_POST['privacy_agree'])) {
          echo "checked";
        }
        ?>
        >
        <label for="privacy_checkbox">I agree to this website's <a href="privacy_policy.php" target="_blank" class="hover:bg-sky-100 underline">privacy policy</a></label>
        <p class="pl-1 mt-1 py-0 text-red-600 bg-lime-300 rounded"><?php echo $privacy_err; ?></p>
      </div>
    
      <div class="form-group">
                <input type="submit" class="mt-3 rounded bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" value="Sign Up!">

      </div>

      </form>
    

          <h1 class="font-mono text-xl bg-pink-300 pl-1"></h1>
          

        </div>
</div>

<?//= $name_validate."||".$username_validate."||".$password_validate."||".$email_validate; ?>



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

  function usernameSuggest(inputElement) {
    

    var firstName = document.getElementById('firstName');
    var lastName = document.getElementById('lastName');
    var username = document.getElementById('userName');

    if((firstName.value != "") && (lastName.value != "")) {

      var suggest;
      //suggest = firstName.value.toLowerCase().replace(/\s|'/g, "").substring(0,1)+lastName.value.toLowerCase().replace(/\s|'/g, "").replace(/-/g, '_').substring(0,5);
      suggest = firstName.value.toLowerCase().replace(/[^a-zA-Z0-9]/g, '').substring(0,1);
      suggest += lastName.value.toLowerCase().replace(/[^a-zA-Z0-9]/g, '').substring(0,5);
      suggest = suggest.substring(0,16);
      suggest = suggest+(Math.floor(Math.random() * 90 + 10));
      
      username.value = suggest;
    }
  }

  function validatePassword() {
    var password1 = document.getElementById("password1").value;
    var password2 = document.getElementById("password2").value;
    var message = document.getElementById("internalPasswordMessage");
    
    //console.log(password1, password2);
    
    if((password1 != "") && (password2 != "")) {
      message.classList.remove('hidden');
      if( password1 != password2) {
        message.classList.add('text-red-600', 'bg-lime-300');
        message.classList.remove('text-pink-400');
        message.innerHTML="Passwords to not match";
      }
      else {
        let pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/;

        if(pattern.test(password1)) {
          message.innerHTML="Password fits criteria!";
          message.classList.add('text-pink-400');
          message.classList.remove('bg-lime-300', 'text-red-600');
        } else {
          
          message.innerHTML="Password doesn't fit criteria!";
          message.classList.add('text-red-600', 'bg-lime-300');
        }
      }


    } else if( (password1 == "") && (password2 == "")) {
      message.innerHTML="";
    }

  }
</script>

<?php include "../footer_tailwind.php"; ?>



