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
$style_input = "";

include ($path."/header_tailwind.php");

$groupId = null;
$startDate = null;
$endDate = null;
$orderBy = null;
$students = array();

if(isset($_GET['groupId'])) {
  $groupId = $_GET['groupId'];
  $students = getGroupUsers($groupId);
}

if(isset($_GET['startDate'])) {
  $startDate = $_GET['startDate'];
}

if(isset($_GET['endDate'])) {
  $endDate = $_GET['endDate'];
}

if(isset($_GET['orderBy'])) {
  $orderBy = $_GET['orderBy'];
}



$results = getFlashcardSummaryByQuestion($groupId, $startDate, $endDate, $orderBy);

$groups = getGroupsList($userId);

$date = date('Y-m-d');
$dateLastMonth = date('Y-m-d', strtotime('-30 days'));



foreach($results as $array) {
  //print_r($array);
  //echo "<br>";
}


?>

<!-- GET variables: groupId, startDate, endDate, orderBy
    
-->

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Flash Card Review</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black">
  <?php
  
  
  echo "<pre>";
  //print_r($groups);
  //print_r($_GET);
  //print_r($students);
  echo "</pre>";

  
  
  ?>
    <form method = "get" action="" class = "border border-black rounded p-2 m-2" >
      <label for="groupId">Class:</label>
      <select name="groupId" id = "groupId" class="mb-2">
        <option value=""></option>
        <?php
        foreach($groups as $group) {
          ?>
          <option value="<?=$group['id']?>" <?=(isset($_GET['groupId']) && $_GET['groupId']==$group['id']) ? "selected" : "" ?>><?=$group['name']?></option>
          <?php
        }
        ?>
      </select>
      <br>
      <?php
      /*
      <label for="startDate">Start Date:</label>
      <input id = "startDate" type="date" name="startDate" value="<?=(!empty($_GET['startDate'])) ? $_GET['startDate'] : $dateLastMonth?>" class="mb-2">
      <br>
      <label for="endDate">End Date:</label>
      <input id = "endDate" type="date" name="endDate" value="<?=(isset($_GET['endDate'])) ? $_GET['endDate'] : $date?>" class="mb-2">
      <br>
      <label for ="orderBy">Order By:</label>
      <select id="orderBy" name="orderBy" class="mb-2">
        <option value="correct" <?=($orderBy == "correct") ? " selected " : "" ?>>Correct</option>
        <option value="wrong" <?=($orderBy == "wrong") ? " selected " : "" ?>>Incorrect</option>
        <option value="dontknow" <?=($orderBy == "dontknow") ? " selected " : "" ?>>Don't Know</option>
      </select>
      <br>
      */
      ?>
      <input type="submit" value="Select Group" class="p-1 w-full bg-pink-300 text-white hover:bg-pink-200">
    </form>
    <?php
    if(!empty($groupId)) {
      ?>
        <table class="table-fixed border border-black">
          <tr>
            <th class="border border-black">Name</th>
            <th class="border border-black">Count</th>
            <th class="border border-black">Dates</th>
            <th class="border border-black">Average Time</th>
            <th class="border border-black">Date Summary</th>
          </tr>
          <?php
            foreach($students as $student) {
              $id = $student['id'];
              //print_r(flashCardSummary($id, "count_category"));
              ?>
              <tr>
                <td class="border border-black"><?=$student['name_first']." ".$student['name_last']?></td>
                <td class="border border-black"><?=flashCardSummary($id, "count")[0]['count']?></td>
                <td class="border border-black"> <?php
                  $flashcards = flashCardSummary($id, "count_category");
                    foreach($flashcards as $array) {
                      if ($array['gotRight']==0) {
                        echo "Didn't Know: ";
                      } elseif ($array['gotRight']==1) {
                        echo "Incorrect : ";
                      } elseif ($array['gotRight']==2) {
                        echo "Correct: ";
                      }
                    echo $array['count']."<br>";
                  }
                ?></td>
                <td class="border border-black"><?=round(flashCardSummary($id, "average")[0]['avg'])?></td>
                <td class="border border-black">
                  <div class="grid grid-cols-4">
                  <?php
                  $flashcards = flashCardSummary($id, "count_by_date");
                  //print_r($flashcards);
                  foreach($flashcards as $array) {
                    echo "<div class='text-sm border border-slate-400'>".date('d/m/y D',strtotime($array['date'])).": ".$array['count']."</div>";
                  }
                  ?>
                  
                </td>
              </tr>
              <?php
            }
            ?>
        </table>
      <?php
    }
    ?>
  </div>
</div>

<?php include ($path."/footer_tailwind.php");; ?>