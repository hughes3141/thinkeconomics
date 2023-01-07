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
  if($name_validate ==1 AND $username_validate==1 AND $password_validate == 1 AND $email_validate == 1 AND $privacy_validate = 1 AND $usertype_validate == 1) {

    $permissions = "student";
    if($usertype == "teacher"){
      $permissions .= ", teacher";
    }

    //Enter new user information into users table
    insertNewUserIntoUsers($firstName, $lastName, $username, $password1, $usertype, $email_name, $version, $privacy_bool, $usertype, $permissions);

   

    //Send to a new page
    echo "<script>window.location = '/'</script>";
    unset($_SESSION['userid']);
    
  }


  

}

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
    <h1 class=" text-2xl bg-pink-400 pl-1">New User Registration</h1>
    <div class=" container mx-auto px-0 mt-2 bg-white text-black mb-5">



      <?php
      /*
        echo "<p>";
        print_r($_POST);
        echo "<p>";
        */
      ?>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="inputForm" autocomplete="off" >

      <div class="form-group pt-5">
                <label class ="/*text-gray-600*/ pb-1 ml-2 mb-2 pt-1">First Name:</label>
                <input type="text" name="firstName" class="border px-3 py-2  text-sm w-3/4 mb-2 font-mono " placeholder ="First Name" value="<?php echo ($firstName!=="")? $firstName : ""; ?>">

      </div>   
      <div class="form-group">
                <label class ="/*text-gray-600*/ pb-1 ml-2 mb-2 pt-1">Last Name:</label>
                <input type="text" name="lastName" class="border px-3 py-2  text-sm w-3/4 mb-2 " placeholder ="Last Name" value="<?php echo ($lastName!=="")? $lastName : ""; ?>">
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
                <label class ="/*text-gray-600*/ pb-1 ml-2 mb-2 pt-1">Username:</label>
                <input type="text" name="username" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="username" value="<?php 
                  if($username !=="" AND $username_err =="") {
                    echo $username;
                  } else {
                    echo "";
                  }
                  ?>" onchange = "//this.form.submit()">
                <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $username_err; ?></p>
                <p class="ml-3 mt-1 py-0 text-pink-400 border-sky-300"><?php echo $username_avail; ?></p>

      </div> 
      <h2>Password</h2>
      <p>Passwords must:
          <ul>
            <li>Have minimum 6 characters</li>
            <li>At least one uppercase letter</li>
            <li>At least one lowercase letter</li>
            <li>At least one number</li>

          </ul>
        </p>
      <div class="form-group">
                <label class ="/*text-gray-600*/ pb-1 ml-2 mb-2 pt-1">Password:</label>
                <input type="password" name="password1" id="password1" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="Password"  onchange = "//checkTwoPasswords()">


      </div> 
      <div class="form-group">
                <label class ="/*text-gray-600*/ pb-1 ml-2 mb-2 pt-1">Confirm Password:</label>
                <input type="password" name="password2" id="password2" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="Password"  onchange = "//checkTwoPasswords()">
                <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $password_err; ?></p>

                <?php //value="<?= (($password2 != "") AND $password_err ="") ? $password2 : "";?>

      </div> 
      <h2>email</h2>
      <div class="form-group">
                <label class ="/*text-gray-600*/ pb-1 ml-2 mb-2 pt-1">Email:</label>
                <input type="text" name="email" id="email" class="border px-3 py-2  text-sm w-3/4 mb-2" placeholder ="Email" value = "<?= $email_name !="" ? $email_name : "";?>">
                <p class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $email_err; ?></p>

      </div>
      <h2>User Type</h2>
      <div class="form-group">
      <p>I am interested in regigtering for this website as a:</p>
        <input type="radio" id="student_radio" name="user_type" value="student" checked>
        <label for="student_radio">Student</label><br>
        <input type="radio" id="teacher_radio" name="user_type" value="teacher" <?=(isset($_POST['user_type']) && $_POST['user_type']=="teacher") ? "checked" : ""?>>
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
</script>

<?php include "../footer_tailwind.php"; ?>



