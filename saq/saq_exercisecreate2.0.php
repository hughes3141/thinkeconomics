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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if($_POST['submitComps'] =="Submit") {
    $count = $_POST['count'];
    $count = intval($count);

    $componentsArray = array();
    
    
    for($x=0; $x<$count; $x++) {
      array_push($componentsArray, array($_POST['input_'.$x.'_0'], $_POST['input_'.$x.'_1']));

    }

    //print_r($componentsArray);
    

    $componentsArray = json_encode($componentsArray);
    //echo $componentsArray;

    $datetime = date("Y-m-d H:i:s");


    $sql="INSERT INTO saq_exercises (exerciseName, topic, structure, notes, dateCreated, userCreate) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sssssi", $_POST['quizName'], $_POST['topic'], $componentsArray, $_POST['notes'], $datetime, $_SESSION['userid']);


    if($_POST['quizName'] != "") {
      $stmt->execute();
      
      echo "New records created successfully";
    }

    else {
      echo "Name of exercise needed";
    }
      
      
      
    

    
    

  }
}

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

      td, th {
        border: solid 1px black;
        padding: 3px;
      }
      table {
        border-collapse: collapse;
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

    <?php
      if(!isset($_GET['limit'])) {
        $limit = 10;
      } else {
        $limit = $_GET['limit'];
      }
    
    ?>
    
    <form method="post">
    <p>
      <label for="quizName">SAQ Exercise Name</label>
      <input type="text" id="quizName" name="quizName">

      <label for="topic">Topic</label>
      <input type="text" id="topic" name="topic">

   
      <label for="notes">Notes</label>
      <input type="text" id="notes" name="notes">
    </p>
    <div id="componentDiv">
    </div>
    <input type="hidden" name="count" id="inputCount">
    <input type="submit" name="submitComps" value="Submit">
    </form>


    <h2>Exercise List</h2>
    <form method ="get" action="">
      <label for = "limit_pick">Limit: </label>
      <input type="number" id="limit_pick" min = "0" name="limit" value="<?=$limit?>">
      <input type="submit" value="Change Limit">
    </form>
    <br>
    <table>
      <tr>
        <th>id</th>
        <th>Topic</th>
        <th>Exercise Name</th>
        <th>Structure</th>
        <th>Notes</th>
        <th>Date Created</th>
        <th>Edit</th>
      </tr>
      <?php

      $sql = "SELECT * FROM saq_exercises ORDER BY dateCreated desc LIMIT ?";


      if(isset($_GET['limit'])) {
        $_GET['limit']= intval($_GET['limit']);
        //var_dump($_GET['limit']);

          $limit = $_GET['limit'];
        
      }



      $stmt=$conn->prepare($sql);
      $stmt->bind_param("i", $limit);
      $stmt->execute();
      $result= $stmt->get_result();

      if ($result->num_rows>0) {
        
        while ($row = $result->fetch_assoc()) {
          
          ?>
            <tr>
              <td><?=htmlspecialchars($row['id']);?></td>
              <td><?=htmlspecialchars($row['topic']);?></td>
              <td><?=htmlspecialchars($row['exerciseName']);?></td>
              <td><?php
              $structure = json_decode($row['structure']);
                //print_r($structure);
                foreach($structure as $value) {
                  echo htmlspecialchars($value[0]).": ".htmlspecialchars($value[1])."<br>";
                }
                //htmlspecialchars($row['structure']);
                  ?></td>
              <td><?=htmlspecialchars($row['notes']);?></td>
              <td><?=htmlspecialchars($row['dateCreated']);?></td>
            </tr>


        <?php
        }

      }


      ?>
    </table>

    
    
    
    <script>

      index = 0;
      var inputCount;

      function reOrder() {
        var componentDiv = document.getElementById("componentDiv");
        var subDivs = componentDiv.getElementsByTagName("div");
        for(var i=0; i<subDivs.length; i++) {
          subDivs[i].id="control_div_"+i;
          var input = subDivs[i].getElementsByTagName("input");
          for(var j=0; j<input.length; j++) {
            input[j].name = "input_"+i+"_"+j;
          }
        }

        inputCount = i;
        console.log(inputCount);

        var inputCountInput = document.getElementById("inputCount");
        inputCountInput.value = inputCount;

        
        

      }

      function componentControlDiv(input) {
        var div = document.createElement('div');
        div.classList.add("controlDiv");
        //div.id="control_div_"+index;
        index ++;

        var typeLabel = document.createElement('p');
        typeLabel.innerHTML = input;

        
        var input2 = document.createElement('input');
        //input2.type="hidden";
        input2.value=input;
        var input1 = document.createElement('input');
        input1.type = "text";

        

        var removeButton = document.createElement('button');
        removeButton.innerHTML = "Remove";
        removeButton.type = "button";
        removeButton.setAttribute("onclick", "removeButton(this.parentElement)");

        //div.appendChild(typeLabel);
        div.appendChild(input2);
        div.appendChild(input1);
        div.appendChild(removeButton);
        

        return div;

      }


      function addComponent() {
        var compType = document.getElementById("selectDrop").value;
        //console.log(compType);
        var component = document.createElement(compType);
        component.innerHTML = compType;
        var parentDiv = document.getElementById("componentDiv");
        //parentDiv.appendChild(component);

        var div = componentControlDiv(compType);
        parentDiv.appendChild(div);
        reOrder();


      }
      

      function removeButton(input)  {
        //console.log(input);
        //var div = document.getElementById(input);
        //div.remove();
        input.remove();
        reOrder();
        
        

      }

      
    </script>
    
  </body>
</html>
