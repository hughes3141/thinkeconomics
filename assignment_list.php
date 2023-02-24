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

$updateMessage = "";



if($_SERVER['REQUEST_METHOD'] == 'POST') {


  if(isset($_POST['updateValue'])) {
    $updateMessage = updateAssignment($userId, $_POST['id'], $_POST['assignName'], null, $_POST['notes'], $_POST['dateDue'], null, $_POST['groupid'], $_POST['assignReturn'], $_POST['reviewQs'], $_POST['multiSubmit'], 1);
    //Ensure that changevisibility does not happen when directed from this same site:
    unset($_GET['assignid']);


  }


}

$style_input = ".hide {
  display: none;
  }

  td, th {
    padding: 5px;
    border: 1px solid black;
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
  



include ($path."/header_tailwind.php");



?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 w-full">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Assignment List</h1>
  <div class="container mx-auto p-4 mt-2 bg-white text-black ">

  <?php
    echo "<pre>";
    //print_r($groupsList);
    echo "</pre>";
    //echo "<br><br>";
    if(isset($_GET['groupid'])) {$groupFromGet = getGroupInfoById($_GET['groupid']);
    //print_r($groupFromGet);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      //print_r($_POST); 
    }
    echo $updateMessage;
    //print_r($_SESSION);



  ?>


  <?php 


  if(!isset($_GET['limit'])) {
    $limit = 10;
  } else {
    $limit = $_GET['limit'];
  }

 
  if(!isset($_GET['groupid'])) {
    $assignments = getAssignmentsListByTeacher($userId, $limit);
    } else {
    $assignments = getAssignmentsListByTeacher($userId, $limit, $_GET['groupid']);
  }

  //If $_GET['assignid'] is declared this means it is coming from assign_create1.0.php and wants to be displayed on its own. Otherwise display all assignments in $assignments.

  if(isset($_GET['assignid'])) {
    function filterAssignment($assignid, $assignments) {
      foreach ($assignments as $assignment) {
        if ($assignment['id'] == $assignid) {
          return $assignment;
        }
      }
    }
      $assignFilter = filterAssignment($_GET['assignid'], $assignments);
      if($assignFilter) {
        $assignments = array($assignFilter);
      }
  }

  
  //echo "<pre>";
  //var_dump($assignFilter);

  //print_r($assignments);
  //echo "</pre>";

  ?>


  <form method ="get" action="" id="control_form">
    <div class="mb-1.5">
      <label for="groupid">Class:</label>
      <div class="w-full">
        <select name="groupid" id="groupid" class="w-full rounded border border-black">
          <option></option>
          <?php
          foreach($groupsList as $group) {
            ?>
            <option value="<?=$group['id']?>" <?=(isset($_GET['groupid']) && $group['id'] == $_GET['groupid']) ? "selected" : ""?>><?=htmlspecialchars($group['name'])?></option>
            <?php
          }
          ?>
        </select>
      </div>
    </div>
    <div class="mb-1.5">
      <label for = "limit_pick">Limit: </label>
      <div class="w-full">
        <input type="number" class="border border-black rounded" id="limit_pick" min = "0" name="limit" value="<?=$limit?>">
      </div>
    </div>
    <input type="submit" value="See Assignments" class="mt-3 rounded bg-sky-300 hover:bg-sky-200 focus:bg-sky-100 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block border border-black">
    
  </form>

  <?php

  if(count($assignments)==0) {
    echo "<p>No assignments to view for this group.</p>";

  } else {
    ?>
  

  <table class="table-auto w-full mt-3" >
    <tr>

      <th>Assignment</th>
      <th>Class</th>
      <th>Notes</th>
      <th>Dates</th>
      <th>Controls</th>
      <th>Edit</th>
    </tr>

  <?php
  }




  foreach ($assignments as $row) {



      ?>
      
        <tr id = 'row_<?=$row['id'];?>'>
      <?php if($_SESSION['userid'] == $row['userCreate']) {?>
        <form method="post" action="">
      <?php }?>
          <td>
            <div class="show_<?=$row['id'];?>">
              <p class="">Assignment Name: <?=htmlspecialchars($row['assignName']);?></p>
            </div>
            <div class="hide hide_<?=$row['id'];?>">
              <input class="w-full" type="text" name="assignName" value = "<?=$row['assignName'];?>">
            </div>
              <p>Type: <?=htmlspecialchars($row['type']);?></p>
                <?php
                if($row['type'] == "mcq") {
                  $quizInfo = getMCQquizInfo($row['quizid']);
                  ?>
                  <p class="">Link: <a class='underline hover:bg-sky-100' target='_blank' href='/mcq/mcq_exercise.php?quizid=<?=$row['quizid']?>'><?=htmlspecialchars($quizInfo['quizName'])?></a></p>
                  <p><a class='underline hover:bg-sky-100' target='_blank' href='/mcq/mcq_assignment_review3.0.php?assignid=<?=$row['id']?>'>Review Assignment</a></p>

                  <?php
    
                }
                //Update below when ready for new assignment types e.g. saq or nde
                else {
                  echo htmlspecialchars($row['quizid']);
                }
              
              ?>
            </div>
            <div class="show_<?=$row['id'];?>">
                <button class="rounded border  px-2 w-1/3  " type="button" name="updateValue" value = "Reuse" onclick="reuseAssignment(<?=$row['id']?>);">Reuse</button>
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
                    echo "<p>".$group['name'];
                    //echo " (".$groupId.")";
                    echo "</p>";
                  }
                }
                ?>
            </div>
            <div class="hide hide_<?=$row['id'];?>">
              <select name="groupid" class="w-full" style="">
                <?php
                  foreach ($groupsList as $group) {
                    ?>
                    <option value="<?=$group['id']?>" <?=($group['id']==$row['groupid']) ? "selected" : ""?>><?=$group['name']?></option>
                    <?php
                  }
                ?>
              </select>
            </div>
          </td>
          <td>
            <div class="show_<?=$row['id'];?>">
              <?=htmlspecialchars($row['notes']);?>
            </div>
            <div class="hide hide_<?=$row['id'];?>">
                <textarea class="w-full" name ="notes"><?=htmlspecialchars($row['notes']);?></textarea>

            </div>
          </td>
          <td>
            <div class="show_<?=$row['id'];?>">
              <p>Due:</p>
          
              <p><?=date("d/m/y g:ia",strtotime($row['dateDue']));?></p>
              <p>Created:</p>
              <p><?=date("d/m/y g:ia", strtotime($row['dateCreated']));?></p>
            </div>
            <div class="hide hide_<?=$row['id'];?>">
              <p>Due:</p>
              <p><input class="w-full" type="datetime-local" name="dateDue" value="<?=$row['dateDue'];?>"></p>
            </div>
          </td>
          <td>
          <div class="show_<?=$row['id'];?>">
            <?php
              if($row['assignReturn'] == "1") {
                echo "<p>Returned</p>";
              } else {
                echo "<p>Not Returned</p>";
              }
            ?>
            <!--
            Review: <?=htmlspecialchars($row['reviewQs']);?>
            <br>
            Multi-Submit: <?=htmlspecialchars($row['multiSubmit']);?>
            <br>
            Returned:<?=htmlspecialchars($row['assignReturn']);?>
            -->
          </div>
          <div class="hide hide_<?=$row['id'];?>">
            <p>
              <input type="radio" id="return_1_<?=$row['id']?>" name="assignReturn" value="1" <?=($row['assignReturn']=="1") ? "checked" : ""?>>
              <label for="return_1_<?=$row['id']?>">Return</label>
            </p>
            <p>
              <input type="radio" id="return_0_<?=$row['id']?>" name="assignReturn" value="0" <?=($row['assignReturn']=="0") ? "checked" : ""?>>
              <label for="return_0_<?=$row['id']?>">No Return</label>
            </p>
            <div class="hidden">
              Review:<input type="text" style="width: 60px;" name="reviewQs" value = "<?=$row['reviewQs'];?>">


              Multi:<input type="text" style="width: 60px;" name="multiSubmit" value = "<?=$row['multiSubmit'];?>">
            </div>


            
          </div>

          </td>

          <td>
            
          <?php if($_SESSION['userid'] == $row['userCreate']) {?>
              <div>
                <button class="rounded border bg-pink-300 px-2 w-full mb-1.5" type ="button" id = "button_<?=$row['id'];?>" onclick = "changeVisibility(this, <?=$row['id']?>); <?=(isset($_GET['assignid'])) ? "resetForm();" : ""?>" >Edit</button>
              </div>
              <div class ="hide hide_<?=$row['id'];?>">
                <input type="hidden" name = "id" value = "<?=$row['id'];?>">

                <input class="rounded border bg-sky-200 px-2 w-full" type="submit" name="updateValue" value = "Update"></input>
              </div>
              
            <?php }?>
          
      <?php if($_SESSION['userid'] == $row['userCreate']) {?>
        </form>
      <?php }?>
            <form id="form_2_<?=$row['id']?>" method = "post" action ="/assign_create1.0.php">
              <input type="hidden" value="<?=$row['quizid']?>" name="exerciseid">
              <input type="hidden" value="<?=$row['type']?>" name="type">
              <input type="hidden" value="" name="groupId">
              <input type="hidden" value="<?=$row['notes']?>" name="notes">
              <input type="hidden" value="<?=$row['dateDue']?>" name="dateDue">
              <input type="hidden" value="<?=$row['assignName']?>" name="assignName">
            </form>
          </td>

        </tr>

        

        <?php
      
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


<?php

  if(isset($_GET['assignid'])) {
    ?>
    let button = document.getElementById("button_<?=$_GET['assignid']?>");
    let id = <?=$_GET['assignid']?>;
    changeVisibility(button, id);
    <?php
  }

?>

function reuseAssignment(input) {
  console.log(input);
  var form = document.getElementById("form_2_"+input);
  form.submit();
}

function resetForm() {
  let form = document.getElementById("control_form");
  form.submit();
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



<?php include ($path."/footer_tailwind.php");  ?>