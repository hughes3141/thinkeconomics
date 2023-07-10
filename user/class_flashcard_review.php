<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");
include ($path."/header_tailwind.php");

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



$groupId = null;
$startDate = null;
$endDate = null;
$orderBy = null;

if(isset($_GET['groupId'])) {
  $groupId = $_GET['groupId'];
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
  <div class="container mx-auto px-0 mt-2 bg-white text-black pt-1">
  <?php
  
  /*
  echo "<pre>";
  //print_r($groups);
  //print_r($_GET);
  echo "</pre>";
  echo $date;
  echo "<br>";
  echo $dateLastMonth;
  */
  
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
      <label for="startDate">Start Date:</label>
      <input id = "startDate" type="date" name="startDate" value="<?=(isset($_GET['startDate'])) ? $_GET['startDate'] : "" /*$dateLastMonth*/?>" class="mb-2">
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
      <input type="submit" value="Select Group" class="p-1 w-full bg-pink-300 text-white hover:bg-pink-200">
    </form>
    <table class="table-fixed">
      <tr>
        <th>Topic</th>
        <th>Question</th>
        <th>Responses</th>
      </tr>
      <?php
      foreach($results as $array) {
        ?>
        <tr>
          <td><?=$array['topic']?></td>
          <td><?=$array['question']?>
            <?php
              if($array['img'] != ""){
                ?>
                <img src = "<?=$array['img']?>" class="w-auto">
                <?php
              }
              ?>
          </td>
          <td>
            Correct: <?=$array['correct']?> ||
            Incorrect: <?=$array['wrong']?> ||
            Don't Know: <?=$array['dontknow']?>
          </td>
        </tr>
        <?php
      }
      ?>
  </table>
  </div>
</div>

<?php include ($path."/footer_tailwind.php");; ?>