<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$downloadPermissions = null;
$userId = null;
$permissions = '';

if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");

}

else {
  $userId = $_SESSION['userid'];
  $userInfo = getUserInfo($_SESSION['userid']);
  $userType = $userInfo['usertype'];
  $permissions = $userInfo['permissions'];
  /*
  if((str_contains($permissions, "news_article_download") || str_contains($userInfo['school_permissions'], "news_article_download"))) {
    $downloadPermissions = 1;
  }
  */
  
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
  
}

$style_input = "

td, th {
	
	border: 1px solid black;
	padding: 5px;
}

table {
	
	border-collapse: collapse;
}
";

$changedResponses = array();
$messageSummary =array();

$students = getUsercreateUsers($userId);

$studentId = null;
if(!empty($_GET['studentId'])) {
  $studentId = $_GET['studentId'];
}
$studentInfo = getUserInfo($studentId);
$student = $studentInfo;

$groupid_array = array();
if(!is_null($studentId)) {
  if($studentInfo['groupid_array'] != "") {
    $groupid_array = json_decode($studentInfo['groupid_array']);
  } 
}

$studentTeachers = array();
foreach($groupid_array as $group) {
  $group = getGroupInfoById($group);
  $teachers = $group['teachers'];
  foreach($teachers as $teacher) {
    if(!in_array($teacher, $studentTeachers)) {
      array_push($studentTeachers, $teacher);
    }
  }
}
$teacherPermissionValidate = null;
if(in_array($userId, $studentTeachers)) {
  $teacherPermissionValidate = 1;
}

if($_SERVER['REQUEST_METHOD']=='POST') {
  if($_POST['submit'] == "Assign Responses" && $teacherPermissionValidate == 1) {
    if($_POST['ids'] != "") {
      $changedResponses = explode(",",$_POST['ids']);
      foreach($changedResponses as $response) {
        $message = updateMCQquizResults($response, $_POST['assignId_'.$response]);
        array_push($messageSummary, $message);

      }
    }
  }

}

$get_selectors = array(
  'groupId' => (isset($_GET['groupId']) && $_GET['groupId'] != "") ? $_GET['groupId'] : null,

  'studentId' => (!empty($_GET['studentId'])) ? $_GET['studentId'] : null,


  'topic' => (isset($_GET['topic']) && $_GET['topic'] != "") ? $_GET['topic'] : null,
  'keyword' => (isset($_GET['keyword']) && $_GET['keyword'] != "") ? $_GET['keyword'] : null,
  'startDate' => (isset($_GET['startDate']) && $_GET['startDate'] != "") ? $_GET['startDate'] : null,
  'endDate' => (isset($_GET['endDate']) && $_GET['endDate'] != "") ? $_GET['endDate'] : null,
  'orderBy' => (isset($_GET['orderBy']) && $_GET['orderBy'] != "") ? $_GET['orderBy'] : null,
  'limit' => (isset($_GET['limit']) && $_GET['limit'] != "") ? $_GET['limit'] : 100,
  'searchFor' => (isset($_GET['searchFor']) && $_GET['searchFor'] != "") ? $_GET['searchFor'] : "",
  'noSearch' => (isset($_GET['noSearch']) ) ? 1 : null,
  'link' => (isset($_GET['link']) && $_GET['link'] != "") ? $_GET['link'] : "",
  'searchBar' => (isset($_GET['searchBar']) ) ? 1 : null,
  'video' => (isset($_GET['video'])) ? 1 : null,
  'audio' => (isset($_GET['audio'])) ? 1 : null

);





$startDate = "20200901";

$groupid_array_compare = array($get_selectors['groupId']);



$assignments = getAssignmentsArray($groupid_array, $startDate, 1);



include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 pt-20 lg:pt-32 xl:pt-20">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 mb-2">Assignment Switch</h1>
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
    <?php
      //echo "<pre>";
      //print_r($_POST);
      //print_r($messageSummary);
      //print_r($studentInfo);
      //print_r($groupid_array);
      //print_r($studentTeachers);
      //print_r($students);
      //echo $teacherPermissionValidate;
      //echo "</pre>";

      foreach($messageSummary as $message) {
        ?>
        <p><?=$message?></p>
        <?php
      }

    ?>
    <h2 class="text-lg my-2 p-1 bg-sky-200 rounded">Select Student and Group</h2>
    <form method="get" action="">
      <p class="mb-1"><label for="studentIdInput">Student:</label></p>
      <p class="mb-1">
        <select name="studentId" id="studentIdInput">
          <option></option>
          <?php
          foreach($students as $row) {
            ?>
            <option value="<?=$row['id']?>" <?=$get_selectors['studentId'] == $row['id'] ? 'selected' : ''?>><?=$row['name_first']?> <?=$row['name_last']?></option>
            <?php
          }
          ?>
        </select>
      </p>
        <?php
        if(isset($get_selectors['studentId'])) {
          $groups = getGroupsList($userId);
          //print_r($groups);
        ?>
          <p class="mb-1"><label for="groupIdInput">Group:</label></p>
          <p class="mb-1">
            <select name="groupId" id="groupIdInput">
              <option></option>
              <?php
              foreach($groups as $row) {
                ?>
                <option value="<?=$row['id']?>" <?=$get_selectors['groupId'] == $row['id'] ? 'selected' : ''?>><?=$row['name']?></option>
                <?php
              }
              ?>

            </select>

          </p>
        <?php
        }
      ?>


      <button class="border border-black p-1 bg-pink-300 rounded mt-1">Select Student</button>

    </form>
    <?php
    if(!is_null($get_selectors['studentId']))
    {
      if($teacherPermissionValidate ==1 ) {
      ?>
      <div>
        <h2 class="text-lg my-2 p-1 bg-sky-200 rounded">Student Summary</h2>
        <form method="post" action="">
          <div class="flex">
            <div class="flex-1 text-center">
              <input name="ids" id="ids" type="hidden">
              <input type="checkbox" id="selectAllCheckBox" onchange="checkAllBoxes();" disabled>
              <label for="selectAllCheckBox">Select All</label>
            </div>
            <div class="flex-1 text-center">
              <input id="inputFormSubmit" type="submit" name="submit" class="border p-1 bg-pink-300 rounded w-full" value="Assign Responses" onclick="updateIdInput();" disabled>
            </div>
          </div>
          <?php
            if(!is_null($get_selectors['studentId'])){
              ?>
              <p class="mb-1">Student: <?=$studentInfo['name_first']?> <?=$studentInfo['name_last']?>
              <?php
            }
          ?>
          <table class="w-full">
            <tr>
              <th class="w-1/2">Current Group Assignments</th>
              <th class="w-1/2">Responses to same quiz</th>
            </tr>
            <tr>
              <?php
              foreach ($assignments as $assignment) {
                $groupName = getGroupInfoById($assignment['groupid'])['name'];
                ?>
                <tr>
                  <td>
                    <?php
                      //print_r($assignment);
                    ?>
                    <p><?=$assignment['assignName']?></p>
                    <p>Group: <?=$groupName?></p>
                    <p><?=strtoupper($assignment['type'])?></p>
                    <p>Created: <?=date("d M y",strtotime($assignment['dateCreated']))?></p>
                    <p>Due: <?=date("d M y",strtotime($assignment['dateDue']))?></p>
                    <!--
                    <?="id: ".$assignment['id']." <br>assignName: ".$assignment['assignName']." <br>quizid: ".$assignment['quizid']." <br>groupid: ".$assignment['groupid']." <br>dateCreated: ".$assignment['dateCreated']." <br>dateDue: ".$assignment['dateDue']."<br>";?>
                  -->
                  </td>
                  <td>
                    <?php
                      if($assignment['type']=='mcq') {
                        $responses = getMCQquizResults2($studentInfo['id'], null, $assignment['quizid']);
                        //print_r($responses);
                        ?>
                        <p>Responses to Assigned Work: <?=count($responses)?></p>
                        <div class="grid grid-cols-6">
                          <?php
                          foreach($responses as $response) {
                            if($response['assignId'] != $assignment['id']) {
                              $duration = $response['duration'];
                              $seconds = $duration * 60;
                              $minutes = floor($duration);
                              $seconds -= $minutes * 60;
                              $seconds = round($seconds,0);

                              //echo "id: ".$response['id']." dateTime: ".$response['datetime']." duration: ".$response['duration']." percent: ".$response['percentage']." assignId: ".$response['assignId']." <br>assignName: ".$response['assignName']."<br>";

                              ?>
                              <div class="relative flex items-center">
                                <input type="hidden" name="assignId_<?=$response['id']?>" value="<?=$assignment['id']?>">
                                <input class="activeInput absolute right-2" type="checkbox" name="" id="activeInput_<?=$response['id']?>" value="<?=$response['id']?>" onchange="updateIdInput();">
                              </div>
                              <div class=" m-1 col-span-5 border-black rounded">                     
                                <label for="activeInput_<?=$response['id']?>">
                                  <p><b><?=$response['percentage']?>&percnt;</b><br>
                                  <span class="">(<?=date("d.m.y",strtotime($response['datetime']))?>)</span><br>
                                  <!--<?=$response['datetime']?><br>-->
                                  <?=$minutes?>m:<?=$seconds?>s</p>
                                  <?php
                                  if($response['assignId']!="") {
                                    $responseAssign = getAssignmentData($response['assignId']);
                                    //print_r($responseAssign);
                                    ?>
                                    <p>Assignment Name: <?=$responseAssign['assignName']?></p>
                                    <p>Assignment Group: <?=getGroupInfoById($responseAssign['groupid'])['name']?></p>
                                    <?php
                                  }
                                  ?>
                                  
                                </label>
                              </div>


                              <?php
                            }
                          }
                          ?>
                        </div>
                        <?php
                      }
                    ?>

                  </td>
                </tr>
                <?php
              }
              ?>
            </tr>

          </table>
        </form>
        <div class="grid grid-cols-2 mt-1">
          <div class="p-1">
            <h2>Student Version in Current Group:</h2>
            <?php

              include("user_assignment_list_embed.php");
              ?>
          </div>
          <?php
          if(!is_null($get_selectors['groupId'])) {
          ?>
          <div class="p-1">
            <h2>Student View in Old Group:</h2>
            <?php
              $groupid_array = $groupid_array_compare;

              $assignments = getAssignmentsArray($groupid_array, $startDate, 1);
          
              include("user_assignment_list_embed.php");
            
            ?>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
      <?php
      } else {
      ?>
      <p>Error: You do not have teacher permissions for this user.</p>
      <?php
      }
    }
    ?>



  </div>
</div>

<script>

  function updateIdInput() {
    const activeInput = document.getElementsByClassName("activeInput");
    //console.log(activeInput);
    const ids = document.getElementById("ids");
    //console.log(ids);
    var activeInputIds = [];
    for (var x=0; x<activeInput.length; x++) {
      if(activeInput[x].checked == true) {
        activeInputIds.push(activeInput[x].value)

      }
    }
    console.log(activeInputIds);

    ids.value = activeInputIds.join();
  }

  function checkAllBoxes() {
    const selectAllCheckBox = document.getElementById("selectAllCheckBox");
    const activeInput = document.getElementsByClassName("activeInput");
    for (var x=0; x<activeInput.length; x++) {
      if(selectAllCheckBox.checked == true) {
        activeInput[x].checked = true;
      } else if (selectAllCheckBox.checked == false) {
        activeInput[x].checked = false;
      }
    }
    updateIdInput();
  }


  document.getElementById("inputFormSubmit").disabled=false;
  document.getElementById("selectAllCheckBox").disabled=false;
  

</script>

<?php   include($path."/footer_tailwind.php");?>