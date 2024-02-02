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

$get_selectors = array(
  'groupid' => (isset($_GET['groupid']) && $_GET['groupid']!="") ? $_GET['groupid'] : null,
  'studentid' => (isset($_GET['studentid']) && $_GET['studentid']!="") ? $_GET['studentid'] : null

);

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
$students = array();

if($get_selectors['groupid']) {
  $students = getGroupUsers($get_selectors['groupid']);
}

include($path."/header_tailwind.php");

?>


<div class=" mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">User Work Review</h1>
  <div class="  mx-auto p-4 mt-2 bg-white text-black mb-5">
    <pre>
      <?php
      if(isset($_GET['test'])) {
        //print_r($groupList);
        //print_r($get_selectors);
        print_r($students);
      }
      
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
          foreach($students as $student) {
            ?>
            <option value="<?=$student['id']?>" <?=($get_selectors['studentid'] == $student['id']) ? "selected" : ""?>><?=$student['name_first']?> <?=$student['name_last']?></option>
            <?php
          }
          ?>
        </select>
        <input type="checkbox" name="allstudnets" value="1">
        <?php
      }
      ?>
    <button>Select</button>

    </form>
  </div>
</div>

<?php   include($path."/footer_tailwind.php");?>