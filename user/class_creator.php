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
}

$style_input = ".hide {
  display: none;
  }
  input, button, textarea, th, td {
    border: 1px solid black;
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
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <?php
      //print_r($userInfo);
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //print_r($_POST);
      }
      ?>
      <h2>Create a New Class</h2>
        <form method="post" action="">
          <label>Class Name:<label>
          <input type="text" name="name">
          <br>
          <label>Subject:<label>
          <select name="subjectId">
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
          <br>
          <label>Option Group:<label>
          <input type="text" name="optionGroup">
          <br>
          <?php
            $results = getTeachersBySchoolId($userInfo['schoolid']);
            //print_r($results);
            ?>
          <label>Class Teacher<?=(count($results)>1) ? "s" : ""?>:</label>
          <ul>
            <?php
            foreach($results as $row=>$result) {
              ?>
              <ul>
                <input type="checkbox" id="checkbox_<?=$result['id']?>" name = "teacher_<?=$row?>" value = "<?=$result['id']?>" <?=($result['id'] == $userId) ? "checked " : ""?>></input>
                <label for = "checkbox_<?=$result['id']?>"><?=$result['name_first']?> <?=$result['name_last']?></label>
              </ul>
              <?php
            }
            ?>
            </ul>
              <input type="hidden" name="teacher_count" value="<?=count($results)?>">
            <?php
          ?>
          <br>
          <label>Finish Date:<label>
          <input type="date" name="dateFinish">
          <br>
          <input type="submit" name="submit" value="Create New Class">
        </form>

    </div>
</div>




<?php   include($path."/footer_tailwind.php");?>

