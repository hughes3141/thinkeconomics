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


?>

<!DOCTYPE html>

<html lang="en">

<head>

<style>

.hide {
      display: none;
   }

td, th {
	
	border: 1px solid black;
	padding: 5px;
	word-wrap:break-word;
	
}

table {
	
  border-collapse: collapse;
	table-layout: auto;

  //width: 75%;
}



</style>

</head>


<body>

<?php 

$userId = $_SESSION['userid'];


/*
THIS IS assign_create
Created 18 February 2022, based on mcq_assigncreate1.1.php
Used to create all assignments


$_GET variables:
-Limit: to limit the number of queries that are returned in summary table

*/

//print_r($_POST);
/*
// Using OOP:

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/../secrets/secrets.php";
include($path);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

*/

?>

<h1>Assignment Creator</h1>

<form method="post" id ="form1">
<p>
<label for="assignName">Assignment Name</label>
<input type="text" id="assignName" name="assignName" value = "<?php if (isset($_POST['assignName'])){echo $_POST['assignName'];}?>">
</p>

<p>

<label for="assignType">Type:</label>
<select id="assignType" name="type" onchange="this.form.submit();">
  <option value=""></option>
  <option value="mcq" <?php if($_POST) {
    if($_POST['type']=="mcq"){
      echo "selected";}
      }
      ?> >MCQ</option>
  <option value="saq" <?php if($_POST) {
    if($_POST['type']=="saq"){
      echo "selected";}
     } 
     ?> >SAQ</option>
  <option value="exercise" <?php if($_POST) {
    if($_POST['type']=="exercise"){
       echo "selected";}
     } 
     ?> >exercise</option>
  <option value="nde" <?php if($_POST){
    if($_POST['type']=="nde"){
      echo "selected";}
     }
     ?> >Non Digital Entry</option>

</select>
</p>

<?php
if(isset($_POST['type'])) {
  $assignType = $_POST['type'];

  $teacherid = $userId;

if($assignType == "mcq") {
  $sql= "SELECT * FROM mcq_quizzes WHERE userCreate = ? /*ORDER BY dateCreated DESC*/";
}
else if ($assignType == "saq") {
  $sql= "SELECT * FROM saq_exercises WHERE userCreate = ?";
}
else if ($assignType == "exercise") {
  $sql= "SELECT * FROM exercise_list WHERE userCreate = ?";
}
else if ($assignType == "nde") {
  $sql= "SELECT * FROM nde_exercises WHERE userCreate = ?";
}


  $stmt = $conn->prepare($sql);
  $stmt -> bind_param("s", $teacherid);
  $stmt -> execute();

$result = $stmt->get_result();
}


?>


<p>
<label for="exerciseid">Quiz/Exercise:</label>
<!--
<input type="text" id="exerciseid" name="exerciseid">
-->
<select id="exerciseid" name="exerciseid" required>
<option value=""></option>
      <?php
        if($assignType == "mcq") {
          $exerciseName= "quizName";
        }
        else if ($assignType == "saq" or $assignType == "exercise" or $assignType == "nde") {
          $exerciseName= "exerciseName";
        }

        if($result) {
          while($row = $result->fetch_assoc()) {

            echo "<option value='".$row['id']."'>(".$row['id'].") ".$row[$exerciseName]."</option>";
          }
        }
      ?>
</select>
</p>
<p>

<?php
$teacherid = $userId;
$teacheridsql = '%\"'.$teacherid.'\"%';

$sql= "SELECT * FROM groups WHERE teachers LIKE ? AND active = 1";
$stmt = $conn->prepare($sql);
$stmt -> bind_param("s", $teacheridsql);
$stmt -> execute();

$result = $stmt->get_result();



?>

<div id="classInput">
  <div class="groupSelectorContainer">
    <label for="groupid">Class:</label><br>
    <select id="groupid" name ="groupid_0" class="groupSelector">
      <option value=""></option>
      <?php
        if($result) {
          while($row = $result->fetch_assoc()) {

            echo "<option value='".$row['id']."'>".$row['name']."</option>";
          }
        }
      ?>
    </select>
    
  </div>
</div>

<button type="button" onclick="addClass()">Add class</button>

<input type="hidden" id="groupCountInput" name="classCount" value = "1">

</p>

<p>

<label for="notes">Notes</label>
<input type="text" id="notes" name="notes">
</p>

<p>

<label for="dueDate">Due Date:</label>
<input type="datetime-local" id="dueDate" name="dueDate">

</p>

<table style="table-layout: fixed; width: 300px;">
  <tr>
    <td>
      <label for="reviewOn">Review On</label>
      <input type="radio" id="reviewOn" name="review" value = "0" checked>
    </td>
    <td>
      <label for="reviewOff">Review Off</label>
      <input type="radio" id="reviewOff" name="review" value = "1">
    </td>
  </tr>
  <tr>
    <td>
      <label for="multiOn">Multi Submit</label>
      <input type="radio" id="multiOn" name="multi" value = "0" checked>
    </td>
    <td>
      <label for="multiOff">No Multi Submit</label>
      <input type="radio" id="multiOff" name="multi" value = "1">
    </td>
  </tr>
</table>

<p>
  <input type="submit" value="Create Assignment" name ="btnSubmit">
</p>
</form>



<?php 


if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['updateValue'])) {

  $teacherid = $userId;

  $assignName = $_POST["assignName"];
  $quizID = $_POST["exerciseid"];

  $notes = $_POST["notes"];
  $review = $_POST["review"];
  $multi = $_POST["multi"];
  $datetime = date("Y-m-d H:i:s");
  $dueDate = $_POST["dueDate"];
  $type = $_POST["type"];

  $classIDArray = array();

  for($x=0; $x<$_POST['classCount']; $x++) {
    $classIDArray[$x] = $_POST['groupid_'.$x];
    //echo $x.": ".$classIDArray[$x];
  }

  $classID_text = "";
  foreach ($classIDArray as $val) {
    $classID_text .= $val.", ";
  }
  $classID = rtrim($classID_text, " , ");




  $classID_array = json_encode($classIDArray);

  //echo "classID_array: ";
  //print_r($classID_array);

  $assignReturn = 1;

    if ($review == 1) {
      
      $assignReturn = 0;
    }



//echo var_dump($_POST)."<br>";
//echo $datetime;

//echo "<br>".$assignName;

$sql = "INSERT INTO assignments (assignName, quizid, groupid, reviewQs, multiSubmit, notes, dateCreated, type, dateDue, assignReturn, groupid_array, userCreate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sisiissssisi", $assignName, $quizID, $classID, $review, $multi, $notes, $datetime, $type, $dueDate, $assignReturn, $classID_array, $teacherid);

  if (isset($_POST['btnSubmit'])) {
    //Execute
    
    $stmt->execute();
    echo "New records created successfully";

    //echo $assignName; echo $quizID; echo  $classID; echo  $review; echo  $multi; echo  $notes; echo  $datetime; echo  $type; echo  $dueDate; echo $assignReturn; echo  $classID_array;
    
  }

}

if(!isset($_GET['limit'])) {
  $limit = 10;
} else {
  $limit = $_GET['limit'];
}

?>

<h2>Assigned Work</h2>
<form method ="get" action="">
  <label for = "limit_pick">Limit: </label>
  <input type="number" id="limit_pick" min = "0" name="limit" value="<?=$limit?>">
  <input type="submit" value="Change Limit">
</form>
<br>
<table>
  <tr>
    <th>id</th>
    <th>Assignment</th>
    <th>Class</th>
    <th>Notes</th>
    <th>Dates</th>
    <th>Controls</th>
    <th>Edit</th>
  </tr>

<?php

//Script for updating values:

  function getAssignmentData($assignId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM assignments WHERE id = ?");
    $stmt->bind_param("i", $assignId);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0) {
      $row = $result->fetch_assoc();
      return $row;
    }
    
  
  }

  //print_r($_POST);

  if(isset($_POST['updateValue'])) {
    $sql = "UPDATE assignments SET assignReturn = ?, dateDue = ?, notes = ?, assignName =?, groupid_array =?, groupid = ?, reviewQs = ?, multiSubmit = ? WHERE id = ?";

    $groupid_array = explode(",",$_POST['groupid']);
    $groupid_array = json_encode($groupid_array);
    echo $groupid_array;

    
    $stmt = $conn->prepare($sql);
    //print_r($_POST);
    
    $stmt->bind_param("isssssiii", $_POST['assignReturn'], $_POST['dateDue'], $_POST['notes'], $_POST['assignName'], $groupid_array, $_POST['groupid'], $_POST['reviewQs'], $_POST['multiSubmit'], $_POST['id']);
  
    //The following script validates to ensure that the user updating the assignment is hte assignment author:

    $assignmentData = getAssignmentData($_POST['id']);
    $assignmentDataUser = $assignmentData['userCreate'];
  
    if($assignmentDataUser == $_SESSION['userid']) {
      $stmt->execute();
      //header("Refresh:0");
      echo "Record ".$_POST['id']." updated successfully.";
    }
    else {
      echo "Value not updated: userid does not match userCreate";
    }
  }



//Script for showing table values:



$sql = "SELECT * FROM assignments ORDER BY dateCreated desc LIMIT ?";


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
    
			<tr id = 'row_<?=$row['id'];?>'>
    <?php if($_SESSION['userid'] == $row['userCreate']) {?>
      <form method="post" action="">
    <?php }?>
        <td>
          <div>
            <?=htmlspecialchars($row['id']);?>
          </div>
        </td>
        <td>
          <div class="show_<?=$row['id'];?>">
            <?=htmlspecialchars($row['assignName']);?>
            <br>
          </div>
          <div class="hide hide_<?=$row['id'];?>">
            <input type="text" name="assignName" value = "<?=$row['assignName'];?>">
          </div>
            <?=htmlspecialchars($row['type']);?>
            <br>
            quizId: <?=htmlspecialchars($row['quizid']);?>
            <br>
          </div>
        </td>
        <td>
          <div class="show_<?=$row['id'];?>">
            <?php 
              if($row['groupid'] != "") {

                $groups = json_decode($row['groupid_array']);
                //  print_r($groups);
                if(count($groups)==1) {
                  //echo "Class: ";
                } else {
                  //echo "Classes: ";
                }
                foreach ($groups as $groupId) {
                  $group = getGroupInfoById($groupId);
                  echo $group['name'];
                  echo " (".$groupId.")<br>";
                }
              }
              ?>
          </div>
          <div class="hide hide_<?=$row['id'];?>">
          <input type="text" style="width: 60px;" name="groupid" value = "<?php
            echo implode(",",$groups);
          
          ?>">
          </div>
        </td>
        <td>
          <div class="show_<?=$row['id'];?>">
            <?=htmlspecialchars($row['notes']);?>
          </div>
          <div class="hide hide_<?=$row['id'];?>">
              <textarea name ="notes"><?=htmlspecialchars($row['notes']);?></textarea>

          </div>
        </td>
        <td>
          <div class="show_<?=$row['id'];?>">
            Due:<br>
            <?=date("d/m/y g:ia",strtotime($row['dateDue']));?>
            <br>
            Created:
            <?=date("d/m/y", strtotime($row['dateCreated']));?>
          </div>
          <div class="hide hide_<?=$row['id'];?>">
            Due:
            <input type="datetime-local" name="dateDue" value="<?=$row['dateDue'];?>">
          </div>
        </td>
        <td>
        <div class="show_<?=$row['id'];?>">
          Review: <?=htmlspecialchars($row['reviewQs']);?>
          <br>
          Multi-Submit: <?=htmlspecialchars($row['multiSubmit']);?>
          <br>
          Returned:<?=htmlspecialchars($row['assignReturn']);?>
        </div>
        <div class="hide hide_<?=$row['id'];?>">
          Review:<input type="text" style="width: 60px;" name="reviewQs" value = "<?=$row['reviewQs'];?>">
          <br>

          Multi:<input type="text" style="width: 60px;" name="multiSubmit" value = "<?=$row['multiSubmit'];?>">
          <br>

          Returned:<input type="text" style="width: 60px;" name="assignReturn" value = "<?=$row['assignReturn'];?>">
        </div>

        </td>

        

        
        <td>
          
        <?php if($_SESSION['userid'] == $row['userCreate']) {?>
            <div>
              <button type ="button" id = "button_<?=$row['id'];?>" onclick = "changeVisibility(this, <?=$row['id'];?>)"">Edit</button>
            </div>
            <div class ="hide hide_<?=$row['id'];?>">
              <input type="hidden" name = "id" value = "<?=$row['id'];?>">

              <input type="submit" name="updateValue" value = "Update"></input>
            </div>
          <?php }?>
        </td>
    <?php if($_SESSION['userid'] == $row['userCreate']) {?>
      </form>
    <?php }?>
			</tr>

      <?php
		
	}
	
}



?>

</table>



<script>

function changeVisibility(button, id) {
  
  if(button.innerHTML =="Edit") {
    button.innerHTML = "Hide Edit";
    var hiddens = document.getElementsByClassName("hide_"+id);
    for (var i=0; i<hiddens.length; i++) {
      hiddens[i].style.display = "block";
    }

    var shows = document.getElementsByClassName("show_"+id);
    //console.log(shows);
    for (var i=0; i<shows.length; i++) {
      
      shows[i].style.display = "none";
    }
  } else {
    button.innerHTML = "Edit";
    var hiddens = document.getElementsByClassName("hide_"+id);
    for (var i=0; i<hiddens.length; i++) {
      hiddens[i].style.display = "none";
    }

    var shows = document.getElementsByClassName("show_"+id);
    //console.log(shows);
    for (var i=0; i<shows.length; i++) {
      
      shows[i].style.display = "block";
    }
  }


}

var classIndex = [];

<?php 


$sql= "SELECT * FROM groups WHERE teachers LIKE ?";
$stmt = $conn->prepare($sql);
$stmt -> bind_param("s", $teacheridsql);
$stmt -> execute();

$result = $stmt->get_result();

$classIndex = array();

if($result){
  while($row = $result->fetch_assoc()){
    $classIndex2 = array();
    array_push($classIndex2, htmlspecialchars($row['id']));
    array_push($classIndex2, htmlspecialchars($row['name']));
    array_push($classIndex, $classIndex2);
    
    /*

    echo "var classIndex2 = [];
    classIndex2.push(".htmlspecialchars($row['id']).");
    classIndex2.push('".htmlspecialchars($row['name'])."');
    classIndex.push(classIndex2);";
    */
  }

  echo "classIndex = ".json_encode($classIndex);

}

?>

console.log(classIndex);

var groupCount = 1;
document.getElementById("groupCountInput").value = groupCount;

function addClass() {

  var selectorsContainers = document.getElementsByClassName("groupSelectorContainer");
  groupCount = selectorsContainers.length;

  var select = document.createElement("select");
  select.setAttribute("name", "groupid_"+groupCount);
  select.setAttribute("class", "groupSelector");
  var classInput = document.getElementById("classInput");
  var div = document.createElement("div");
  div.setAttribute("id", "classInput_"+groupCount);
  div.setAttribute("class", "groupSelectorContainer");
  
  for (var i = 0; i<classIndex.length; i++){
    var opt = document.createElement('option');
    opt.value = classIndex[i][0];
    opt.innerHTML = classIndex[i][1];
    select.appendChild(opt);
  
  }
  var br = document.createElement("br");
  var button = document.createElement("button");
  button.setAttribute("type", "button");
  button.setAttribute("class", "groupSelectorButton");
  button.setAttribute("onclick", "deleteClass("+groupCount+")");
  button.innerHTML = "Remove Class";
  //classInput.appendChild(br);
  div.appendChild(select);
  div.appendChild(button);
  classInput.appendChild(div);
  //classInput.appendChild(select);
  //classInput.appendChild(button);
  
  groupCount ++;
  console.log(groupCount);

  document.getElementById("groupCountInput").value = groupCount;
}

function deleteClass(i) {
  var classRemove = document.getElementById("classInput_"+i);
  classRemove.remove();

 
  groupCount = 0;
  var selectors = document.getElementsByClassName("groupSelector");
  for (var i=0; i<selectors.length; i++) {
    selectors[i].setAttribute("name", "groupid_"+groupCount);
    groupCount ++;
  }

  var groupCount = 0;
  var selectorsContainers = document.getElementsByClassName("groupSelectorContainer");
  for (var i=0; i<selectorsContainers.length; i++) {
    selectorsContainers[i].setAttribute("id", "classInput_"+groupCount);
    groupCount ++;
    
  }

  
  buttonCount = 1;
  var selectorsButtons = document.getElementsByClassName("groupSelectorButton");
  for (var i=0; i<selectorsButtons.length; i++) {
    selectorsButtons[i].setAttribute("onclick", "deleteClass("+buttonCount+")");
    buttonCount ++;
  }

  console.log(groupCount);
  document.getElementById("groupCountInput").value = groupCount;
}

console.log(classIndex);


function returnUpdate(i) {
	
	
	//alert("This works for "+i+" number");
	
	var status = document.getElementById("assignReturn_"+i).innerHTML;
	
	var changeType = document.getElementById("changeType");
	var changeId = document.getElementById("changeId");
	var changeValue = document.getElementById("changeValue");
	
	
	if (status == 1) {
		
		//alert (i+" Change to 0");
		changeType.value = "assignReturn";
		changeId.value = i;
		changeValue.value = 0;
		
	}
	
	else if (status == 0) {
		
		//alert (i+" Change to 1");
		changeType.value = "assignReturn";
		changeId.value = i;
		changeValue.value = 1;
		
	}
	
	document.getElementById("form2").submit();
}


</script>

</body>

</html>