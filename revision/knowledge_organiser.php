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
  <div class=" container mx-auto p-4 mt-2 bg-white text-black mb-5 pt-2">
  
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


    ?>
    <!-- The iniput form for selecting subject and topics:-->

      <form method="get" action = "">
        <div id="accordion-collapse" data-accordion="collapse" class="my-2 border rounded-xl border-gray-200">
          <h2 id="accordion-collapse-heading-1">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="<?=(is_null($subjectLevel)) ? "true" : "false"?>" aria-controls="accordion-collapse-body-1">
              <span>Select Subject and Level</span>
              <svg data-accordion-icon class="w-6 h-6  shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
            <div class="p-5  border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
              <div>
                <label for="subjectLevel">Subject:</label>
                <select class="mb-3" id="subjectLevel" name="subjectLevel" onchange="this.form.submit()">
                  <option value="_"></option>
                  <?php
                    foreach ($subjects as $subject) {
                      $subjectLevelId = $subject['lId']."_".$subject['sId'];
                      ?>
                      <option value="<?=$subjectLevelId?>" <?=($subjectLevelId == $subjectLevel) ? "selected" : ""?>><?=$subject['subject']?> (<?=$subject['level']?>)</option>
                      <?php
                    }
                    ?>

                </select>

                <input type="submit" value="Choose Subject" class="rounded border border-sky-300 bg-sky-300 w-full text-white mt-2 hover:bg-sky-200">
                

              </div>
            </div>
          </div>
          <h2 id="accordion-collapse-heading-2">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left  text-gray-500  border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-2" aria-expanded="<?=(is_null($topics) or $topics == "") ? "true" : "false" ?>" aria-controls="accordion-collapse-body-2">
              <span>Select Topics</span>
              <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-2" class="hidden rounded-b-xl" aria-labelledby="accordion-collapse-heading-2">
            <div class="p-5  border-gray-200 dark:border-gray-700">
              <div class="grid grid-cols-4">
                <?php
                  $topics = explode(",", $topics);
                  //print_r($topics);
                  
                  foreach($topicsArray as $topic) {
                    ?>
                    <div>
                      <input type="checkbox" id="topic_<?=htmlspecialchars($topic)?>" class= "topicSelector" value="<?=htmlspecialchars($topic)?>" onchange="topicAggregate();" <?php
                        if(count($topics)>0 && $topics[0] != "") {
                          //if(in_array($topic, $topics)) {
                          if(startsWithAny($topic, $topics)) {
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
              <?php
              if(count($topicsArray)>0) {
              ?>
                <input type="hidden" name="topics" id="topicSelect">
                <input type="submit" value="Choose Topics" class="rounded border border-sky-300 bg-sky-300 w-full mt-2 text-white hover:bg-sky-200">
              <?php
              }
              ?>

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

    <?php
    
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

<script>

  topicAggregate();

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

  //console.log(topicString);
  //console.log(topicSelect);
  topicSelect.value = topicString;
}
</script>


<?php   include($path."/footer_tailwind.php");?>



