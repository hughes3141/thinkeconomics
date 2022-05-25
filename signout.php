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

unset($_SESSION['userid']);
unset($_SESSION['name']);
unset($_SESSION['usertype']);
unset($_SESSION['groupid']);

header("location: ".$previous);