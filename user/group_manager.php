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
}


$style_input = ".hide {
  display: none;
  }
  input, button, textarea, th, td, select {
    border: 1px solid black;
  }
  td, th {
    padding: 5px;
  }

  
  ";
  $selectedGroupId = "";
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
      updateStudentGroup($selectedGroupId, $_POST['studentId']);
      
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

    if($_POST['submit'] == "Edit Details") {
      $selectedGroupId = $_POST['groupId'];

        updateGroupInformation($selectedGroupId, $_POST['name'], $_POST['subjectId'], $_POST['optionGroup'], $_POST['dateFinish']);
      
    }


  }

include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">Group (Classes) Manager</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <?php
        //echo $userId;
        //print_r($userInfo);
        if($_SERVER['REQUEST_METHOD']==='POST') {
          //print_r($_POST);
        }

      ?>
      <p>This page allows you to manage the groups (classes) that you have set up in this platform.</p>
      <p>Name: <?=$userInfo['name_first']." ".$userInfo['name_last']?></p>
      <p>Group:
        <form method="post" action="">
          <select name="groupId">
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
              <input type="submit" name="submit" value="Select Group">
            </select>
          </form>
      </p>

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
      <h2>Group Details</h2>
        <form method="post" action="">
          <p>
            <label>Class Name:<label>
            <input type="text" name="name" value ="<?=$groupName?>">
          </p>
          <p>
            <label>Subject:<label>
            <select name="subjectId">
              <option value=""></option>
              <?php
              $results = listSubjects();
              foreach($results as $result) {
                $selected = "";
                if($result['id'] == $groupInfo['subjectId']) {
                  $selected = "selected";
                }
                ?>
                <option value="<?=$result['id']?>" <?=$selected?>><?=$result['level']?> <?=$result['name']?></option>
                <?php
              }
              ?>
            </select>
          </p>
          <p>
            <label>Option Group:<label>
            <input type="text" name="optionGroup" value ="<?=$groupInfo['optionGroup']?>">
          </p>
          <p>
            <label>Finish Date:<label>
            <input type="date" name="dateFinish" value ="<?=$groupInfo['dateFinish']?>">
          </p>
          <p>
            <input type ="hidden" name="groupId" value="<?=$selectedGroupId?>">
            <input type="submit" name="submit" value="Edit Details">
          </p>
          </form>
      <h2>Teachers</h2>
      <table>
        <tr>
          <th>Teacher</th>
          <th>Edit</th>
          
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
                <td><?=$teacherName?></td>
                <td>
                  <div>
                    <button type ="button" id = "button_<?=$user?>" onclick = "changeVisibility(this, <?=$user?>)"">Edit</button>
                  </div>
                  <div class ="hide hide_<?=$user?>">
                    <input type="hidden" name = "id" value = "<?=$user?>">
                    <input type ="hidden" name="groupId" value="<?=$selectedGroupId?>">
                    <input type="submit" name ="submit" value = "Remove Teacher" <?=($user == $groupUserCreate) ? "disabled" : ""?>></input>
                  </div>
                </td>
             </form>
            </tr>
            <?php

          }

        ?>
      </table>
      <form method="post" action ="">
        <label>Add Teacher:</label>
        <select name="teacherId">
          <?php
              $results = getTeachersBySchoolId($groupSchoolId);
              
              foreach($results as $result) {
                print_r($result);
                if ($groupUserCreate != $result['id']) {
                ?>
                  <option value="<?=$result['id']?>"><?=$result['name_first']?> <?=$result['name_last']?></option> 
                <?php
                }
              }
          ?>
        </select>
        <input type ="hidden" name="groupId" value="<?=$selectedGroupId?>">
        <input type="submit" name="submit" value="Add Teacher">
      </form>

      <h2>Students</h2>
      <table>
        <tr>
          <th>Student</th>
          <th>Edit</th>
          
        </tr>
        <?php
          $classMembers = array();
          foreach ($groupUsers as $user) {
            array_push($classMembers, $user['id']);
            ?>
            <tr>
              <form method="post" action="">
                <td><?=$user['name_first']?> <?=$user['name_last']?></td>
                <td>
                  <div>
                      <button type ="button" id = "button_<?=$user['id']?>" onclick = "changeVisibility(this, <?=$user['id']?>)"">Edit</button>
                    </div>
                    <div class ="hide hide_<?=$user['id']?>">
                      <input type="hidden" name = "id" value = "<?=$user['id']?>">
                      <input type ="hidden" name="groupId" value="<?=$selectedGroupId?>">
                      <input type="submit" name ="submit" value = "Remove Student" <?=($user['id'] == $groupUserCreate) ? "disabled" : ""?>></input>
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
        <select name="studentId">
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
        <input type ="hidden" name="groupId" value="<?=$selectedGroupId?>">
        <input type="submit" name="submit" value="Add Student">
      </form>
      <?php
      }
      ?>
</div>
</div>


<?php   include($path."/footer_tailwind.php");?>