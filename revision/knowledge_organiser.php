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

$topic = null;
$subjectId = null;
$subjectId = 1;
$userCreate = null;
$userCreate = 1;

if(isset($_GET['topic'])) {
  $topic = $_GET['topic'];
}
if(isset($_GET['subjectId'])) {
  $subjectId = $_GET['subjectId'];
}
if(isset($_GET['userCreate'])) {
  $userCreate = $_GET['userCreate'];
}

$questions = getSAQQuestions(null, $topic, true, $subjectId, $userCreate);
$topicList = getTopicList("saq_question_bank_3", "topic", $topic, true, $subjectId, $userCreate);


?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Knowledge Organiser</h1>
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5 pt-0">
  
  <?php
    /*
    echo $topic;
    echo "<br>";
    echo count($questions)."<br>";
    echo "<pre>";
    print_r($questions);
    echo "</pre>";
    
    
    print_r($topicList);
    */




    foreach($topicList as $topic) {
      $questions_filter_by_topic = array();

      foreach($questions as $question) {
        if($question['topic'] == $topic) {
          array_push($questions_filter_by_topic, $question);
        }
      }
      ?>
      <h2 class = "bg-pink-300 -ml-4 -mr-4 mb-5 text-xl font-mono pl-1 text-gray-800"><?=$topic?></h2>
      <?php
      echo "<ol class='list-decimal'>";

      foreach($questions_filter_by_topic as $question) {
        ?>
        
        <div class="">
          <li class="whitespace-pre-line  mb-1 text-lg  ml-5"><?=$question['question']?></li>
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
                  ?><img class = "mx-auto my-1 max-h-80" src= "<?=$img?>" alt = "<?=$alt?>">
                  <?php
                }
              ?>
            <div class="ml-5 mb-5 bg-pink-100 p-2">
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
                  ?><img class = "mx-auto my-1 max-h-80" src= "<?=$img?>" alt = "<?=$alt?>">
                  <?php
                }
              ?>
            </div>
        </div>
        
        <?php
      }
      echo "</li>";
    }

    
  ?>




  </div>
</div>

<script>
</script>


<?php   include($path."/footer_tailwind.php");?>



