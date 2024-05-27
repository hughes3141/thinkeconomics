<?php 

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$permissions = "";

if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userId = $_SESSION['userid'];
  $permissions = $userInfo['permissions'];
  if (!(str_contains($permissions, 'main_admin'))) {
    header("location: /");
  }

}

$eduqasCodeShow = null;

if(str_contains($permissions, "eduqas_code_show")) {
  $eduqasCodeShow = 1;
}

$style_input = "";

$exercises = getExerciseList(null, 1);
$topics = getTopics();
$topicConverter = array();
$topicFamilyCodes = array();
$topicFamilyCodesConverter = array();

foreach($topics as $topic) {
  $topicConverter[$topic['topicCode']] = $topic['shortName'];

  $topicFamilyCode = substr($topic['topicCode'],0,3);
  if(!in_array($topicFamilyCode, $topicFamilyCodes)) {
    array_push($topicFamilyCodes, $topicFamilyCode);
    $topicFamilyCodesConverter[$topicFamilyCode] = $topic['topicFamily'];
  }
}

$broadTopics = array('1'=>"Microeconomics", '2'=>"Macroeconomics", '3'=>'Global Economics');

$usedBroadTopics = array();
foreach($exercises as $exercise) {
  $broadTopic = $exercise['topic'][0];
  if(!in_array($broadTopic, $usedBroadTopics)) {
    array_push($usedBroadTopics, $broadTopic);
  }
}

$usedTopicFamilies = array();
foreach($exercises as $exercise) {
  $topicFamily = substr($exercise['topic'],0,3);
  if(!in_array($topicFamily, $usedTopicFamilies)) {
    array_push($usedTopicFamilies, $topicFamily);
  }
}

$usedTopics = array();
foreach($exercises as $exercise) {
  $topic = $exercise['topic'];
  if(!in_array($topic, $usedTopics)) {
    array_push($usedTopics, $topic);
  }
}


include($path."/header_tailwind.php");



?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Exercises</h1>
  <div class="container mx-auto p-4 mt-2 bg-white text-black mb-5">
    <div>
      <?php
      /*
      print_r($exercises);
      print_r($broadTopics);
      print_r($usedBroadTopics);
      print_r($usedTopics);
      print_r($topicConverter);
      print_r($topicFamilyCodesConverter);
      print_r($usedTopicFamilies);
      */

      ?>
    </div>
    <ul class="list-none">
      <?php
      foreach($usedBroadTopics as $usedBroadTopic) {
        ?>
        <div>
          <h2 class="text-xl bg-sky-200 my-2 p-1 rounded sticky top-12 lg:top-20 z-20"><?=$broadTopics[$usedBroadTopic]?></h2>
          <?php
          foreach($usedTopicFamilies as $topicFamily) {
            if($topicFamily[0] == $usedBroadTopic) {
            ?>
            <div>
              <h3 class="text-lg bg-pink-200 my-2 p-1 rounded sticky top-20 lg:top-28 z-10 "><?=$eduqasCodeShow ? $topicFamily." " : ""?><?=$topicFamilyCodesConverter[$topicFamily]?></h3>
              <?php
                foreach($usedTopics as $topic) {
                  if(substr($topic,0,3) == $topicFamily) {
                    ?>
                    <div>
                      <h3 class="text-base bg-pink-100 mt-2 p-1 rounded z-0"><?=$eduqasCodeShow ? $topic." " : ""?><?=$topicConverter[$topic]?></h3>
                      <?php
                        foreach($exercises as $exercise) {
                          if($exercise['topic'] == $topic) {
                            ?>
                            <li class="hover:bg-sky-100 rounded pl-1"><a class ="block" href = "exercises/<?=$exercise['link']?>"><?=$eduqasCodeShow ? "" : ""?><?=$exercise['name']?></a></li>
                            <?php
                          }
                        }
                      ?>
                    </div>
                    <?php
                    }
                }
              ?>
              
            </div>
            <?php
          }
          }
          ?>
        </div>
        <?php
      }
      ?>
    </ul>
  </div>
</div>



<?php include "footer_tailwind.php"; ?>
