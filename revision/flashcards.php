<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");  

$test = false;
if(isset($_GET['test'])) {
  $test = true;
}

if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  $userId = $_SESSION['userid'];
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $schoolId = $userInfo['schoolid'];
  $permissions = $userInfo['permissions'];
  echo ($test == true ? print_r($userInfo) : "");
  $userGroups = json_decode($userInfo['groupid_array']);
  //print_r($userGroups);
  
}

$style_input = "

td, th {
	
	border: 1px solid black;
	padding: 3px;
}

table {
	
	border-collapse: collapse;
}
";



/*
Notes on command GET variables:
  -$_GET['topics'] or $_GET['topic'] : Enter comma-separated string of topic strings, to limit questions to particular topics;
  -'subjectId' : Filters by subjectId.
  
  **NOTE: RESTRICT NO LONER FUNCTIONS BUT MAY BE USEFUL IN FUTURE
  -$_GET['restrict'] : to change the time until a card is recycled. With following parameters:
    - !isset($_GET['restrict']) : default, 3 days and 5 days
    - $_GET['restrict'] = 'none' : No wait, cards immediately recycled
    - $_GET['restrict'] = '0' : No wait, cards immediately recycled
    - $_GET['restrict'] = 'minutes' : 3 mins and 5 mins
*/

//Set img path:

/**
 * images find the path set via $question['q_path'] etc.
 * This is assumed to be in root foler if thinkeonomics
 * If other site: udpate variable $imgSourcePathPrefix to 
 */

 $imgSourcePathPrefix = "";
 //$imgSourcePathPrefix = "https://www.thinkeconomics.co.uk";



  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insert = insertFlashcardResponse($_POST['questionId'], $userId, $_POST['rightWrong'], $_POST['timeStart'], date("Y-m-d H:i:s", time()), $_POST['cardCategory']);

    if($test == true ) {
      echo"<br>POST:<br>";
      print_r($_POST);
      echo "<br>";
      echo $insert;
    }
  }

  $topics = null;
  $subjectId = null;

  $topicSet = null;
  $subjectIdSet = null;
  $userCreateSet = null;
  $levelIdSet = null;

  $subjectLevel = null;
  $subjectLevel_levelId = null;
  $subjectLevel_subjectId = null;



  $topicIds = $topicIdsArray = null;

  $examBoardId = null;

  if(isset($_GET['topicIds'])) {
    $topicIds = $_GET['topicIds'];
    $topicIdsArray = explode(",", $topicIds);
    
  }




  if(isset($_GET['topic'])) {
    $_GET['topics'] = $_GET['topic'];
  }

  if(isset($_GET['topics'])) {
    $topics = $_GET['topics'];
    
  }



  if(isset($_GET['subjectId'])) {
    $subjectId = $_GET['subjectId'];
  }

  if(isset($_GET['topicSet'])) {
    $topicSet = $_GET['topicSet'];
  }

  if(isset($_GET['subjectIdSet'])) {
    $subjectIdSet = $_GET['subjectIdSet'];
  }

  if(isset($_GET['userCreateSet'])) {
    $userCreateSet = $_GET['userCreateSet'];
  }

  if(isset($_GET['levelIdSet'])) {
    $levelIdSet = $_GET['levelIdSet'];
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
  }
  
  $levels = getOutputFromTable("subjects_level", null, "name");
  //$subjects = getOutputFromTable("subjects", null, "name");
  
  $subjects = getDistinctFlashcardSubjectLevels();
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

    if(!empty($subjectIdSet)) {}
    $topicsArray =getSAQTopics(null, $subjectIdSet, 1, $examBoardId);

  }


  /*
  if(!is_null($subjectLevel)) {
    $topicsArray = getColumnListFromTable("saq_question_bank_3", "topic", $topicSet, $subjectIdSet, $userCreateSet, $levelIdSet, 1);
  }

  */

  $questions = array();

  if(!empty($topicIds)) {
    /*
    if($topics == "all") {
      $topics = null;
    }
    */
    $questions = getFlashcardsQuestions(null, $userId, null, $topicIds);
  }
  //$topics = $topics = explode(",", $topics);



include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">

  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Revision Flashcards</h1>
  <div class="container mx-auto p-1 mt-2 bg-white text-black ">

  <?php

    if($test == true) {
    echo count($questions);
    echo "<br>";
    foreach ($questions as $question) {
      echo $question['question'];
    }
    print_r($topicsArray);
    print_r($levels);
  
    echo "<br>Subjects:<br>";
    print_r($subjects);
  }


      //Embeds topic selector:
      include("topic_select_embed.php");

  ?>


      <div>
      <?php
        if(count($questions) == 0) {
          ?>
            <div  class="font-sans  p-3 m-2 hidden border-t border-gray-200">
              <p class="mb-3">Well done! There are no more cards for you to revise.</p>
            </div>
          <?php
          
        } else {
        
          $question = $questions[0];

          ?>

          <div id="flashcard" class="font-sans  p-3 m-2 border-t border-gray-200">
            <?php
                if(isset($_GET['topics'])) {
                  echo "<p class=''>Topic: ".htmlspecialchars($question['topic'])."</p>";
                }
            ?>
            <form method="post">
              <h2 class ="text-lg">Question:</h2>
              <?=$test == true ? print_r($question) : "" ?>

              <input type="hidden" name="questionId" value = "<?=htmlspecialchars($question['qId'])?>">
              <input type="hidden" name="timeStart" value = "<?=date("Y-m-d H:i:s",time())?>">
              <input type="hidden" name="cardCategory" value = "<?=$question['cardCategory']?>">
              
              <p class="mb-3" style="white-space: pre-line;"><?php echo htmlspecialchars($question['question']);?></p>

              <?php
                if(!is_null($question['q_path'])) {
                  ?>
                  <img class = "mx-auto content-center object-center" src= "<?=$imgSourcePathPrefix.htmlspecialchars($question['q_path'])?>" alt = "<?=htmlspecialchars($question['q_alt'])?>">
                  <?php
                }
              ?>
              
              <div id="buttonsDiv" class="flex justify-center">

                <button type = "button" class="grow m-3 py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" onclick="showAnswers();hideButtons();swapButtons()">I don't know</button>

                <button value ="0" name="rightWrong" class="grow m-3 hidden ">I don't know</button>

                <button type = "button" class="grow m-3 py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" onclick="showAnswers();hideButtons()">Show answers</button>
              </div>
              
              <div id ="answerDiv" class="hidden">
                <h2 class ="text-lg">Answer:</h2>
                <p class="mb-3" style="white-space: pre-line;"><?=htmlspecialchars($question['model_answer']);?></p>

                <?php
                  if(!is_null($question['a_path'])) {
                    ?>
                    <img class = "mx-auto content-center object-center" src= "<?=$imgSourcePathPrefix.htmlspecialchars($question['a_path'])?>" alt = "<?=htmlspecialchars($question['a_alt'])?>">
                    <?php
                  }
                ?>
              
                <div id ="buttonsDiv2" class="flex justify-center">
                  <button id = "1Button" value ="1" name="rightWrong" class="grow m-3 py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Wrong Answer</button>
                  
                  <button id = "2Button" value ="2" name="rightWrong" class="grow m-3 py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Correct Answer</button>
                  
                  <button id = "0Button" value ="0" name="rightWrong" class="grow m-3 hidden py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Next Question</button>
                </div>
              </div>

            </form>

          </div>

        <?php 
        } 
        ?>

        <?php

        if($test == true) {
          echo "<pre>";
          //print_r($questions);
          echo "</pre>";
        }
        ?>
    </div>




  </div>

</div>

<script >



      function showAnswers() {
        var answerDiv = document.getElementById("answerDiv");
        answerDiv.classList.remove("hidden");

      }

      function hideButtons() {

        var buttonsDiv = document.getElementById("buttonsDiv");
        buttonsDiv.classList.add("hidden");

      }

      function swapButtons() {
        var Button0 = document.getElementById("0Button");
        var Button1 = document.getElementById("1Button");
        var Button2 = document.getElementById("2Button");

        Button1.classList.add("hidden");
        Button2.classList.add("hidden");
        Button0.classList.remove("hidden");

      }





      
      

    </script>

<?php include ($path."/footer_tailwind.php");


