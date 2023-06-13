<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");

session_start();

/*
This is nde_assign_create1.1.php

4 march 2022: Generated from 1.0 to change component input to allow for other types e.g. text vs nubmer.

*/


?>

<!DOCTYPE html>

<html lang="en">

<head>

<?php include '../header.php'; ?>

<?php 


// Using OOP:



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}





?>

<style>

th, td {

border: 1px solid black;
padding: 5px;

}

table {
	
	border-collapse: collapse;
	
}


</style>

</head>

<body>

<?php include '../navbar.php';?>

<?php 

//print_r($_POST);

if (isset($_SESSION['userid'])==false) {

  $_SESSION['name'] = $_POST['name'];
  $_SESSION['userid'] = $_POST['userid'];
  $_SESSION['usertype'] = $_POST['usertype'];
  $_SESSION['groupid'] = $_POST['groupid'];

}

//print_r($_SESSION);

?>

<h1>Non-Digital Entry: Create Exercise</h1>

<?php 

if (isset($_SESSION['userid'])==false) {
  
  ?>
    
  <div id = 'logindiv'>
  <h2>User Login:</h2>


  <?php include "../login_embed_envelope.php"; ?>
    


  </div>
  
  <?php
  
} else {
  echo "<p>Logged in as ".$_SESSION['name']."</p>";
}


if (isset($_SESSION['userid'])) {

  ?>

  <p>Use this form to create an exercise that will be entered non-digitally. You can use this form to create an exercise which can be assigned, then have scores entered manually.</p>



  <form method="post">

  <label for="exercise_name">Exercise Name:</label><br>
  <input type="text" id="exercise_name" name="exercise_name" required><br>

  <label for="description">Description:</label><br>
  <textarea id="description" name="description"></textarea><br>

  <label for="instructions">Instructions for students:</label><br>
  <textarea id="instructions" name="instructions"></textarea><br>


  <label for="type">Exercise Type:</label><br>
  <select type="text" id="type" name="type">
    <option selected></option>
    <option value = "Homework">Homework</option>
    <option value = "Quiz">Quiz</option>
    <option value = "Test">Test</option>
    <option value = "Termly Review">Termly Review</option>
  </select><br>

  <label for="topic">Topic:</label><br>
  <input type="text" id="topic" name="topic"><br>

  <label for="notes">Notes:</label><br>
  <input type="text" id="notes" name="notes"><br>
  <br>
  <div id="link_input">
  </div>
  <button type="button" onclick="addLink()">Add new link</button>
  <input type="hidden" id="linkCountInput" name = "link_count">

  <table id="component_input_table">
      <tr>
        <th>Component</th>
        <th>Description</th>
        <th>Points</th>
        <th>Skills</th>
       
      
      </tr>
  </table><br>
  <button type="button" onclick="addRow()">Add Row (Number Component)</button>
  <button type="button" onclick="addRowText()">Add Row (Text Component)</button>
  <button type="button" onclick="dropRow()">Remove Last Row</button>
  <br>


  <input type="hidden" name="questionsCount" id="questionsCount">

  <p>
  <input type="submit" name="submit" value="Create Exercise"></input>
  </p>
  </form>

  

  

  <?php 
  
  }

//print_r($_POST);


$stmt = $conn->prepare("INSERT INTO nde_exercises (exerciseName, description, instructions, components, type, topic, notes, link, dateCreated, userCreate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssssssi", $exerciseName, $description, $instructions, $components, $type, $topic, $notes, $link, $dateCreated, $userCreate);

if (isset($_POST['submit'])) {
  
  $exerciseName = $_POST['exercise_name'];
  $description = $_POST['description'];
  $instructions = $_POST['instructions'];
  
  $type = $_POST['type'];
  //$topic = $_POST['topic'];
  
  $topic = json_encode(explode(",", $_POST['topic']));

  $notes = $_POST['notes'];
  //$link = $_POST['link'];
  $dateCreated = date("Y-m-d H:i:s");
  $userCreate = $_SESSION['userid'];
  
  $count = $_POST['questionsCount'];
  
  $link = array();

  /*
  $link becomes a json encoded array with:
  -Number of elements = number of links defined
  -Each compoenent has array of link, description.
  */

  $linkCount = $_POST['link_count'];

  for($x=0; $x<$linkCount; $x++) {
    $link2 = array();
    array_push($link2, $_POST['link_'.$x]);
    array_push($link2, $_POST['link_desc'.$x]);
    array_push($link, $link2);
  }

  //print_r($link);

  $link = json_encode($link);

  
  $components_array = array();
  
  /*
  $components becomes a json encoded array with
  -Number of elements = number of components
  -Each component has array of description, points, and skills
  
  */
  
  for($x=0; $x<$count; $x++) {
     $components_array2 = array();
     /*
     $components_array2['description'] = $_POST['comp_description_'.$x];
     $components_array2['points'] = $_POST['comp_points_'.$x];
     $components_array2['skills'] = $_POST['comp_skills_'.$x];

     
     $components_array['Component '.($x+1)] = $components_array2;
     */
     
     
     
     array_push($components_array2, $_POST['comp_description_'.$x]);
     //array_push($components_array2, $_POST['comp_type_'.$x]);
     array_push($components_array2, $_POST['comp_points_'.$x]);
     array_push($components_array2, $_POST['comp_skills_'.$x]);
     
     array_push($components_array, $components_array2);
     
  }
  
  //print_r($components_array);
  
  $components = json_encode($components_array);


  
  $stmt->execute();

    
  echo "New records created successfully";
  
  $stmt->close();
  $conn->close();
}



?>

<?php include "../footer.php";?>
</body>

<script>
var linkCount = 0
//addRow();
addLink();

function addRow() {
  
  var table = document.getElementById("component_input_table");
  var tableLength = table.rows.length;
  var row = table.insertRow(tableLength);

  var cell0 = row.insertCell(0);
  var cell1 = row.insertCell(1);
  var cell2 = row.insertCell(2);
  var cell3 = row.insertCell(3);
  
  cell0.innerHTML = tableLength;
  
  var inst = tableLength -1;

  
  cell1.innerHTML = '<label for="comp_description_'+inst+'"></label><textarea type="text" id ="comp_description_'+inst+'" name="comp_description_'+inst+'" required></textarea>';
  cell2.innerHTML = '<label for="comp_points_'+inst+'"></label><input type="number" id ="comp_points_'+inst+'" name="comp_points_'+inst+'" required></input>';
  cell3.innerHTML = '<label for="comp_skills_'+inst+'"></label><input type="text" id ="comp_skills_'+inst+'" name="comp_skills_'+inst+'"></input>';

  var component_type_label = document.createElement("input");
  //component_type_label.setAttribute("type", "hidden");
  component_type_label.setAttribute("value", "number");
  component_type_label.setAttribute("name", "comp_type_"+inst);
  //cell1.appendChild(component_type_label);

  
  document.getElementById("questionsCount").value = tableLength;
}

function addRowText() {
  var table = document.getElementById("component_input_table");
  var tableLength = table.rows.length;
  var row = table.insertRow(tableLength);

  var cell0 = row.insertCell(0);
  var cell1 = row.insertCell(1);
  var cell2 = row.insertCell(2);
  var cell3 = row.insertCell(3);
  
  cell0.innerHTML = tableLength;
  
  var inst = tableLength -1;

  cell1.innerHTML = '<label for="comp_description_'+inst+'"></label><textarea type="text" id ="comp_description_'+inst+'" name="comp_description_'+inst+'" required></textarea>';
  /*
  cell2.innerHTML = '<label for="comp_points_'+inst+'"></label><input type="number" id ="comp_points_'+inst+'" name="comp_points_'+inst+'" required></input>';
  cell3.innerHTML = '<label for="comp_skills_'+inst+'"></label><input type="text" id ="comp_skills_'+inst+'" name="comp_skills_'+inst+'"></input>';
  */
  
  var component_type_label = document.createElement("input");
  //component_type_label.setAttribute("type", "hidden");
  component_type_label.setAttribute("value", "text");
  component_type_label.setAttribute("name", "comp_type_"+inst);
  //cell1.appendChild(component_type_label);
  
  document.getElementById("questionsCount").value = tableLength;
}

function dropRow() {
  var table = document.getElementById("component_input_table");
  var tableLength = table.rows.length;
  
  if (tableLength > 1) {
    var row = table.deleteRow((tableLength-1));
    document.getElementById("questionsCount").value = (tableLength-2);
  }
  
  
}



function addLink() {
  var div = document.getElementById("link_input");
  var count = div.getElementsByClassName("link_input_div").length;
  console.log(count);
  var div2 = document.createElement('div');
  div2.classList.add("link_input_div")
  div2.setAttribute("id", "link_input_div_"+count);

  var link_input = document.createElement("input");
  link_input.setAttribute("id", "link_"+count);
  link_input.setAttribute("class", "link");
  link_input.setAttribute("name", "link_"+count);

  var link_label = document.createElement("label");
  link_label.setAttribute("for", "link_"+count );
  link_label.setAttribute("id", "link_label"+count );
  link_label.setAttribute("class", "link_label");
  link_label.innerHTML = "Link URL: ";

  var link_desc = document.createElement("input")
  link_desc.setAttribute("id", "link_desc"+count);
  link_desc.setAttribute("class", "link_desc");
  link_desc.setAttribute("name", "link_desc"+count);

  var link_desc_label = document.createElement("label");
  link_desc_label.setAttribute("for", "link_desc"+count );
  link_desc_label.setAttribute("id", "link_desc_label"+count )
  link_desc_label.setAttribute("class", "link_desc_label")
  link_desc_label.innerHTML = "Description: ";

  var button_remove = document.createElement("button");
  button_remove.setAttribute("type", "button");
  button_remove.innerHTML = "Remove Link";
  button_remove.setAttribute("onclick", "removeLink("+count+")");
  
  div2.appendChild(link_label);
  div2.appendChild(link_input);
  div2.appendChild(link_desc_label);
  div2.appendChild(link_desc);
  div2.appendChild(button_remove);
  div.appendChild(div2);
  linkCount ++;
  document.getElementById("linkCountInput").value=linkCount;

}

function removeLink(i) {
  var divRemove = document.getElementById("link_input_div_"+i);
  divRemove.remove();

  var count = 0;
  var link_input_divs = document.getElementsByClassName("link_input_div");
  console.log(link_input_divs.length);
  for(var j=0; j<link_input_divs.length; j++) {
    link_input_divs[j].setAttribute("id", "link_input_div_"+count);
    link_input_divs[j].getElementsByTagName("button")[0].setAttribute("onclick", "removeLink("+count+")");
    var link_input = link_input_divs[j].getElementsByClassName("link")[0];
    link_input.setAttribute("id", "link_"+count);
    link_input.setAttribute("name", "link_"+count);
    var link_desc = link_input_divs[j].getElementsByClassName("link_desc")[0];
    link_desc.setAttribute("id", "link_desc"+count);
    link_desc.setAttribute("name", "link_desc"+count);
    var link_desc_label = link_input_divs[j].getElementsByClassName("link_desc_label")[0];
    link_desc_label.setAttribute("for", "link_desc"+count );
    link_desc_label.setAttribute("id", "link_desc_label"+count )
    var link_label = link_input_divs[j].getElementsByClassName("link_label")[0];
    link_label.setAttribute("for", "link_"+count );
    link_label.setAttribute("id", "link_label"+count );

    count ++;
  }
linkCount = count;
document.getElementById("linkCountInput").value=linkCount;

}

</script>


</html>