<!DOCTYPE html>

<html lang="en">

<head>

<style>
td, th {
	
	border: 1px solid black;
	padding: 5px;
	word-wrap:break-word;
	
}

table {
	
  border-collapse: collapse;
	table-layout: auto;

  width: 75%;
}

</style>

</head>


<body>

<?php 

/*
THIS IS assign_create
Created 18 February 2022, based on mcq_assigncreate1.1.php
Used to create all assignments

*/

print_r($_POST);

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

  $teacherid = 1;

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
$teacherid = 1;
$teacheridsql = '%\"'.$teacherid.'\"%';

$sql= "SELECT * FROM groups WHERE teachers LIKE ?";
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

<input type="" id="groupCountInput" name="classCount">

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
<td>



</td>

</table>
<br>
<input type="submit" value="Create Assignment" name ="btnSubmit">

</form>

<form id="form2" method ="post">

<input type ="text" name ="changeType" id="changeType"></input>
<input type ="number" name ="id" id="changeId"></input>
<input type ="text" name ="value" id="changeValue"></input>


</form>

<?php 


$teacherid = 1;

$assignName = $_POST["assignName"];
$quizID = $_POST["exerciseid"];

$notes = $_POST["notes"];
$review = $_POST["review"];
$multi = $_POST["multi"];
$datetime = date("Y-m-d");
$dueDate = $_POST["dueDate"];
$type = $_POST["type"];

$classIDArray = array();

for($x=0; $x<$_POST['classCount']; $x++) {
  $classIDArray[$x] = $_POST['groupid_'.$x];
  echo $x.": ".$classIDArray[$x];
}

$classID_text = "";
foreach ($classIDArray as $val) {
  $classID_text .= $val.", ";
}
$classID = rtrim($classID_text, " , ");


$classID_array = json_encode($classIDArray);

echo "classID_array: ";
print_r($classID_array);

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

//$query = "INSERT INTO `assignments` (`assignName`, `quizid`, `groupid`, `reviewQs`, `multiSubmit`, `notes`, `dateCreated`, `type`, `dateDue`, `assignReturn`) VALUES ('$assignName', '$quizID', '$classID', '$review', '$multi', '$notes', '$datetime', '$type', '$dueDate', '$assignReturn')";


if ($_POST['changeType'] == "assignReturn") {
	

	
	$query2 = "UPDATE `assignments` SET `assignReturn` = '".$_POST['value']."' WHERE `assignments`.`id` = ".$_POST['id'];
	
	
//UPDATE `assignments` SET `assignReturn` = '1' WHERE `assignments`.`id` = 62;
	
	echo $query2;
	
	
}

?>


<table>
<tr>

<th>id</th>
<th>Assignment Name</th>
<th>quizID</th>
<th>classID</th>
<th>Notes</th>
<th>Date Created</th>
<th>Due Date</th>
<th>Review Off</th>
<th>Multi Submit Off</th>
<th>Type</th>
<th>AssignReturn</th>
</tr>

<?php

$query = "SELECT * FROM assignments";

if ($result = mysqli_query($conn, $query)) {
	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		
			echo "<tr>";
			echo "<td>$row[id]</td>";
			echo "<td>$row[assignName]</td>";
			echo "<td>$row[quizid]</td>";
			echo "<td>$row[groupid]</td>";
			echo "<td>$row[notes]</td>";
			echo "<td>$row[dateCreated]</td>";
			echo "<td>$row[dateDue]</td>";
			echo "<td>$row[reviewQs]</td>";
			echo "<td>$row[multiSubmit]</td>";
			
			echo "<td>$row[type]</td>";
			
			echo "<td><span id='assignReturn_$row[id]'>$row[assignReturn]</span><br><button onclick ='returnUpdate($row[id])'>Change</button></td>";
			
			echo "</tr>";
		
	}
	
}



?>

</table>



<script>

var classIndex = [];

<?php 


$sql= "SELECT * FROM groups WHERE teachers LIKE ?";
$stmt = $conn->prepare($sql);
$stmt -> bind_param("s", $teacheridsql);
$stmt -> execute();

$result = $stmt->get_result();

if($result){
  while($row = $result->fetch_assoc()){
    echo "var classIndex2 = [];
    classIndex2.push(".$row['id'].");
    classIndex2.push('".$row['name']."');
    classIndex.push(classIndex2);";
  }
}

?>

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