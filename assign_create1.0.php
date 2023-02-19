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
  if (!(str_contains($permissions, 'teacher'))) {
    header("location: /index.php");
  }

  $groupsList = getGroupsList($userId);

}  

$style_input = ".hide {
  display: none;
  }
  input, button, textarea, th, td, select {
    border: 1px solid black;
  }



td, th {

border: 1px solid black;
padding: 5px;
word-wrap:break-word;

}

table {

border-collapse: collapse;
table-layout: auto;


}

p {
  //margin-bottom: 5px;
}

  
  ";



if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_POST['btnSubmit'])) {
    createAssignment($userId, $_POST['assignName'], $_POST['exerciseid'], $_POST['notes'], $_POST['dueDate'], $_POST['type'], $_POST['groupId']);

  }

  if(isset($_POST['updateValue'])) {

    $updateMessage = updateAssignment($userId, $_POST['id'], $_POST['assignName'], null, $_POST['notes'], $_POST['dueDate'], null, $_POST['groupid'], $_POST['assignReturn'], $_POST['reviewQs'], $_POST['multiSubmit']);
  }

}

include($path."/header_tailwind.php");
?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Assignment Creator</h1>
  <div class="container mx-auto p-4 mt-2 bg-white text-black ">
  
  <?php
  //print_r($userInfo);
  //echo "<br>";
  //print_r($groupsList);
  if($_SERVER['REQUEST_METHOD']==='POST') {
    print_r($_POST);
  }


  ?>



<form method="post" id ="form1">
  <div>
    <label for="groupSelect">Class:<label>
    <select id="groupSelect" name="groupId" class="w-full rounded border border-black" onchange="this.form.submit(); console.log(this.form);">
      <option value =""></option>
        <?php
          $results = $groupsList;
          foreach($results as $result) {
            $selected = "";
            if($_POST['groupId'] == $result['id']) {
              $selected = " selected ";

            }
            ?>
              <option value="<?=$result['id']?>"<?=$selected?>><?=$result['name']?></option>
            
            <?php
          }
      
        ?>
      <input type="" name="submit2" value="Select Group" class="hidden mt-3 rounded bg-sky-300 hover:bg-sky-200 focus:bg-sky-100 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block border border-black">
    </select>
  </div>

  <?php

  if(isset($_POST['groupId'])) {


    ?>
    <div>
      <label for="assignName">Assignment Name:<label>
        <div class="w-full mb-1.5">
          <input id = "assignName" class="rounded border border-black w-full" type="text" name="assignName" value ="<?=(isset($_POST['assignName'])) ? $_POST['assignName'] : "" ?>">
        </div>
    </div>

    <div>
      <label for="assignType">Type:<label>
        <div class="w-full mb-1.5">
          <select id="assignType" name="type" onchange="this.form.submit();" class="rounded border border-black w-full">

            <option value=""></option>
            <option value="mcq" <?=(isset($_POST['type'])&&$_POST['type']=='mcq') ? "selected" : "" ?>>Multiple Choice Questions</option>
            <?php 
              if(str_contains($userInfo['school_permissions'], "saq_dashboard")) {
                ?>
            <option value="saq" <?=(isset($_POST['type'])&&$_POST['type']=='saq') ? "selected" : "" ?>>Short Answer Questions</option>
            <option value="nde" <?=(isset($_POST['type'])&&$_POST['type']=='nde') ? "selected" : "" ?>>Non-Digital Entry</option>
            <?php
              }
              ?>
          </select>
        </div>
    </div>

    <?php
      $exercises = array();
      $exerciseName= "exerciseName";
      if(isset($_POST['type'])) {
        if($_POST['type'] == "mcq") {
          $exercises = getMCQquizzesByTopic("");
          $exerciseName= "quizName";
        }
        if($_POST['type'] == "saq") {
          $exercises = getExercises("saq_exercises");
        }
        if($_POST['type'] == "nde") {
          $exercises = getExercises("nde_exercises");
        }      
      //print_r($exercises);
      }
    ?>

    <?php
    if(isset($_POST['type']) && $_POST['type']!="") {
      ?>
    
    <div>
      <label for="exerciseid">Quiz/Exercise:<label>
        <div class="w-full mb-1.5">
          <select id="exerciseid" name="exerciseid" class="rounded border border-black w-full" onChange="this.form.submit()">
            <option value=""></option>
            <?php
              foreach($exercises as $exercise) {
                ?>
                <option value="<?=$exercise['id']?>" <?=(isset($_POST['exerciseid'])&& $_POST['exerciseid'] == $exercise['id']) ? "selected" : ""?>><?=$exercise[$exerciseName]?></option>
                <?php
              }
            ?>
          </select>
        </div>
    </div>

    <div>
    <label for="notes">Notes</label>
      <div class="w-full mb-1.5">
        <textarea type="text" id="notes" name="notes" class="rounded w-full"><?=(isset($_POST['notes'])) ? htmlspecialchars($_POST['notes']) : ""?></textarea>
      </div>
    </div>
    <div>
      <label for="dueDate">Due Date:</label>
      <input type="datetime-local" id="dueDate" name="dueDate" class="rounded w-full" value = "<?=(isset($_POST['dueDate'])) ? $_POST['dueDate'] : date("Y-m-d 09:00:00")?>">
    </div>
    <div>
      <input type="submit" value="Create Assignment" name ="btnSubmit" class=" mt-3 rounded bg-sky-300 hover:bg-sky-200 focus:bg-sky-100 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block border border-black">
    </div>

    <?php
    }
  }

  ?>





<?php 


if(!isset($_GET['limit'])) {
  $limit = 10;
} else {
  $limit = $_GET['limit'];
}

?>

<?php 
if(isset($_POST['groupId'])) {
  ?>
  <h2>List of Assignments</h2>

    <label for = "limit_pick">Limit: </label>
    <input type="number" id="limit_pick" min = "0" name="limit" value="<?=$limit?>">
    <input type="submit" value="Change Limit">


  <?php

  $assignments = getAssignmentsByGroup($_POST['groupId']);

  //print_r($assignments);

  ?>

  <table class="w-full">
  <tr>
    <th>Assignment</th>
    <th>Notes</th>
    <th>Dates</th>
    <!--<th>Controls</th>-->
    <th>Edit</th>
  </tr>

  <?php

  foreach($assignments as $assignment) {
    ?>

    <tr>
      <td>
        <p><?=htmlspecialchars($assignment['assignName'])?></p>
        <p><?=$assignment['type']?></p>
        <p><?=$assignment['quizid']?></p>
      </td>
      <td>
        <?=$assignment['notes']?>
      </td>
      <td>
        <p>Due: </p>
        <p><?=date("d/m/y g:ia",strtotime($assignment['dateDue']));?></p>
        <p>Created: </p>
        <p><?=date("d/m/y", strtotime($assignment['dateCreated']));?></p>
      </td>
      <td>
        <button type="button">Edit</button>
      </td>
    </tr>

    <?php
  }

}


if(isset($updateMessage)) {
  echo $updateMessage;
}
?>

</form>

<?php
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
            <input type="datetime-local" name="dueDate" value="<?=$row['dateDue'];?>">
            <?=$row['dateDue']?>
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

</div>

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

<?php   include($path."/footer_tailwind.php");?>