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


//Set img path:

/**
 * images find the path set via $question['q_path'] etc.
 * This is assumed to be in root foler if thinkeonomics
 * If other site: udpate variable $imgSourcePathPrefix to 
 */

 $imgSourcePathPrefix = "";
 //$imgSourcePathPrefix = "https://www.thinkeconomics.co.uk";




include($path."/header_tailwind.php");

//Option to hide topic selector:

$showTopicInput = 1;
if(isset($_GET['noShow'])) {
  $showTopicInput = null;
}

//$topic = null;
 $subjectId = $userCreate = $userCreate = $levelId = $subjectIdSet = null;

$topics = $subjectLevel = null;

$topicIds = $topicIdsArray = null;
$topicChosenArray = array();

$examBoardId = null;

if(isset($_GET['topicIds'])) {
  $topicIds = $_GET['topicIds'];
  $topicIdsArray = explode(",", $topicIds);
  foreach ($topicIdsArray as $topic) {
    if($topic != "") {
      array_push($topicChosenArray,  getSAQTopics($topic)[0]);
    }
  }
}
if(isset($_GET['topic'])) {
  $_GET['topics'] = $_GET['topic'];
}
if(isset($_GET['topics'])) {
  $topics = $_GET['topics'];
}
if(isset($_GET['subjectId'])) {
  $subjectId = $_GET['subjectId'];
  $subjectIdSet = $_GET['subjectId'];
}
if(isset($_GET['userCreate'])) {
  $userCreate = $_GET['userCreate'];
}
if(isset($_GET['examBoardId'])) {
  $examBoardId = $_GET['examBoardId'];
}

if(isset($_GET['subjectLevel'])) {
  $subjectLevel = $_GET['subjectLevel'];
  $subjectLevelArray = explode("_", $subjectLevel);
  if(count($subjectLevelArray)>1) {
    $subjectLevel_levelId = $subjectLevelArray[0];
    $subjectLevel_subjectId = $subjectLevelArray[1];
  }
  //Sets subjectId from here
  $subjectIdSet = $subjectLevel_subjectId;
  $levelId = $subjectLevel_levelId;
}

$levels = getOutputFromTable("subjects_level", null, "name");


$subjects = getDistinctFlashcardSubjectLevels();

$allSubjects = getOutputFromTable("subjects", null, "name");

$examBoardIds = getSAQExamBoards($subjectIdSet);
$examBoards = array();

//print_r($examBoardIds);

foreach ($examBoardIds as $examBoard) {
  $id= $examBoard['examBoardId'];
  $inst = getExamBoards($id);
  if(count($inst)==1) {
    array_push($examBoards, $inst[0]);
  }     
}

$topicsArray = array();

if(!empty($subjectIdSet)) {
  //$topicsArray = getColumnListFromTable("saq_question_bank_3", "topic", null, $subjectIdSet, null, null, 1);

  $topicsArray =getSAQTopics(null, $subjectIdSet, 1, $examBoardId);

}



$questions = getSAQQuestions(null, null, true, $subjectIdSet, $userCreate, null, null, $topicIds);

$topicList = getTopicList("saq_question_bank_3", "topic", $topics, true, $subjectIdSet, $userCreate);

if(isset($userId)) {
  ?>
  <!--

  $_GET:
  -noAnswer: hides all answer boxes from output


-->
  <?php
}


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



    echo "<pre>";
    //print_r($topicList);
    //print_r($topicsArray);
    //echo "<br>";
    //print_r($topicIdsArray);
    //echo "<br>";
    //print_r($topicChosenArray);
    echo "</pre>";




    if(!is_null($showTopicInput)) {
      //Embeds topic selector:
      include("topic_select_embed.php");
    }

    foreach($topicChosenArray as $topic) {
      $question_filter = array();

      foreach($questions as $question) {
        if ($question['topicId'] == $topic['id'] ) {
          array_push($question_filter, $question);
        }
      }
      ?>
      <h2 class = "bg-pink-300 -ml-4 -mr-4 mb-5 text-xl font-mono pl-1 text-gray-800 sticky top-16"><?=$topic['code']?> <?=$topic['name']?></h2>
      <?php
      //print_r($topic);
      ?>
      <ol class='list-decimal'>

      <?php

      foreach($question_filter as $question) {
        ?>
        
        <div class="">
          <li class="whitespace-pre-line  mb-1 text-lg  ml-5"><?=$question['question']?></li>
              <?php
                if(!is_null($question['q_path'])) {
                  ?>
                  <img class = "mx-auto my-1 max-h-80" src= "<?=$imgSourcePathPrefix.htmlspecialchars($question['q_path'])?>" alt = "<?=htmlspecialchars($question['q_alt'])?>">
                  <?php
                }
                ?>
          </li>
            <div class="ml-5 mb-5 bg-pink-100 p-2 <?=(isset($_GET['noAnswer'])) ? "hidden" : "" ?>">
              <p class="whitespace-pre-line"><?=$question['model_answer']?></p>
              <?php
                if(!is_null($question['a_path'])) {
                  ?>
                  <img class = "mx-auto my-1 max-h-80" src= "<?=$imgSourcePathPrefix.htmlspecialchars($question['a_path'])?>" alt = "<?=htmlspecialchars($question['a_alt'])?>">
                  <?php
                }
                ?>
            </div>
          
        </div>
        
        <?php
      }
      ?>
      </ol>
      <?php
    }

    
  ?>




  </div>
</div>




<?php   include($path."/footer_tailwind.php");?>



<script>
</script>
