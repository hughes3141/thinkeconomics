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

  <table class="w-full mt-3">
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

  ?>
  </table>
  <?php

}


if(isset($updateMessage)) {
  echo $updateMessage;
}
?>

</form>


<script>
  </script>

<?php     include($path."/footer_tailwind.php");?>