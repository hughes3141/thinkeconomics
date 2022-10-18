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
  $userType = $userInfo['usertype'];
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
}

print_r($_POST);  


?>



<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">

    <style>
      .controlDiv {
        border: 1px solid black;
      }
    </style>
  </head>
  <body>
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    

    <form>
      <label for="selectDrop">Component Type:</label>
        <select id="selectDrop">
          <option value="qs">Questions</option>
          <option value ="h1">H1</option>
          <option value ="h2">H2</option>
          <option value ="h3">H3</option>
          <option value ="p">Paragraph</option>
          <option value ="img">Image</option>
          <option value ="a">Link</option>
        </select>
        <button type ="button" onclick="addComponent()">Add Component</button>
    </form>

    <div id="componentDiv">
    </div>

    
    <form method="post" action="" style="display:none">
          <p>
            <label for="quizName">SAQ Exercise Name</label>
            <input type="text" id="quizName" name="quizName">
          </p>
            <p>
              <label for="c_type_1">Component 1 Type:</label>
              <input type="text" id="c_type_1" name="c_type_1">
              <label for="c_data_1">Component 1 Data:</label>
              <input type="text" id="c_data_1" name="c_data_1">
            </p>
            <p>
              <label for="c_type_2">Component 2 Type:</label>
              <input type="text" id="c_type_2" name="c_type_2">
              <label for="c_data_2">Component 2 Data:</label>
              <input type="text" id="c_data_1" name="c_data_2">
            </p>
            <p>
            <label for="c_type_3">Component 3 Type:</label>
            <input type="text" id="c_type_3" name="c_type_3">
            <label for="c_data_3">Component 3 Data:</label>
            <input type="text" id="c_data_2" name="c_data_3">
            </p>
            <p>
            <label for="notes">Notes</label>
            <input type="text" id="notes" name="notes">
          </p>
          <p>
            <input type="submit" name="submit" value="Create Exercise">
          </p>
    </form>
    
    <script>

      index = 0;

      function reOrder() {
        var componentDiv = document.getElementById("componentDiv");
        var subDivs = componentDiv.getElementsByTagName("div");
        for(var i=0; i<subDivs.length; i++) {
          subDivs[i].id="control_div_"+i;
        }
        

      }

      function componentControlDiv(input) {
        var div = document.createElement('div');
        div.classList.add("controlDiv");
        //div.id="control_div_"+index;
        index ++;

        var typeLabel = document.createElement('p');
        typeLabel.innerHTML = input;

        var input = document.createElement('input');
        input.type = "text";

        var removeButton = document.createElement('button');
        removeButton.innerHTML = "Remove";
        removeButton.type = "button";
        removeButton.setAttribute("onclick", "removeButton(this.parentElement)");

        div.appendChild(typeLabel);
        div.appendChild(input);
        div.appendChild(removeButton);
        

        return div;

      }


      function addComponent() {
        var compType = document.getElementById("selectDrop").value;
        console.log(compType);
        var component = document.createElement(compType);
        component.innerHTML = compType;
        var parentDiv = document.getElementById("componentDiv");
        //parentDiv.appendChild(component);

        var div = componentControlDiv(compType);
        parentDiv.appendChild(div);
        reOrder();


      }
      

      function removeButton(input)  {
        console.log(input);
        //var div = document.getElementById(input);
        //div.remove();
        input.remove();
        reOrder();
        
        

      }

      
    </script>
    
  </body>
</html>
