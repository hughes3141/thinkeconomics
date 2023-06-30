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


$showTopicInput = 1;
if(isset($_GET['noShow'])) {
  $showTopicInput = null;
}

//$topic = null;
$subjectId = null;
$subjectId = null;
$userCreate = null;
$userCreate = null;

$topics = null;
$subjectLevel = null;

if(isset($_GET['topic'])) {
  $_GET['topics'] = $_GET['topic'];
}

if(isset($_GET['topics'])) {
  $topics = $_GET['topics'];
  
}


if(isset($_GET['subjectId'])) {
  $subjectId = $_GET['subjectId'];
}
if(isset($_GET['userCreate'])) {
  $userCreate = $_GET['userCreate'];
}

if(isset($_GET['subjectLevel'])) {
  $subjectLevel = $_GET['subjectLevel'];
  $subjectLevelArray = explode("_", $subjectLevel);
  if(count($subjectLevelArray)>1) {
    $subjectLevel_levelId = $subjectLevelArray[0];
    $subjectLevel_subjectId = $subjectLevelArray[1];
  }
  //Sets subjectId from here
  $subjectId = $subjectLevel_subjectId;
}

$levels = getOutputFromTable("subjects_level", null, "name");


$subjects = getDistinctFlashcardSubjectLevels();

$allSubjects = getOutputFromTable("subjects", null, "name");

$topicsArray = array();

if(!is_null($subjectId)) {
  $topicsArray = getColumnListFromTable("saq_question_bank_3", "topic", null, $subjectId, null, null, 1);

}



$questions = getSAQQuestions(null, $topics, true, $subjectId, $userCreate, null, null);
$topicList = getTopicList("saq_question_bank_3", "topic", $topics, true, $subjectId, $userCreate);


?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Knowledge Organiser</h1>
  <div class=" container mx-auto p-4  mt-2 bg-white text-black mb-5 pt-1 ">
  
  <?php

  if(isset($_GET['test'])) {
    
    echo "subjectId: ".$subjectId."<br>";
    echo "All Subjects :<br>";
    print_r($allSubjects);
    echo "<br>Distinct Subjects :<br>";
    print_r($subjects);
    echo "<br>Distinct Levels :<br>";
    print_r($levels);

  }
    /*
    echo $topics;
    echo "<br>";
    echo count($questions)."<br>";

    echo "<pre>";
    print_r($questions);
    echo "</pre>";
    */



    
    //print_r($topicList);

    if(!is_null($showTopicInput)) {
      //Embeds topic selector:
      include("topic_select_embed.php");
    }

    
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
                if(!is_null($question['q_path'])) {
                  ?>
                  <img class = "mx-auto my-1 max-h-80" src= "<?=htmlspecialchars($question['q_path'])?>" alt = "<?=htmlspecialchars($question['q_alt'])?>">
                  <?php
                }
                ?>

            <div class="ml-5 mb-5 bg-pink-100 p-2">
              <p class="whitespace-pre-line"><?=$question['model_answer']?></p>
              <?php
                if(!is_null($question['a_path'])) {
                  ?>
                  <img class = "mx-auto my-1 max-h-80" src= "<?=htmlspecialchars($question['a_path'])?>" alt = "<?=htmlspecialchars($question['a_alt'])?>">
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




<?php   include($path."/footer_tailwind.php");?>



<script>
</script>