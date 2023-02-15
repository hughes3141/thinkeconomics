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
  //print_r($userInfo);
  $hasSchool = 0;
  if ($userInfo['schoolid'] != "") {
    $hasSchool = 1;
  }
}

$style_input = ".hide {
  display: none;
  }

  td, th {
    padding: 5px;
  
  ";





include($path."/header_tailwind.php");

  //Set default error messages

  $className_err = $subject_err = $optionGroup_err = $finishDate_err = $teacherInput_error = "";
  $className = $subjectId = $optionGroup = $finishDate = $teachers = "";
  $success_message = "";


  //Automatically set date for next 31 July:

    $now = new DateTime();
    $targetMonth = 7;
  
    if ($now->format('m') >= $targetMonth) {
        $nextJuly31 = new DateTime($now->format('Y') + 1 . '-07-31');
    } else {
        $nextJuly31 = new DateTime($now->format('Y') . '-07-31');
    }
    
    $nextJuly31 = $nextJuly31->format('Y-m-d');
    //echo $nextJuly31;

    $finishDate = $nextJuly31;
    //echo $finishDate;


if($_SERVER['REQUEST_METHOD']==='POST') {
  //Create array from teachers:
  $teachers = array();
  for($x=0; $x<$_POST['teacher_count']; $x++) {
    if(isset($_POST['teacher_'.$x])) {
      array_push($teachers, $_POST['teacher_'.$x]);
    }
  }
  //print_r($teachers);
  $className = $_POST['name'];
  $subjectId =$_POST['subjectId'];
  $optionGroup = $_POST['optionGroup'];
  $finishDate = $_POST['dateFinish'];

  if(empty(trim($_POST['name']))) {
    $className_err = "Please enter a class name";
  }

  if(empty(trim($_POST['subjectId']))) {
    $subject_err = "Please enter a subject";
  }

  if(empty(trim($_POST['dateFinish']))) {
    $finishDate_err = "Please enter a finish date for this class";
  }

  if(count($teachers) < 1) {
    $teacherInput_error = "You must have at least one teacher selected";
  }

  if($className_err == "" AND $subject_err == "" AND $optionGroup_err == "" AND $finishDate_err == "" AND $teacherInput_error == "") {
    createGroup($userId, $_POST['name'], $_POST['subjectId'], $userInfo['schoolid'], $teachers, $_POST['dateFinish'],  $_POST['optionGroup']);
    $success_message = "New class created successfully";

  }

}






?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">New Class Creator</h1>
    <div class=" container mx-auto  mt-2 bg-white text-black mb-5 p-4">
      <?php
        //print_r($userInfo);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //print_r($_POST);
        echo $success_message;
      }
      ?>
      
      <?php
      if($hasSchool == 1) {
        ?>
          
          <form method="post" action="">
            <div class="w-full mb-1.5">
              <label>Class Name:<label>
                <div class="mt-1.5">
                  <input type="text" name="name" class="rounded border border-black w-full px-3 py-2 text-sm" placeholder="Class Name" value="<?=$className?>">
                </div>
                <div class=" mt-1 pl-2 text-red-600 bg-lime-300 rounded">
                  <?= $className_err?>
                </div>
            </div>
            <div class="md:flex  md:space-y-0 md:space-x-4 mb-1.5">
              <div class="w-full mb-1.5">
                <label>Subject:<label>
                  <div class="mt-1.5">
                    <select name="subjectId" class="rounded border border-black w-full px-3 py-2 text-sm">
                      <option value=""></option>
                      <?php
                      $results = listSubjects();
                      foreach($results as $result) {
                        ?>
                        <option value="<?=$result['id']?>" <?= $result['id']==$subjectId ? "selected" : ""?>><?=$result['level']?> <?=$result['name']?></option>
                        <?php
                        }
                        ?>
                    </select>
                  </div>
                  <div class=" mt-1 pl-2 text-red-600 bg-lime-300 rounded">
                  <?= $subject_err?>
                </div>
              </div>
              <div class="w-full mb-1.5">
                <label>Option Group:<label>
                  <div class="mt-1.5">
                    <input type="text" name="optionGroup" class="rounded border border-black w-full text-sm" placeholder="e.g. A, B, C, etc" value = "<?=$optionGroup?>">
                  </div>
                  <div class=" mt-1 pl-2 text-red-600 bg-lime-300 rounded">
                  <?= $optionGroup_err?>
                </div>
              </div>
              <div class="w-full mb-1.5">
                <label>Finish Date:<label>
                  <div class="mt-1.5">
                    <input type="date" name="dateFinish" class="rounded border border-black w-full text-sm" value ="<?=$finishDate?>">
                  </div>
                  <div class=" mt-1 pl-2 text-red-600 bg-lime-300 rounded">
                  <?= $finishDate_err?>
                </div>
              </div>
            </div>
            <div class="mb-1.5">
              <?php
                    $results = getTeachersBySchoolId($userInfo['schoolid']);
                    //print_r($results);
                    ?>
              <label>Class Teacher<?=(count($results)>1) ? "s" : ""?>:</label>
              <div class="grid sm:grid-cols-2 md:grid-cols-4">

                  <?php
                  foreach($results as $row=>$result) {
                    ?>
                    <div>

                      <input type="checkbox" id="checkbox_<?=$result['id']?>" name = "teacher_<?=$row?>" value = "<?=$result['id']?>" <?php
                        if ($teachers == "") {
                          if ($result['id'] == $userId) {
                            echo "checked";
                          }
                        } else if (in_array($result['id'], $teachers)) {
                          echo "checked";
                        }
                        ?>></input>
                      <label for = "checkbox_<?=$result['id']?>"><?=$result['name_first']?> <?=$result['name_last']?></label>

                    </div>
                    <?php
                  }
                  ?>

              </div>
              <input type="hidden" name="teacher_count" value="<?=count($results)?>">
              <div class=" mt-1 pl-2 text-red-600 bg-lime-300 rounded">
                <?= $teacherInput_error?>
              </div>
            </div>

            <input class= "mt-3 rounded bg-sky-500 hover:bg-sky-400 focus:bg-sky-200 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block" type="submit" name="submit" value="Create New Class">
          </form>
        <?php
      }

      if ($hasSchool == 0) {
        ?>
        <p>You need to make register to a school before you can create a class!</p>
        <p>Go to <a href="school_registration.php" class="text-cyan-700 hover:underline">School Registration</a> to register your account to a school.</p>
        <?php

      }
      ?>

    </div>
</div>




<?php   include($path."/footer_tailwind.php");?>

