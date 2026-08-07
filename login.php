<?php

// Initialize the session
session_start();




// Define which page redirected to here
//Storing previous URLs to ensure that we can redirect to page where we cane from

if($_SESSION['this_url'] != $_SERVER['REQUEST_URI']) {
  $_SESSION['last_url'] = $_SESSION['this_url'];
  $_SESSION['this_url'] = $_SERVER['REQUEST_URI'];
}



$previous = "";
if($_SESSION['last_url']) {
  $previous = $_SESSION['last_url'];
}

//The login form posts back to itself, so "last_url" can end up being login.php
//itself (e.g. login.php?activated=1) rather than a genuine previous page -
//redirecting back to the login page after logging in is never useful.
if(strpos($previous, '/login.php') === 0) {
  $previous = "";
}



 
// Check if the user is already logged in
if(isset($_SESSION["userid"])){
    //header("location: index.php");
    //print_r($_SESSION);
    //exit;
}


$publicPage = true;
$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

// Define variables and initialize with empty values
$username = $password2 = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password2 = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, name, password_hash, privacy_agree FROM users WHERE (name = ? OR username = ? OR email = ?) AND active = 1";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_username, $param_username, $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password, $privacy_agree);
                    if($stmt->fetch()){

                        //if(($password2 === $hashed_password)){
                        //!!Replace previous line with following line once hashed passwords are incorporated into database.
                        if(password_verify($password2, $hashed_password)){
                            // Password is correct, so start a new session
                            //session_start();

                            //Check to see if privacy agreement has been agreed:

                              if($privacy_agree == 0) {
                                /*
                                $_SESSION['temp_userid'] = $id;
                                echo "<script>window.location='/user/privacy_policy.php?login_redirect'</script>";
                                exit();
                                */
                              }
                              
                            
                            // Store data in session variables
                            //$_SESSION["loggedin"] = true;
                            //$_SESSION["id"] = $id;
                            //$_SESSION["username"] = $username;                            
                            $_SESSION["userid"] = $id;
                            //$_SESSION["name"] = $username;
                            //$_SESSION["usertype"] = $usertype;
                            //$_SESSION["groupid"] = $groupid;

                            //Register login at login_log table:
                            login_log($id);

                            // Redirect user to previous page
                            if(($previous !="")&&($previous !="/")) {
                              header("location: ".$previous);
                            } else if ($previous == "/") {
                              header("location: ./user/user3.0.php");
                            } else {
                              header("location: index.php");
                            }
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
}
?>
 
 <?php include "header_tailwind.php"; ?>
 <div class="container mx-auto px-4 mt-20 lg:w-1/2">
<body>
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">User Login</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">

        <p class="px-3 py-2 hidden">Please fill in your credentials to login.</p>

        <?php if (isset($_GET['activated'])) { ?>
          <p class="ml-3 mt-1 py-2 text-green-700 bg-lime-100 rounded">Your account has been activated successfully. Please log in below.</p>
        <?php } ?>

        <?php if (isset($_GET['password_changed'])) { ?>
          <p class="ml-3 mt-1 py-2 text-green-700 bg-lime-100 rounded">Your password has been changed successfully. Please log in with your new password.</p>
        <?php } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">username/email:</label>
                <input type="text" name="username" class="border px-3 py-2  text-sm w-full" placeholder =Name value="<?php echo ($username!=="")? $username : ""; ?>">
                <span class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label class ="text-gray-600 pb-1 ml-2 mb-2 pt-1">Password</label>
                <input type="password" name="password" class="border px-3 py-2  text-sm w-full" placeholder =Password>
                <span class="ml-3 mt-1 py-0 text-red-600 bg-lime-300"><?php echo $password_err; ?></span>
                <p class="ml-3 mt-1"><a href="/user/forgot_password.php" class="underline hover:bg-sky-100">Forgot password?</a></p>
            </div>
            <div class="form-group">

              <?php 
                if(!empty($login_err)){
                  echo '<span class="ml-3 mt-1 py-0 text-red-600 bg-lime-300">'.$login_err.'</span>';
                }
              ?>
            </div>
            <div class="form-group">
                <input type="submit" class=" bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" value="Login">
            </div>
            <p class="ml-3 mt-3">Don't have an account? <a href="/user/newuser.php" class="underline hover:bg-sky-100">Sign up now</a>.</p>
        </form>
    </div>


  <?php include "footer_tailwind.php";?>
</body>
</div>
</html>
