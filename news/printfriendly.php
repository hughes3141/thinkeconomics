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
    <link rel="stylesheet" href="">
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
        <p><a href="/">Home</a></p>
        <label>Aritle Text:</label><br>
        <textarea id="input1" onchange="populateDocument();"></textarea>
        <br><label>Images</label><br>
        <textarea id="input2" onchange="populateDocument();"></textarea>
        <label>Headings: </label>
        <input id="input3" style="width:90%" type="text" onchange="populateDocument();">
        <br><label>Img Order: </label>
        <input id="input4" style="width:90%" type="text" onchange="populateDocument();">
    </p>
    </div>

    <div id="generated" style="white-space: pre-line">

    </div>


	<script>
    var input1 =document.getElementById('input1');
    var input2 =document.getElementById('input2');
    var input3 =document.getElementById('input3');
    var generated =document.getElementById('generated');

    function populateDocument() {

      console.clear();

      generated.innerHTML="";
      //console.log(input1.value);
      var text = input1.value;
      var photos = input2.value
      var textArray = text.split("\n");
      var photoArray = photos.split(",");

      var headingsText = input3.value;

      var imageOrder = input4.value;
      var imageOrderArray = imageOrder.split(",");

      for(var x=0; x<imageOrderArray.length; x++) {
        imageOrderArray[x] = parseInt(imageOrderArray[x]);
      }

      var headings = headingsText.split(",");

      for(var x=0; x<textArray.length; x++) {
        if(textArray[x] == "") {
          textArray.splice(x,1);
          x--;
        }
      }
      if(headingsText== "") {
        for(var x=0; x<textArray.length; x++) {
          var heading = "";
          if(x == 0) {
            heading = 'h1';
          }
          else {
            heading = 'p';
          }
          
          headings[x]=heading;
        }
      }

      

      if(imageOrder == "") {
        for(var x=0; x<photoArray.length; x++) {
          imageOrderArray[x] = parseInt(x);
          console.log(imageOrderArray[x]);
        }
      }

      input3.value = headings.join();
      input4.value = imageOrderArray.join();

      
      console.log(headings);


      //console.log(textArray);
      console.log(photoArray);
      console.log(imageOrderArray)
      //generated.innerHTML = input1.value;
      /*

      for(var x=0; x<photoArray.length; x++) {
        var img = document.createElement("img");
        img.src = photoArray[x];
        generated.appendChild(img);
      }
      */

      for(var x=0; x<textArray.length; x++) {

        var p = document.createElement(headings[x]);
        const node = document.createTextNode(textArray[x]);
        p.appendChild(node);
        generated.appendChild(p);

        if(imageOrderArray.includes(x)) {
          //console.log("text"+x)
          for(var y=0; y<imageOrderArray.length; y++) {
            if(imageOrderArray[y]==x) {
              var img = document.createElement("img");
              img.src = photoArray[y];
              generated.appendChild(img);

            }
          }
        }
        
        
      }



    }
  </script>
  </body>
</html>







