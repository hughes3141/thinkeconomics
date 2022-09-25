<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userType = $userInfo['usertype'];
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
}

include ($path."/header_tailwind.php");


$quiz = array();
$assign = array();
$questions = array();
$topic = "";
$quizzes = array();
$topicSet = false;

if(isset($_GET['quizid'])) {
  $quiz = getMCQquizInfo($_GET['quizid']);
}

if(isset($_GET['assignid'])) {
  $assign = getAssignmentInfoById($_GET['assignid']);
  if($assign['type'] = 'mcq') {
    $quiz = getMCQquizInfo($assign['quizid']);
  }
  
}

if(isset($quiz['questions'])) {
  $questions = explode(",", $quiz['questions']); 
} 

if(isset($_GET['width'])) {
  $width = $_GET['width'];
}

if(isset($_GET['topic'])) {
  $topic = $_GET['topic'];

  $quizlist = getMCQquizzesByTopic($topic);
  
  if($quizlist) {
    $topicSet = true;
  }
  
}




?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">MCQ Preview Simple</h1>
    <div class="container mx-auto px-0 mt-2 bg-white text-black ">
      <?php
        if($topicSet) {

        
        //print_r($quizlist);

            foreach($quizlist as $quiz) {
              ?>
              <form method="get" action ="">
                <input type = "hidden" value="<?=$quiz['id']?>" name = "quizid">
                <input type = "submit" value ="<?=$quiz['quizName']?>" class="grow m-3 py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
              </form>
              <?php
            }
          }

          if(!$_GET) {
            ?>
            <h2>GET variables:</h2>
            <ul>
              <li>quizid: id of mcq quiz to preview</li>
              <li>assignid: id of assignment which references mcq quiz to preview</li>
              <li>topic: topics to filter for mcq quizzes (returns form)</li>
              <li>width: change &percnt; width of images</li>
            </ul>
            <?php
          }
      ?>
      <br><br><br>


  <?php
  
    //print_r($quiz);

    //print_r($questions);  
    //print_r($_GET);

    foreach($questions as $question) {
      $question = trim($question);
      
      ?>
      <p><?=$question?></p>
      <img src = "question_img/<?=$question?>.JPG" style="<?php if(isset($width)){echo "width: ".$width."%";}?>">

      <?php


    }

  ?>
  <br><br><br>
    </div>
</div>



<?php include ($path."/footer_tailwind.php");?>