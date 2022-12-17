<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");
include ($path."/header_tailwind.php");



$results = getFlashcardSummaryByQuestion($_GET['groupId'], $_GET['startDate'], $_GET['endDate'], $_GET['orderBy']);



foreach($results as $array) {
  //print_r($array);
  //echo "<br>";
}


?>

<!-- GET variables: groupId, startDate, endDate, orderBy
    
-->"

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Flash Card Review</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black">
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