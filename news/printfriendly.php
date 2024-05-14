<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $permissions = $userInfo['permissions'];
  if (!(str_contains($permissions, 'main_admin'))) {
    header("location: /");
  }

}

$style_input = "";



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Friendly</title>
    <link rel="stylesheet" href="style.css">
    <style>
      textarea {
        width: 90%;
      }
    </style>
  </head>
  <body>
    <h1>Print Friendly</h1>
    <p>
      <textarea id="input1" onchange="populateDocument();"></textarea>
    </p>

    <div id="generated" style="white-space: pre-line">

    </div>


	<script>
    var input1 =document.getElementById('input1');
    var generated =document.getElementById('generated');

    function populateDocument() {
      generated.innerHTML="";
      //console.log(input1.value);
      var text = input1.value;
      var textArray = text.split("\n");
      console.log(textArray);
      //generated.innerHTML = input1.value;

      for(var x=0; x<textArray.length; x++) {
        var p = document.createElement("p");
        const node = document.createTextNode(textArray[x]);
        p.appendChild(node);
        generated.appendChild(p);
      }

    }
  </script>
  </body>
</html>







