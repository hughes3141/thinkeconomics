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

      @media print
      {    
          .no-print, .no-print *
          {
              display: none !important;
          }
      }

      img {
        float: right;
        width: 50%;
      }
    </style>
  </head>
  <body>
    <div class="no-print">
      <h1 class="no-print">Print Friendly</h1>
      <p >
        <textarea id="input1" onchange="populateDocument();"></textarea>
        <textarea id="input2" onchange="populateDocument();"></textarea>
    </p>
    </div>

    <div id="generated" style="white-space: pre-line">

    </div>


	<script>
    var input1 =document.getElementById('input1');
    var input2 =document.getElementById('input2');
    var generated =document.getElementById('generated');

    function populateDocument() {
      generated.innerHTML="";
      //console.log(input1.value);
      var text = input1.value;
      var photos = input2.value
      var textArray = text.split("\n");
      var photoArray = photos.split(",");

      for(var x=0; x<textArray.length; x++) {
        if(textArray[x] == "") {
          textArray.splice(x,1);
          x--;
        }
      }

      
      console.log(textArray);
      console.log(photoArray);
      //generated.innerHTML = input1.value;

      for(var x=0; x<photoArray.length; x++) {
        var img = document.createElement("img");
        img.src = photoArray[x];
        generated.appendChild(img);
      }

      for(var x=0; x<textArray.length; x++) {
        if(x == 0) {

          var p = document.createElement("h1");
          const node = document.createTextNode(textArray[x]);
          p.appendChild(node);
        } else {
        var p = document.createElement("p");
        const node = document.createTextNode(textArray[x]);
        p.appendChild(node);
        }

        generated.appendChild(p);
        
      }



    }
  </script>
  </body>
</html>







