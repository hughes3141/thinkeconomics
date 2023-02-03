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

if($_SERVER['REQUEST_METHOD']==='POST') {
  //Create array from teachers:
  $teachers = array();
  for($x=0; $x<$_POST['teacher_count']; $x++) {
    if(isset($_POST['teacher_'.$x])) {
      array_push($teachers, $_POST['teacher_'.$x]);
    }
  }
  //print_r($teachers);
  createGroup($userId, $_POST['name'], $_POST['subjectId'], $userInfo['schoolid'], $teachers, $_POST['dateFinish'],  $_POST['optionGroup']);

}

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">New Class Creator</h1>
    <div class=" container mx-auto  mt-2 bg-white text-black mb-5 p-4">
      <?php
      //print_r($userInfo);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //print_r($_POST);
      }
      ?>
      
      <?php
      if($hasSchool == 1) {
        ?>
          
          <form method="post" action="">
            <div class="w-full mb-1.5">
              <label>Class Name:<label>
                <div class="mt-1.5">
                  <input type="text" name="name" class="rounded border border-black w-full px-3 py-2 text-sm" placeholder="Class Name">
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
                        <option value="<?=$result['id']?>"><?=$result['level']?> <?=$result['name']?></option>
                        <?php
                        }
                        ?>
                    </select>
                  </div>
              </div>
              <div class="w-full mb-1.5">
                <label>Option Group:<label>
                  <div class="mt-1.5">
                    <input type="text" name="optionGroup" class="rounded border border-black w-full text-sm" placeholder="e.g. A, B, C, etc">
                  </div>
              </div>
              <div class="w-full mb-1.5">
                <label>Finish Date:<label>
                  <div class="mt-1.5">
                    <input type="date" name="dateFinish" class="rounded border border-black w-full text-sm">
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

                      <input type="checkbox" id="checkbox_<?=$result['id']?>" name = "teacher_<?=$row?>" value = "<?=$result['id']?>" <?=($result['id'] == $userId) ? "checked " : ""?>></input>
                      <label for = "checkbox_<?=$result['id']?>"><?=$result['name_first']?> <?=$result['name_last']?></label>

                    </div>
                    <?php
                  }
                  ?>

              </div>
                  <input type="hidden" name="teacher_count" value="<?=count($results)?>">
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

