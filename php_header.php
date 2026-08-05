<?php



//Commands which are common to all scripts:

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

  //Login gate: every page is protected by default. A page opts out by
  //setting $publicPage = true; before including this file (e.g. login.php).
  if (empty($publicPage) && !isset($_SESSION['userid'])) {

    header("location: /login.php");
    exit;
  }

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