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
  //$schoolId = $userInfo['schoolid'];
  $permissions = $userInfo['permissions'];
  if (!(str_contains($permissions, 'teacher'))) {
    header("location: /index.php");
  }
  $groupsList = getGroupsList($userId, true, $userId);
  //print_r($groupsList);
  $hasGroups = 0;
  if(count($groupsList)>0) {
    $hasGroups = 1; }
}


$style_input = ".hide {
  display: none;
  }
  textarea {
    border: 1px solid black;
  }
  td, th {
    padding: 5px;
  }

  
  ";
  $selectedGroupId = "";

  $className_err = $subject_err = $optionGroup_err = $finishDate_err = $teacherInput_error = "";

  if($_SERVER['REQUEST_METHOD']==='POST') {
    
    if($_POST['submit'] == "Select Group" ) {
      $selectedGroupId = $_POST['groupId'];

    }

    if($_POST['submit'] == "Add Teacher") {
      $selectedGroupId = $_POST['groupId'];
      updateGroupTeachers($selectedGroupId, $_POST['teacherId']);
    }

    if($_POST['submit'] == "Add Student") {
      $selectedGroupId = $_POST['groupId'];
      if(isset($_POST['studentId'])) {
        updateStudentGroup($selectedGroupId, $_POST['studentId']);
      }
    }

    if($_POST['submit'] == "Remove Student") {
      $selectedGroupId = $_POST['groupId'];
      updateStudentGroup($selectedGroupId, $_POST['id'], "remove");
      
    }

    if($_POST['submit'] == "Remove Teacher") {
      $selectedGroupId = $_POST['groupId'];
      $groupInfo = getGroupInfoById($selectedGroupId);
      $userCreate = $groupInfo['userCreate'];
      if($_POST['id'] != $userCreate) {
        updateGroupTeachers($selectedGroupId, $_POST['id'], "remove");
      }
    }

    if($_POST['submit'] == "Edit Group Details") {



      if(empty(trim($_POST['name']))) {
        $className_err = "Class Name cannot be blank";
      }

      if(empty(trim($_POST['subjectId']))) {
        $subject_err = "Subject field required";
      }

      if(empty(trim($_POST['dateFinish']))) {
        $finishDate_err = "Finish Date Field Required";
      }

      $selectedGroupId = $_POST['groupId'];

      if($className_err == "" AND $subject_err == "" AND $optionGroup_err == "" AND $finishDate_err == "" AND $teacherInput_error == "") {

        updateGroupInformation($selectedGroupId, $_POST['name'], $_POST['subjectId'], $_POST['optionGroup'], $_POST['dateFinish'], $_POST['examBoard']);
        
      }
      
    }


  }

include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Class Manager</h1>
    <div class= "container mx-auto mt-2 bg-white text-black mb-5 p-4">
      <?php
        //echo $userId;
        //print_r($userInfo);
        if($_SERVER['REQUEST_METHOD']==='POST') {
          //print_r($_POST);
        }

      if($hasGroups ==1) {

      ?>
      <p class="mb-1 ">This page allows you to manage the classes that you have set up in this platform.</p>
      <p class="bg-pink-300 mb-1 rounded pl-1">Teacher: <?=$userInfo['name_first']." ".$userInfo['name_last']?></p>
      <div class="w-full mb-1.5">
        <label>Class:</label>
          <div>
            <form method="post" action="">
              <select name="groupId" class="w-full rounded border border-black">
                <option value =""></option>
                  <?php
                    $results = getGroupsList($userId, true, $userId);
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
                <input type="submit" name="submit" value="Select Group" class="mt-3 rounded bg-sky-300 hover:bg-sky-200 focus:bg-sky-100 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block border border-black">
              </select>
              <?php
                //print_r($results);
                ?>
            </form>
          </div>
      </div>



  <?php
  if($selectedGroupId != "") {
    $groupUsers = getGroupUsers($selectedGroupId);
    $groupInfo = getGroupInfoById($selectedGroupId);
    $groupSchoolId = $groupInfo['school'];
    $groupUserCreate = $groupInfo['userCreate'];
    $groupName = $groupInfo['name'];
    echo "<pre>";
    //print_r($groupUsers);
    //print_r($groupInfo);
    echo "</pre>";

        
      ?>
      <h2 class="bg-pink-300 rounded pl-1 mb-1">Group Details</h2>

      <form method="post" action="">
        <div class = "grid md:grid-cols-2 gap-2">
          <div>
            <label>Class Name:<label>
              <div class="w-full mb-1.5">
                <input class="rounded border border-black w-full" type="text" name="name" value ="<?=$groupName?>">
              </div>
              <div class=" mt-1 pl-2 text-red-600 bg-lime-300 rounded">
                  <?= $className_err?>
              </div>
          </div>
          <div>
            <label>Subject:<label>
              <div class="w-full mb-1.5">
                <select name="subjectId" class="rounded border border-black w-full">
                  <option value=""></option>
                  <?php
                  $results = listSubjects();
                  foreach($results as $result) {
                    $selected = "";
                    if($result['id'] == $groupInfo['subjectId']) {
                      $selected = "selected";
                    }
                    ?>
                    <option value="<?=$result['id']?>" <?=$selected?>><?=$result['name']?></option>
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
              <div>
                <input class="rounded border border-black w-full" type="text" name="optionGroup" value ="<?=$groupInfo['optionGroup']?>">
              </div>
          </div>
          <div class="w-full mb-1.5">
                <label>Exam Board:<label>
                  <div class="">
                    <select name="examBoard" class="rounded border border-black w-full" value ="<?=""?>">
                      <option></option>
                      <option <?=($groupInfo['examBoard']=="AQA") ? 'selected' : ''?> value="AQA">AQA</option>
                      <option <?=($groupInfo['examBoard']=="Edexcel") ? 'selected' : ''?> value="Edexcel">Edexcel</option>
                      <option <?=($groupInfo['examBoard']=="OCR") ? 'selected' : ''?> value="OCR">OCR</option>
                      <option <?=($groupInfo['examBoard']=="Eduqas") ? 'selected' : ''?> value="Eduqas">Eduqas</option>
                      <option <?=($groupInfo['examBoard']=="WJEC") ? 'selected' : ''?> value="WJEC">WJEC</option>
                    </select>
                  </div>
              </div>
          <div class="w-full mb-1.5">
            <label>Finish Date:<label>
              <div>
                <input class="rounded border border-black w-full" type="date" name="dateFinish" value ="<?=$groupInfo['dateFinish']?>">
              </div>
              <div class=" mt-1 pl-2 text-red-600 bg-lime-300 rounded">
                  <?= $finishDate_err?>
              </div>
          </div>
        </div>
        <div>
          <input type ="hidden" name="groupId" value="<?=$selectedGroupId?>">
          <input type="submit" name="submit" value="Edit Group Details" class="mt-3 rounded bg-sky-300 hover:bg-sky-200 focus:bg-sky-100 focus:shadow-sm focus:ring-4 focus:ring-sky-200 focus:ring-opacity-50 text-white w-full py-2.5 text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block border border-black">
        </div>

      </form>

    <div class="grid md:grid-cols-2 gap-2 mt-2"> 
      <div>
        <h2 class="bg-pink-300 rounded pl-1 mb-1">Teachers</h2>
        <table class="w-full  border border-black table-fixed mb-2">
          <tr>
            <th class="border border-black">Teacher</th>
            <th class="border border-black">Edit</th>
            
          </tr>
          <?php
            $groupTeachers = ($groupInfo['teachers']);
            foreach ($groupTeachers as $user) {
              //echo $user;
              $teacherName = getUserInfo($user);
              $teacherName = $teacherName['name_first']." ".$teacherName['name_last'];
              ?>
              <tr>
                <form method="post" action ="">
                  <td class="text-center border border-black"><?=$teacherName?></td>
                  <td class="border border-black">
                    <div>
                      <button class="w-full rounded bg-sky-300 hover:bg-sky-200 border border-black" type ="button" id = "button_<?=$user?>" onclick = "changeVisibility(this, <?=$user?>)"">Edit</button>
                    </div>
                    <div class ="hide hide_<?=$user?>">
                      <input type="hidden" name = "id" value = "<?=$user?>">
                      <input type ="hidden" name="groupId" value="<?=$selectedGroupId?>">
                      <input class="w-full rounded bg-pink-300 hover:bg-pink-200 border border-black mt-2 disabled:text-slate-500 disabled:bg-pink-300" type="submit" name ="submit" value = "Remove Teacher" <?=($user == $groupUserCreate) ? "disabled" : ""?>></input>
                    </div>
                  </td>
              </form>
              </tr>
              <?php

            }

          ?>
        </table>
        <form method="post" action ="">

        <?php
          //print_r($groupTeachers);

          $results = getTeachersBySchoolId($groupSchoolId);
          $notGroupTeachers = array();
          foreach($results as $result) {
            if (!in_array($result['id'], $groupTeachers)) {
              array_push($notGroupTeachers, $result);
            }
          }

          //print_r($notGroupTeachers);
          if (count($notGroupTeachers)>0) {
            ?>
            <label>Add Teacher:</label>
            <div>
            <select class="border border-black rounded w-full" name="teacherId">
              <?php
                foreach($notGroupTeachers as $result) {
                  ?>
                    <option value="<?=$result['id']?>"><?=$result['name_first']?> <?=$result['name_last']?></option> 
                  <?php
                  }
                  ?>
            </select>
            </div>
            <input type ="hidden" name="groupId" value="<?=$selectedGroupId?>">
            <input class="w-full rounded bg-pink-300 hover:bg-pink-200 border border-black mt-2 disabled:text-slate-500 disabled:bg-pink-300" type="submit" name="submit" value="Add Teacher">
          <?php
          }

          ?>

        </form>
      </div>
      <div>

        <h2 class="bg-pink-300 rounded pl-1 mb-1">Students</h2>
        <table class="w-full  border border-black table-fixed mb-2">
          <tr>
            <th class="border border-black">Student</th>
            <th class="border border-black">Edit</th>
            
          </tr>
          <?php
            $classMembers = array();
            foreach ($groupUsers as $user) {
              array_push($classMembers, $user['id']);
              ?>
              <tr>
                <form method="post" action="">
                  <td class="text-center border border-black"><?=$user['name_first']?> <?=$user['name_last']?></td>
                  <td class="border border-black">
                    <div>
                        <button class="w-full rounded bg-sky-300 hover:bg-sky-200 border border-black" type ="button" id = "button_<?=$user['id']?>" onclick = "changeVisibility(this, <?=$user['id']?>)"">Edit</button>
                      </div>
                      <div class ="hide hide_<?=$user['id']?>">
                        <input type="hidden" name = "id" value = "<?=$user['id']?>">
                        <input type ="hidden" name="groupId" value="<?=$selectedGroupId?>">
                        <input class="w-full rounded bg-pink-300 hover:bg-pink-200 border border-black mt-2 disabled:text-slate-500 disabled:bg-pink-300" type="submit" name ="submit" value = "Remove Student" <?=($user['id'] == $groupUserCreate) ? "disabled" : ""?>></input>
                      </div>
                  </td>
                </form>
              </tr>
              <?php
            }
          ?>
        </table>
        <form method="post" action ="">
          <label>Add Student:</label>
          <div>
            <select class="border border-black rounded w-full" name="studentId">
              <?php
                  $results = getSchoolUsers($groupSchoolId);

                  
                  foreach($results as $result) {
                    if(!str_contains($result['groupid_array'], '"'.$selectedGroupId.'"')) {
                    ?>
                      <option value="<?=$result['id']?>"><?=$result['name_first']?> <?=$result['name_last']?></option> 
                    <?php
                    }
                  }
              ?>
            </select>
          </div>
          <input type ="hidden" name="groupId" value="<?=$selectedGroupId?>">
          <input class="w-full rounded bg-pink-300 hover:bg-pink-200 border border-black mt-2 disabled:text-slate-500 disabled:bg-pink-300" type="submit" name="submit" value="Add Student">
        </form>
      </div>
    </div>
    

    <?php
    }

  }

  if ($hasGroups == 0) {
    ?>
    <p>You need to make some classes before you can manage them!</p>
    <p>Go to <a href="class_creator.php" class="text-cyan-700 underline hover:bg-sky-300">Class Creator</a> to make some new classes.</p>
    <?php
  }
  
    ?>
</div>
</div>


<?php   include($path."/footer_tailwind.php");?>