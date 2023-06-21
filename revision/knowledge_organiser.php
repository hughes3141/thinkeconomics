<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $permissions = $userInfo['permissions'];
  /*
  if (!(str_contains($permissions, 'teacher'))) {
    header("location: /index.php");
  }
  */

}

$style_input = "

  
  ";


include($path."/header_tailwind.php");

$topic = "";
if(isset($_GET['topic'])) {
  $topic = $_GET['topic'];
}

$questions = getSAQQuestions(null, $topic, true, 1);

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Knowledge Organiser</h1>
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5">
  
  <?php
    /*
    echo $topic;
    echo "<br>";
    echo count($questions)."<br>";
    echo "<pre>";
    print_r($questions);
    echo "</pre>";
    */


    echo "<ol class='list-decimal list-inside'>";


    foreach($questions as $question) {
      ?>
      
      <div class="">
        <li class="whitespace-pre-line mt-5 mb-1 text-lg -indent-5 ml-5"><?=$question['question']?></li>
            <?php
              $img = null;
              $alt = null;
              if($question['img'] != "") {
                $img = htmlspecialchars($question['img']);
                $alt = htmlspecialchars($question['img']);
              }
              if($question['a_path'] != "") {
                $img = htmlspecialchars($question['q_path']);
                $alt = htmlspecialchars($question['q_alt']);
              }
              if(!is_null($img)) {
                ?><img class = "mx-auto my-1" src= "<?=$img?>" alt = "<?=$alt?>">
                <?php
              }
            ?>
          <div class="ml-4 bg-pink-100 p-2">
            <p class="whitespace-pre-line"><?=$question['model_answer']?></p>
            <?php
              $img = null;
              $alt = null;
              if($question['answer_img'] != "") {
                $img = htmlspecialchars($question['answer_img']);
                $alt = htmlspecialchars($question['answer_img_alt']);
              }
              if($question['a_path'] != "") {
                $img = htmlspecialchars($question['a_path']);
                $alt = htmlspecialchars($question['a_alt']);
              }
              if(!is_null($img)) {
                ?><img class = "mx-auto my-1" src= "<?=$img?>" alt = "<?=$alt?>">
                <?php
              }
            ?>
          </div>
      </div>
      <?php
    }

    echo "</ol>";
  ?>




  </div>
</div>

<script>
</script>


<?php   include($path."/footer_tailwind.php");?>



