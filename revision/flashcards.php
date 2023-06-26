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

  $topics = null;
  $subjectId = null;

  $topicSet = null;
  $subjectIdSet = null;
  $userCreateSet = null;
  $levelIdSet = null;

  $subjectLevel = null;
  $subjectLevel_levelId = null;
  $subjectLevel_subjectId = null;


  if(isset($_GET['topic'])) {
    $_GET['topics'] = $_GET['topic'];
  }

  if(isset($_GET['topics'])) {
    $topics = $_GET['topics'];
    $topics = explode(",", $topics);
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

  if(isset($_GET['subjectLevel'])) {
    $subjectLevel = $_GET['subjectLevel'];
    $subjectLevelArray = explode("_", $subjectLevel);
    $subjectLevel_levelId = $subjectLevelArray[0];
    $subjectLevel_subjectId = $subjectLevelArray[1];
    $subjectIdSet = $subjectLevel_subjectId;
  }

  $levels = getOutputFromTable("subjects_level", "name");
  $subjects = getOutputFromTable("subjects", "name");

  $topicsArray = getColumnListFromTable("saq_question_bank_3", "topic", $topicSet, $subjectIdSet, $userCreateSet, $levelIdSet, 1);

  $questions = array();
  var_dump($topics);
  if(empty($topics)) {
    $questions = getFlashcardsQuestions($topics, $userId, $subjectId);
  }
  var_dump($questions);

  


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insert = insertFlashcardResponse($_POST['questionId'], $userId, $_POST['rightWrong'], $_POST['timeStart'], date("Y-m-d H:i:s", time()), $_POST['cardCategory']);

    if($test == true ) {
      echo"<br>POST:<br>";
      print_r($_POST);
      echo "<br>";
      echo $insert;
    }
}

include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">

  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Revision Flashcards</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black ">

  <?php

    if($test == true) {
    echo count($questions);
    echo "<br>";
    print_r($topicsArray);
    print_r($levels);
    echo "<br>";
    print_r($subjects);
  }


  ?>

  <form method="get" action = "">

  <div id="accordion-collapse" data-accordion="collapse">
    <h2 id="accordion-collapse-heading-1">
      <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="<?=(is_null($subjectLevel)) ? "true" : "false"?>" aria-controls="accordion-collapse-body-1">
        <span>Select Subject and Level</span>
        <svg data-accordion-icon class="w-6 h-6  shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
      </button>
    </h2>
    <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
      <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
        <div>
          <label for="subjectLevel">Subject:</label>
          <select id="subjectLevel" name="subjectLevel" onchange="this.form.submit()">
            <?php
              foreach ($levels as $level) {
                foreach ($subjects as $subject) {
                  $subjectLevelId = $level['id']."_".$subject['id'];
                  ?>
                  <option value="<?=$subjectLevelId?>" <?=($subjectLevelId == $subjectLevel) ? "selected" : ""?>><?=$subject['name']?> (<?=$level['name']?>)</option>
                  <?php
                }
              }
              ?>

          </select>
          

        </div>
      </div>
    </div>
    <h2 id="accordion-collapse-heading-2">
      <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-2" aria-expanded="<?=(is_null($topics) or $topics != "") ? "true" : "false" ?>" aria-controls="accordion-collapse-body-2">
        <span>Select Topics</span>
        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
      </button>
    </h2>
    <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
      <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-4">
          <?php
            foreach($topicsArray as $topic) {
              ?>
              <div>
                <input type="checkbox" id="topic_<?=htmlspecialchars($topic)?>" class= "topicSelector" value="<?=htmlspecialchars($topic)?>" onchange="topicAggregate();" <?php
                  if(!is_null($topics)) {
                    if(in_array($topic, $topics)) {
                      echo "checked";
                    }
                  } 
                ?>>
                <label for = "topic_<?=htmlspecialchars($topic)?>" ><?=htmlspecialchars($topic)?></label>
              </div>
              <?php
            }

          ?>

        </div>
        <input type="hidden" name="topics" id="topicSelect">
          <input type="submit" value="Choose Topics" class="rounded border border-sky-300 w-full">

      </div>
    </div>
    <?php 
    /*
    <h2 id="accordion-collapse-heading-3">
      <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
        <span>What are the differences between Flowbite and Tailwind UI?</span>
        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
      </button>
    </h2>
    <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
      <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
        <p class="mb-2 text-gray-500 dark:text-gray-400">The main difference is that the core components from Flowbite are open source under the MIT license, whereas Tailwind UI is a paid product. Another difference is that Flowbite relies on smaller and standalone components, whereas Tailwind UI offers sections of pages.</p>
        <p class="mb-2 text-gray-500 dark:text-gray-400">However, we actually recommend using both Flowbite, Flowbite Pro, and even Tailwind UI as there is no technical reason stopping you from using the best of two worlds.</p>
        <p class="mb-2 text-gray-500 dark:text-gray-400">Learn more about these technologies:</p>
        <ul class="pl-5 text-gray-500 list-disc dark:text-gray-400">
          <li><a href="https://flowbite.com/pro/" class="text-blue-600 dark:text-blue-500 hover:underline">Flowbite Pro</a></li>
          <li><a href="https://tailwindui.com/" rel="nofollow" class="text-blue-600 dark:text-blue-500 hover:underline">Tailwind UI</a></li>
        </ul>
      </div>
    </div>
    */
    ?>
  </div>

  </form>


    <div>
      <?php
        if(count($questions) == 0) {
          ?>
            <div  class="font-sans  p-3 m-2">
              <p class="mb-3">Well done! There are no more cards for you to revise.</p>
            </div>
          <?php
          
        } else {
        
          $question = $questions[0];
          if(isset($_GET['topics'])) {
              echo "<p class='ml-1'>Topic: ".htmlspecialchars($question['topic'])."</p>";
            }
          ?>

          <div id="flashcard" class="font-sans  p-3 m-2">
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
                  <img class = "mx-auto content-center object-center" src= "<?=htmlspecialchars($question['q_path'])?>" alt = "<?=htmlspecialchars($question['q_alt'])?>">
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
                    <img class = "mx-auto content-center object-center" src= "<?=htmlspecialchars($question['a_path'])?>" alt = "<?=htmlspecialchars($question['a_alt'])?>">
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

      function topicAggregate() {

        var topicsInput = document.getElementsByClassName("topicSelector");
        var topicsInputChecked = [];
        var topicString = "";
        var checkedCount = 0;
        const topicSelect = document.getElementById("topicSelect");

        for (var i=0; i<topicsInput.length; i++) {
          var topic = topicsInput[i];
          if(topic.checked == true) {
            topicsInputChecked.push(topicsInput[i]);
          }
        }

        for(var i=0; i<topicsInputChecked.length; i++) {
          topic = topicsInputChecked[i];
          topicString += topic.value;
          if(i < (topicsInputChecked.length - 1)) {
            topicString += ",";
          }

        }

        topicSelect.value = topicString;


          




      
      console.log(topicString);
      //console.log(topicSelect);

      topicSelect.value = topicString;
      }

      
      

    </script>

<?php include ($path."/footer_tailwind.php");


