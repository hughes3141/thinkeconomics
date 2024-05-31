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
  
  //header("location: /login.php");

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
  /*
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
  */
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

if($_SERVER['REQUEST_METHOD']=='POST') {
  if($_POST['submit'] == "Assign Responses") {
    if($_POST['ids'] != "") {
      $changedResponses = explode(",",$_POST['ids']);
      foreach($changedResponses as $response) {
        //$message = updateMCQquizResults($response, $_POST['assignId_'.$response]);
        //array_push($changedResponses, $message);

      }
    }
  }

}

$get_selectors = array(
  'groupId' => (isset($_GET['groupId']) && $_GET['groupId'] != "") ? $_GET['groupId'] : null,

  'studentId' => (isset($_GET['studentId']) && $_GET['studentId'] != "") ? $_GET['studentId'] : null,


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

$students = getUsercreateUsers($userId);

$studentId = null;

if(isset($_GET['studentId'])) {
  $studentId = $_GET['studentId'];
}


$studentInfo = getUserInfo($studentId);
$student = $studentInfo;

$groupid_array = array();
if(!is_null($get_selectors['studentId'])) {
  if($studentInfo['groupid_array'] != "") {
    $groupid_array = json_decode($studentInfo['groupid_array']);
  } 
}

$startDate = "20200901";

$groupid_array_compare = array($get_selectors['groupId']);



$assignments = getAssignmentsArray($groupid_array, $startDate, 1);



include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 pt-20 lg:pt-32 xl:pt-20">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 mb-2">Assignment Switch</h1>
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
    <?php
    if(!is_null($get_selectors['studentId'])){
      ?>
      <p>Student: <?=$studentInfo['name_first']?> <?=$studentInfo['name_last']?>
      <?php
    }
      print_r($_POST);
      print_r($changedResponses);
      //print_r($studentInfo)
      //print_r($students);

    ?>
    <form method="get" action="">
      <p>
        <select name="studentId">
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
        if(isset($_GET['studentId'])) {
          $groups = getGroupsList($userId);
          //print_r($groups);
        ?>
          <p>
            <select name="groupId">
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


      <button class="border border-black p-1 bg-pink-300 rounded">Select Student</button>

    </form>
    <form method="post" action="">
      <!--
      <input name="count">
      -->
      <input name="ids" id="ids">
      <input type="checkbox" id="selectAllCheckBox" onchange="checkAllBoxes();">
      <label for="selectAllCheckBox">Select All</label>
      <input id="inputFormSubmit" type="submit" name="submit" class="border p-1 bg-pink-300 rounded" value="Assign Responses" disabled>
      <table>
        <tr>
          <th>Current Group Assignments</th>
          <th>Responses to same quiz</th>
        </tr>
        <tr>
          <?php
          foreach ($assignments as $assignment) {
            ?>
            <tr>
              <td>
                <?php
                  //print_r($assignment);
                ?>
                <?="id: ".$assignment['id']." <br>assignName: ".$assignment['assignName']." <br>quizid: ".$assignment['quizid']." <br>groupid: ".$assignment['groupid']." <br>dateCreated: ".$assignment['dateCreated']." <br>dateDue: ".$assignment['dateDue']."<br>";?>
              </td>
              <td>
                <?php
                  if($assignment['type']=='mcq') {
                    $responses = getMCQquizResults2($studentInfo['id'], null, $assignment['quizid']);
                    //print_r($responses);
                    echo "Student Responses: ";
                    echo count($responses)."<br>";
                    foreach($responses as $response) {
                      if($response['assignId'] != $assignment['id']) {
                        echo "id: ".$response['id']." dateTime: ".$response['datetime']." duration: ".$response['duration']." percent: ".$response['percentage']." assignId: ".$response['assignId']." <br>assignName: ".$response['assignName']."<br>";
                        ?>
                        
                        <!--
                        <input type="number" name="responseId_<?=$response['id']?>" value="<?=$response['id']?>">
                        -->
                        <input type="number" name="assignId_<?=$response['id']?>" value="<?=$assignment['id']?>">
                        <br>
                        
                        <input type="checkbox" name="" id="activeInput_<?=$response['id']?>" value="<?=$response['id']?>" class="activeInput" onchange="updateIdInput();">


                        <?php
                      }
                    }
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
      <div class="p-1">
        <h2>Student View in Old Group:</h2>
        <?php
          $groupid_array = $groupid_array_compare;

          $assignments = getAssignmentsArray($groupid_array, $startDate, 1);
      
          include("user_assignment_list_embed.php");
        
        ?>
      </div>
    </div>



  </div>
</div>

<script>

  function updateIdInput() {
    const activeInput = document.getElementsByClassName("activeInput");
    console.log(activeInput);
    const ids = document.getElementById("ids");
    console.log(ids);
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

</script>

<?php   include($path."/footer_tailwind.php");?>