<?php



//Commands which are common to all scripts:

  /*
  // Initialize the session
  session_start();

  $_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

  
  if (!isset($_SESSION['userid'])) {
    
    header("location: /login.php");
    
  }
  */

  date_default_timezone_set('Europe/London');

  //Define server path:
  $path2 = $_SERVER['DOCUMENT_ROOT'];
  $path2 .= "/../secrets/secrets.php";
  include($path2);

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
  }




?>