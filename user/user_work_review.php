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

$startDate = "20230901";

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
      //print_r(getMCQquizResults2(1));
      //print_r($get_selectors);
      
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
      <input type="date" name="startDate" value="<?=date("Y-m-d", strtotime($get_selectors['startDate']))?>">
    <button class="w-full bg-pink-300 rounded border border-black my-2" >Select</button>

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
        //print_r($student);

        $groupid_array = array();
        if($student['groupid_array'] != "") {
          $groupid_array = json_decode($student['groupid_array']);
        }

        $assignments = getAssignmentsArray($groupid_array, $get_selectors['startDate'], 1);
        echo "<pre>";
        //print_r($assignments);
        echo "</pre>";
        ?>
        <div>
          <h3 class="text-lg bg-pink-300 text-sky-700 pl-1 rounded-r-lg mt-1 sticky top-12 lg:top-20"><?=$student['name_first']?> <?=$student['name_last']?></h3>
          <h4 class="bg-sky-200 pl-1 my-2 rounded-r-lg">Assignment Summary</h4>

          <?php
            include("user_assignment_list_embed.php");
          ?>

          <h4 class="bg-sky-200 pl-1 my-2 rounded-r-lg">FlashCard Summary</h4>
          <?php
            $userid_selected = $studentid;
            $flashcards = flashCardSummary($userid_selected, "count");
            //print_r($flashcards);
            echo "<p>Total Completed: ".$flashcards[0]['count']."</p>";

            $flashcards = flashCardSummary($userid_selected, "count_category");
            //print_r($flashcards);
            //echo "<br>";
            echo "<p>Categories: </p>";
            echo "<ul class='list-disc'>";
            foreach($flashcards as $array) {
              //print_r($array);
              echo "<li class='ml-5'>";
              if ($array['gotRight']==0) {
                echo "Didn't Know: ";
              } elseif ($array['gotRight']==1) {
                echo "Incorrect : ";
              } elseif ($array['gotRight']==2) {
                echo "Correct: ";
              }
              echo $array['count'];
              echo "</li>";
              
            }


              $flashcards = flashCardSummary($userid_selected, "average");
              //print_r($flashcards);
              echo "Average time taken: ".$flashcards[0]['avg']." seconds<br>";

              $flashcards = flashCardSummary($userid_selected, "count_by_date");
              //print_r($flashcards);
              echo "Dates Completed: ";
              foreach($flashcards as $array) {
                echo $array['date'].": ".$array['count']." || ";
              }

          ?>

          <h4 class="bg-sky-200 pl-1 my-2 rounded-r-lg">MCQ Summary</h4>
          
          <?php
            $results = getMCQquizResults2($studentid,0);
            ?>
            <p>Completed: <?=count($results)?></p>
            <?php

            //print_r($results);
            if(count($results)>0) {
              echo "Instances: ";
              ?>
              <div class="">
                <?php
                foreach($results as $key => $result) {
                  //echo "<div class='border border-black'>";
                  echo ($result['topic'] != "") ? $result['topic']." " : "";
                  echo $result['quiz_name'];
                  echo " ".date("d.m.y",strtotime($result['datetime']));
                  echo " ".$result['duration']."m";
                  if($key < count($results)-1) {
                    //echo " || ";
                    echo "<br>";
                  }
                  //echo "</div>";
                }
                ?>
              </div>
              <?php
            }
            ?>
            

        </div>
        <?php
      }
    }
    ?>
  </div>
</div>

<?php   include($path."/footer_tailwind.php");?>