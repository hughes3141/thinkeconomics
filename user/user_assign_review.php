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
  $groupid = array();
  if($userInfo['groupid_array'] != "") {
    $groupid = json_decode($userInfo['groupid_array']);
  }
  */

  $groupid_array = array();
  if($userInfo['groupid_array'] != "") {
    $groupid_array = json_decode($userInfo['groupid_array']);
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

$startDate = "20200901";  

$get_selectors = array(
  'groupid' => (isset($_GET['groupid']) && $_GET['groupid']!="") ? $_GET['groupid'] : null,
  'studentid' => (isset($_GET['studentid']) && $_GET['studentid']!="") ? $_GET['studentid'] : null,
  'allstudents' => (isset($_GET['allstudents']) && $_GET['allstudents']!="") ? $_GET['allstudents'] : null,
  'startDate' => (isset($_GET['startDate']) && $_GET['startDate']!="") ? $_GET['startDate'] : $startDate

);


include($path."/header_tailwind.php");

?>


<div class=" mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">All Assignments Review</h1>
  <div class="  mx-auto p-4 mt-2 bg-white text-black mb-5">
    <?php
      if(isset($_GET['test'])) {
        print_r($userInfo);
      }

      if(str_contains($userInfo['permissions'], "teacher")) {
        $groups = getGroupsList($userId);
        if(isset($_GET['test'])) {
          echo "<pre>";
          print_r($groups);
          echo "</pre>";
        }
        $get_group = (isset($_GET['groupid']) && $_GET['groupid']!= "") ? $_GET['groupid'] : null;
        ?>
        <form method="get" action ="">
          <select name="groupid">
          <option></option>
            <?php
              foreach($groups as $group) {
                ?>
                  <option value="<?=$group['id']?>" <?=($get_group == $group['id']) ? "selected" : ""?>><?=$group['name']?></option>
                <?php
              }
            ?>
          </select>
          <input type="submit" class="bg-pink-200 mx-1 px-1" value="Choose"></input>
        </form>
        <?php
      }
    ?>
    <p>Name: <?=$userInfo['name_first']?> <?=$userInfo['name_last']?></p>
    <p>This page contains all the assignments that have been given to you or your class.</p>
    <p>You can use this page to ensure you are up to date with your work, or re-submit assignments. This is the same information your teacher sees when processing report data.</p>




    <?php

    //Use below to negate $startDate variable:
    $get_selectors['startDate'] = null;

    if(isset($_GET['groupid'])) {
      $groupInfo = getGroupInfoById($_GET['groupid']);
      if($groupInfo) {
        $groupTeachers = $groupInfo['teachers'];
        //print_r($groupInfo);
        if(in_array($userId, $groupTeachers)) {
          $groupid_array = array($_GET['groupid']);
        }
      }
    }

    $assignments = getAssignmentsArray($groupid_array, $get_selectors['startDate'], 1);

    if(isset($_GET['test'])) {
      echo "<pre>";
      print_r($groupid_array);
      print_r($assignments);
      echo "</pre>";
    }

    //Use $userInfo array for $student variable in user_assignment_list_embed.php

    $student = $userInfo;

    if(count($assignments)>0) {

    ?>

    
      <h2 class="bg-sky-200 pl-1 my-2 rounded-r-lg">Assignment Summary</h2>

      <?php
        include("user_assignment_list_embed.php");
      ?>

    <?php
    }
    ?>


  </div>
</div>

<?php   include($path."/footer_tailwind.php");?>