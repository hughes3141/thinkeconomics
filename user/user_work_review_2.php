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
  /*
  if (!(str_contains($permissions, 'main_admin'))) {
    header("location: /index.php");
  }
  */

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
}

$startDate = "20220901";

$get_selectors = array(
  'groupid' => (isset($_GET['groupid']) && $_GET['groupid']!="") ? $_GET['groupid'] : null,
  'studentid' => (isset($_GET['studentid']) && $_GET['studentid']!="") ? $_GET['studentid'] : null,
  'allstudents' => (isset($_GET['allstudents']) && $_GET['allstudents']!="") ? $_GET['allstudents'] : null,
  'startDate' => (isset($_GET['startDate']) && $_GET['startDate']!="") ? $_GET['startDate'] : $startDate

);

if(is_null($get_selectors['groupid'])) {
  $get_selectors['studentid'] = null;
}

$style_input = "

    td, th { 
      border: 1px solid black;
      padding: 5px;
    }

    table {
      border-collapse: collapse;
    }

    h2 {
      //border-top: 1px solid black;
    }

    .noReturn	{  
      background-color: #FFFF00;
    }

    .noComplete {
      color: red;
    }
 ";

$groupList = getGroupsList($userId);
$studentsSelect = array();

if($get_selectors['groupid']) {
  $studentsSelect = getGroupUsers($get_selectors['groupid']);
}

$students = array();

if($get_selectors['studentid']) {
  array_push($students, $get_selectors['studentid']);
}

if($get_selectors['allstudents']) {
  $students = array();
  foreach($studentsSelect as $student) {
    array_push($students, $student['id']);
  }
}

include($path."/header_tailwind.php");

?>

<!--

$_GET variables:
  startDate: set in 20221203 format; sets date that assignment list starts. Otherwise default as below

  <?=$get_selectors['startDate']?>

-->


<div class=" mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">User Work Review</h1>
  <div class="  mx-auto p-4 mt-2 bg-white text-black mb-5">
    <pre>
      <?php
      if(isset($_GET['test'])) {
        //print_r($groupList);
        //print_r($get_selectors);
        //print_r($studentsSelect);
        print_r($students);
      }
      print_r(getMCQquizResults2(1));
      
      ?>
    </pre>
    

    <form method="get" action="">
      <select name="groupid">
        <option value=""></option>
        <?php
        foreach($groupList as $group) {
          ?>
          <option value="<?=$group['id']?>" <?=($get_selectors['groupid'] == $group['id']) ? "selected" : ""?>><?=$group['name']?></option>
          <?php
        }
        ?>
      </select>

      <?php
      if($get_selectors['groupid']) {
        ?>
        <select name="studentid">
          <option value=""></option>
          <?php
          foreach($studentsSelect as $student) {
            ?>
            <option value="<?=$student['id']?>" <?=($get_selectors['studentid'] == $student['id']) ? "selected" : ""?>><?=$student['name_first']?> <?=$student['name_last']?></option>
            <?php
          }
          ?>
        </select>
        <input id="allstudents_select" type="checkbox" name="allstudents" value="1" <?=($get_selectors['allstudents']) ? "checked" : ""?>>
        <label for="allstudents_select">Select All</label>
        <?php
      }
      ?>
    <button>Select</button>

    </form>

    <?php
    //echo count($students);
    //print_r($students);
    if(count($students)>0) {
      ?>
      <h2>Class Summary</h2>
      <?php
      foreach ($students as $studentid) {
        $student = getUserInfo($studentid);
        print_r($student);

        $groupid_array = array();
        if($student['groupid_array'] != "") {
          $groupid_array = json_decode($student['groupid_array']);
        }

        $assignments = getAssignmentsArray($groupid_array, $get_selectors['startDate'], 1);
        echo "<pre>";
        print_r($assignments);
        echo "</pre>";
        ?>
        <h3><?=$student['name_first']?> <?=$student['name_last']?></h3>
        <table>
          <tr>
            <td>Assignment</td>
            <td>Due Date</td>
            <td>Type</td>
            <td>Scores</td>
            <td>Link</td>
          </tr>
          <?php
          foreach ($assignments as $assignment) {
            ?>
            <tr>
              <td><?=$assignment['assignName']?></td>
              <td><?=date("j M y",strtotime($assignment['dateDue']))?></td>
              <td><?php
                if($assignment['type'] == 'mcq') {
                  echo "MCQ";
                }
              ?></td>
              <td><?php
                if($assignment['type'] == "mcq") {
                  $responses = getMCQquizResultsByAssignment($assignment['id']);
                  print_r($responses);
                }
              ?></td
            </tr>
            <?php
          }
          ?>
        </table>
        
        <?php
      }
    }
    ?>
  </div>
</div>

<?php   include($path."/footer_tailwind.php");?>