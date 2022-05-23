<?php
// Initialize the session
session_start();

// Define which page redirected to here

//Storing previous URLs to ensure that we can redirect to page where we cane from

//Define variables for previous page and current page
$previous = "";
$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//Set variables for last 2 URLS; test to ensure that the second URL is not the current URL.
//$_SESSION['2last_url'] = isset($_SESSION['last_url']) ? $_SESSION['last_url'] : null;
if(isset($_SESSION['last_url'])) {
  if ($_SESSION['last_url']!=$current_url) {
    $_SESSION['2last_url'] = $_SESSION['last_url'];
  } 
} else {
  $_SESSION['2last_url'] = null;
}
$_SESSION['last_url'] = $_SERVER['HTTP_REFERER'];


//Set $previous variable to reflect the most recent url that is not the current one.
if(isset($_SERVER['HTTP_REFERER'])) {
  if($_SESSION['last_url']===$current_url) {
    $previous = $_SESSION['2last_url'];
  } else {
    $previous = $_SESSION['last_url'];
  }
}


echo $current_url;
echo "<br>";

echo $previous;
echo "<br>";



 
// Check if the user is already logged in
if(isset($_SESSION["userid"])){
    //header("location: index.php");
    print_r($_SESSION);
    //exit;
}
 
//Include login information from secrets:

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/../secrets/secrets.php";
include($path);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
 
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
        $sql = "SELECT id, name, password FROM users WHERE name = ?";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(($password2 === $hashed_password)){
                        //!!Replace previous line with following line once hashed passwords are incorporated into database.
                        //if(password_verify($password2, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            //$_SESSION["loggedin"] = true;
                            //$_SESSION["id"] = $id;
                            //$_SESSION["username"] = $username;                            
                            $_SESSION["userid"] = $id;

                            // Redirect user to previous page
                            header("location: ".$previous);
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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo ($username!=="")? $username : $_SESSION['name']; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>