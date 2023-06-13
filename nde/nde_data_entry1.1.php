<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include($path."/php_header.php");
?>

<!DOCTYPE html>

<html lang="en">



<head>

<style>

td, th {
  border: 1px solid black;
}

table {
  border-collapse: collapse;
}

</style>


</head>


<body>

<?php

// Using OOP:



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql2 ="SELECT * FROM nde_exercises";
$stmt2 = $conn->prepare($sql2);
//$stmt2->bind_param("i", $id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$teacherid = 1;
$teacheridsql = '%\"'.$teacherid.'\"%';

$sql3 ="SELECT * FROM groups WHERE teachers LIKE ?";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param("s", $teacheridsql);
$stmt3->execute();
$result3 = $stmt3->get_result();

$sql4 = "SELECT * FROM assignments WHERE type = 'nde'";
$result4 = $conn->query($sql4);





?>

<form method ="get">

<label for="assignid">Assignment:</label>
<select id="assignid" name="assignid" onchange="this.form.submit()">
  <option value=""></option>
  <?php
    if($result4) {
      while($row=$result4->fetch_assoc()){
        if ($_GET['assignid']==$row['id']) {
          $selected = "selected";
        } else {
          $selected = "";
        }
        echo "<option value ='".$row['id']."'".$selected.">".$row['assignName']."</option>";
      }
    } 
  ?>
</select>
</form>

<?php
  
  if(isset($_GET['assignid'])) {
    $sql = "SELECT * FROM assignments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET['assignid']);
    $stmt->execute();
    
    $result=$stmt->get_result();

    if($result) {
      $row = $result->fetch_assoc();
      //print_r($row);

      $_GET['exerciseid'] = $row['quizid'];
      $_GET['groupid'] = $row['groupid'];

      
    }
    
  }



?>

<br>
<form method="get">

<label for="exerciseid">Exercise: </label>
<select id="exerciseid" name="exerciseid" onchange="this.form.submit()">
  <?php
      if($result2) {
        while($row2 = $result2->fetch_assoc()) {
          if ($_GET['exerciseid']==$row2['id']) {
            $selected = "selected";
          } else {
            $selected = "";
          }
          echo "<option value ='".$row2['id']."'".$selected.">".$row2['exerciseName']."</option>";
        }
      }
      ?>
</select>


  
</form>
<br>
<form method="get">

<label for="groupid">Class:</label>
<select id="groupid" name ="groupid" onchange="this.form.submit()" <?php if(!isset($_GET['exerciseid'])) {echo "disabled";}?>>
  <option value=""></option>
  <?php
      if($result3) {
        while($row3 = $result3->fetch_assoc()) {
          if ($_GET['groupid']==$row3['id']) {
            $selected = "selected";
          } else {
            $selected = "";
          }
          echo "<option value ='".$row3['id']."'".$selected.">".$row3['name']."</option>";
        }
      }
      ?>
</select>

<input type="hidden" name ="exerciseid" value="<?php echo $_GET['exerciseid'];?>">

</form>

<?php 

if(isset($_GET['groupid'])) {
  
  ?>
  <button id="inputToggle" onclick="toggleInputDisplay()">Click to show feedback inputs</button>
  <form method="post">
  <input type="hidden" name="assignid" value="<?php echo $_GET['assignid']?>">
  <input type="hidden" name="exerciseid" value="<?php echo $_GET['exerciseid']?>">
  <input type="hidden" name="groupid" value="<?php echo $_GET['groupid']?>">
  <table id="inputTable">
    <tr id="tableHeaderRow">
      <th>Student Name</th>
    </tr>
  </table>
  
  <input type ="hidden" id="userArray" name="userArray">
  <input type ="hidden" id="compCount" name="compCount">
  <input type ="hidden" id="totalValues" name="totalValues">
  <input type ="hidden" name="exercisename" value = "<?php 
    $sql="SELECT exerciseName FROM nde_exercises WHERE id = ?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i", $_GET['exerciseid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo $row['exerciseName'];

  ?>">
  <input type="submit" value ="Update Records" name ="submitBtn">
  </form>

  <?php 
  
}

if(isset($_POST['submitBtn'])) {
  $userArray = explode(",",$_POST['userArray']);
  $compCount = $_POST['compCount'];
  //print_r($userArray);
  //echo count($userArray);
  //print_r($_POST);
  $resultsArray = array();

  $stmt=$conn->prepare("INSERT INTO nde_responses (exerciseName, exerciseID, assignID, userID, name, mark, percentage, data, returned, datetime, feedback, feedbackOverall) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("siiisississs", $exerciseName, $exerciseID, $assignID, $userID, $name, $mark, $percentage, $data, $returned, $datetime, $feedback, $feedbackOverall);

  
  for($x=0; $x<count($userArray); $x++) {
    
    $exerciseName = $_POST['exercisename'];
    $exerciseID = $_POST['exerciseid'];
    $assignID = $_POST['assignid'];
    $userID = $userArray[$x];
    $name =$_POST['name_'.$userArray[$x]];
    $mark = $_POST['sum_'.$userArray[$x]];
    $percentage = $_POST['sum_'.$userArray[$x]]/$_POST['totalValues']*100;
    if(isset($_POST['return_'.$userArray[$x]])) {
      $returned = $_POST['return_'.$userArray[$x]];
    } else {
      $returned = 0;
    }
    
    $datetime = date("Y-m-d h:i:s");

    $componentsSub = array();
    for($y=0; $y<$compCount; $y++) {
      $componentsSub[$y] = $_POST['id_'.$userArray[$x].'_comp_'.$y];
    }
    $data = json_encode($componentsSub);
    //echo $data;

    $componentsSub = array();
    for($y=0; $y<$compCount; $y++) {
      $componentsSub[$y] = $_POST['id_'.$userArray[$x].'_comp_feedback_'.$y];
    }
    $feedback = json_encode($componentsSub);

    $feedbackOverall = $_POST['id_'.$userArray[$x].'_overall_feedback'];

    $stmt->execute();
    

    

    $resultsArraySub = array();
    $resultsArraySub['user'] = $userArray[$x];
    $resultsArraySub['name'] = $_POST['name_'.$userArray[$x]];
    $resultsArraySub['assignid'] = $_POST['assignid'];
    $resultsArraySub['exerciseid'] = $_POST['exerciseid'];
    $resultsArraySub['exercisename'] = $_POST['exercisename'];
    $resultsArraySub['feedbackOverall'] = $_POST['id_'.$userArray[$x].'_overall_feedback'];
    $resultsArraySub['return'] = $_POST['return_'.$userArray[$x]];
    $resultsArraySub['total'] = $_POST['sum_'.$userArray[$x]];
    $resultsArraySub['percentage'] = $_POST['sum_'.$userArray[$x]]/$_POST['totalValues']*100;
    $resultsArraySub['total_available'] = $_POST['totalValues'];

    $componentsSub = array();
    for($y=0; $y<$compCount; $y++) {
      $componentsSub[$y] = $_POST['id_'.$userArray[$x].'_comp_'.$y];
    }
    $resultsArraySub['responses'] = $componentsSub;
    

    $componentsSub = array();
    for($y=0; $y<$compCount; $y++) {
      $componentsSub[$y] = $_POST['id_'.$userArray[$x].'_comp_feedback_'.$y];
    }
    $resultsArraySub['feedback'] = $componentsSub;
    
    array_push($resultsArray, $resultsArraySub);

    

  }

  echo "<br>";
  echo "<br>";
  //print_r($resultsArray);
  echo "<br>";
  foreach ($resultsArray as $val) {
    print_r($val);
    echo "<br>";
    echo "<br>";
  }

}


?>

<script>

var exerciseIndex = [];
var studentIndex = [];
var answersIndex = [];


<?php 

$sql ="SELECT * FROM nde_exercises WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['exerciseid']);
$stmt->execute();
$result = $stmt->get_result();

if($result) {
  $row=$result->fetch_assoc();
  //$components = json_decode($row['components']);
  
  //echo "/*";
  //print_r($components);
  //echo "*/";
  echo 'exerciseIndex = '.$row['components'].";

";
  
}

$sql ="SELECT id, name FROM users WHERE usertype = 'student' AND groupid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['groupid']);
$stmt->execute();
$result = $stmt->get_result();

$student_index = array();

if($result) {
  while($row=$result->fetch_assoc()) {
    array_push($student_index, array_values($row));
    
  }



  $student_index2=json_encode($student_index);

  echo 'studentIndex = '.$student_index2.";";



}

$sql = "SELECT exerciseID, assignID, userID, data, returned, feedback, feedbackOverall, datetime FROM nde_responses WHERE exerciseID = ? AND userID = ?";

$answersIndex = array();

foreach($student_index as $val) {

  
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $_GET['exerciseid'], $val[0]);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result) {
    while ($row = $result->fetch_assoc()) {
      //print_r($row);
      
      $answersIndex2 = array();
      array_push($answersIndex2, $row['exerciseID']);
      array_push($answersIndex2, $row['assignID']);
      array_push($answersIndex2, $row['userID']);
      array_push($answersIndex2, json_decode($row['data']));
      array_push($answersIndex2, $row['returned']);
      array_push($answersIndex2, json_decode($row['feedback']));
      array_push($answersIndex2, $row['feedbackOverall']);
      array_push($answersIndex, $answersIndex2);
      

    }
  }

}


echo 'answersIndex = '.json_encode($answersIndex).';';


?>


console.log(exerciseIndex);
console.log(studentIndex);
console.log(answersIndex);

var questionValues = [];

for(var i=0; i<exerciseIndex.length; i++) {
  if(exerciseIndex[i][1]) {
    questionValues.push(parseInt(exerciseIndex[i][1]));
  }
}

//console.log(questionValues);
var totalQuestionValues = questionValues.reduce((pv, cv) => pv + cv, 0);
//console.log(totalQuestionValues);
document.getElementById("totalValues").value = totalQuestionValues;

function newColumn(i, j) {
  var table = document.getElementById("inputTable");
  var columnLength = table.rows[0].cells.length;
  //console.log(columnLength);
  var row = document.getElementById("tableHeaderRow");
  var x = row.insertCell(columnLength);
  if(j){
    j = "<br>"+j;
    } else {
      j = "";
    }
  x.innerHTML = i+j;
}



function newRow(name, id) {
  var table = document.getElementById("inputTable");
  
  var columnLength = table.rows[0].cells.length;
  console.log(rowLength);
  
  var row = table.insertRow(rowLength);
  
  var cell0= row.insertCell(0);
  var nameSpan = document.createElement("span");
  nameSpan.innerHTML = name;
  var nameInput = document.createElement("input");
  nameInput.type ="hidden";
  nameInput.value = name;
  nameInput.name = "name_"+id;

  cell0.appendChild(nameSpan);
  cell0.appendChild(nameInput);
  
  for(var i=0; i<exerciseIndex.length; i++) {
    var cell_loop = row.insertCell((i+1));
    var input = document.createElement("span");
    if (exerciseIndex[i][1]) {
      input.innerHTML = "<input name='id_"+id+"_comp_"+i+"' class ='number_id_"+id+"'type='number' min = 0 max = "+exerciseIndex[i][1]+" onchange = 'sumNumbers("+id+")' value = '"+getData(id,3,i)+"'> / "+exerciseIndex[i][1];
    } else {
      input.innerHTML = "<input name='id_"+id+"_comp_"+i+"' type='text' value = '"+getData(id,3,i)+"' >";
    }
    cell_loop.appendChild(input);

    var feedback_input = document.createElement("span");
    var data;
    if (getData(id,5,i) != null) {
      data = getData(id,5,i);
    } else {
      data = "";
    }
    feedback_input.style.display = "none";
    feedback_input.innerHTML = "<br><textarea name='id_"+id+"_comp_feedback_"+i+"' type='text' >"+data/*getData(id,5,i)*/+"</textarea>";
    feedback_input.classList.add("feedbackInput");
    feedback_input.classList.add("feedbackInput_"+id);
    cell_loop.appendChild(feedback_input);
    
  }
  var rowLength = row.length;
  if (totalQuestionValues > 0 ) {
    var cell_last = row.insertCell(rowLength);
    cell_last.innerHTML ="<input name = 'sum_"+id+"' id = 'sum_"+id+"' type = 'hidden'><span id='sum_display_"+id+"'></span>/"+totalQuestionValues;
    }
  
  rowLength = row.length;
  if (getData2(id,6) != null) {
      data = getData2(id,6);
    } else {
      data = "";
    }
  var cell_last = row.insertCell(rowLength);
  cell_last.innerHTML ="<textarea name='id_"+id+"_overall_feedback' type='text' >"+data/*getData2(id,6)*/+"</textarea>"

  rowLength = row.length;
  cell_last = row.insertCell(rowLength);
  var checked;
  if (getData2(id,4)==1) {
    checked = "checked";
  }
  cell_last.innerHTML ="<input type='checkbox' id='id_"+id+"_retrun' name='return_"+id+"'"+checked+" value='1'>";

  
  
  
}

function getData(user, dataElement, iteration) {
  var data = [];
  for(var i=0; i<answersIndex.length; i++) {
    if(answersIndex[i][2]== user) {
      data = answersIndex[i][dataElement];
      //break;
    }
  if (data[iteration]) {
    return data[iteration];
    }
  }
}

function getData2(user, dataElement) {
  var data ;
  for(var i=0; i<answersIndex.length; i++) {
    if(answersIndex[i][2]== user) {
      data = answersIndex[i][dataElement];
      //break;
    }
  if (data) {
    return data;
    }
  }
}



for(var i=0; i<exerciseIndex.length; i++) {
  newColumn(exerciseIndex[i][0], exerciseIndex[i][2]);

}

if (totalQuestionValues > 0 ) {
  newColumn("Total");}
newColumn("Feedback");
newColumn("Return");

document.getElementById("compCount").value = exerciseIndex.length;

var userArray = [];




for(var i=0; i<studentIndex.length; i++) {
  newRow(studentIndex[i][1], studentIndex[i][0]);
  userArray[i] = studentIndex[i][0];
}

document.getElementById("userArray").value = userArray.join();

function sumNumbers(studentid) {
  var numbers = document.getElementsByClassName("number_id_"+studentid);
  var numValues = [];
  for(var i=0; i<numbers.length; i++) {
    if (numbers[i].value != "") {
      numValues[i]=parseInt(numbers[i].value);
    }
    
  }
  console.log(numValues);
  var sum = numValues.reduce((pv, cv) => pv + cv, 0);
  //console.log(sum);
  var input = document.getElementById("sum_"+studentid);
  var input_display = document.getElementById("sum_display_"+studentid);
  input.value = sum;
  input_display.innerHTML = sum;
}

function toggleInputDisplay() {
  var inputs = document.getElementsByClassName("feedbackInput");
  var button = document.getElementById("inputToggle");

  if (button.innerHTML == "Click to show feedback inputs") {
    for(var i=0; i<inputs.length; i++) {
      inputs[i].style.display = "inline"
    }
    button.innerHTML ="Click to hide feedback inputs";
  }
  else {
    for(var i=0; i<inputs.length; i++) {
      inputs[i].style.display = "none"
    }
    button.innerHTML ="Click to show feedback inputs";
  }
}

</script>

<?php 





//$arr = get_defined_vars();
//echo "<br><br>";
//print_r($arr);
?>
</body>



</html>