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



$get_selectors = array(
  'quizid' => (isset($_GET['quizid'])&&$_GET['quizid']!="") ? $_GET['quizid'] : null,
  'assignid' => (isset($_GET['assignid'])&&$_GET['assignid']!="") ? $_GET['assignid'] : null,
  'questions' => (isset($_GET['questions'])&&$_GET['questions']!="") ? $_GET['questions'] : null,
  'simple' => (isset($_GET['simple'])&&$_GET['simple']!="") ? $_GET['simple'] : null,
  'answerShow' => (isset($_GET['answerShow'])&&$_GET['answerShow']!="") ? $_GET['answerShow'] : null,
  
  'topic' => (isset($_GET['topic'])&&$_GET['topic']!="") ? $_GET['topic'] : null,
  'width' => (isset($_GET['width'])&&$_GET['width']!="") ? $_GET['width'] : null,
  'noDetailShow' => (isset($_GET['noDetailShow'])&&$_GET['noDetailShow']!="") ? $_GET['noDetailShow'] : null


);

if($get_selectors['simple']!=1) {
  include ($path."/header_tailwind.php");
} else {
  ?>

  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>MCQ Preview</title>
      <link rel="stylesheet" href="style.css">
    </head>
    <body>


  <?php
}


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
  $questions = explode(",", $quiz['questions_id']); 
} 

if(isset($_GET['width'])) {
  $width = $_GET['width'];
}



if($get_selectors['questions']) {
  $questionIds = explode(",",$get_selectors['questions']);
  //print_r($questionIds);
  foreach($questionIds as $id) {
    array_push($questions, $id);
  }
}




?>

<!--
  $_GET:
    quizid: id of mcq quiz to preview
    assignid: id of assignment which references mcq quiz to preview
    width: change &percnt; width of images


-->

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 " style="<?=($get_selectors['simple']) ? "display:none" : ""?>">MCQ Preview</h1>
    <div class="container mx-auto px-0 mt-2 bg-white text-black ">
      <form method="get" action = "">
        <span style="<?=($get_selectors['simple']) ? "display:none" : ""?>">
          <label id="quizid_select">quizid: </label>
          <input type="text" style="width:50px" name="quizid" id="quizid_select" value="<?=$get_selectors['quizid']?>">

          <label id="width_select">width(&percnt;): </label>
          <input type="text" style="width:50px" name="width" id="width_select" value="<?=$get_selectors['width']?>">

          <input type="checkbox" name="noDetailShow" value= "1" id="noDetailShow_select" <?=($get_selectors['noDetailShow']==1) ? "checked" : ""?>>
          <label for="noDetailShow_select">Hide Details</label>
          <input type="checkbox" name="answerShow" value= "1" id="answerShow_select" <?=($get_selectors['answerShow']==1) ? "checked" : ""?>>
          <label for="answerShow_select">Show Answers</label>
        </span>
        <input type="checkbox" name="simple" value= "1" id="simple_select" <?=($get_selectors['simple']==1) ? "checked" : ""?>>
        <label for="simple_select">Simple Preview</label>

        <input type="hidden" name="questions" value="<?=$get_selectors['questions']?>">
        <input type="submit" value="Submit">
      </form>




  <?php
  
    //print_r($quiz);

    //print_r($questions);  
    //print_r($_GET);
    $imgSource = "https://thinkeconomics.co.uk";

    foreach($questions as $question) {
      $question = getMCQquestionDetails2($question)[0];
      //print_r($question);
      
      ?>
      <!-- <?=$question['id']?>-->
      <?php
      if($get_selectors['noDetailShow']!=1) {

      
      ?>
      <h3 style="font-weight:normal; font-family:"><?=$question['examBoard']?> <?=$question['qualLevel']?> <?=$question['component']?> <?=$question['series']?> <?=$question['year']?> Q<?=$question['questionNo']?></h3>
      
      <?php
      }


			$imgPath = "";
			if($question['path'] == "") {
				$imgPath = $question['No'].".JPG";
			} else {
				$imgPath = $question['path'];
			}
			$img = $imgSource."/mcq/question_img/".$imgPath;
      ?>
      <img src="<?=$img?>" alt="<?=$question['No']?>" style="<?=($get_selectors['width']) ? "width: ".$get_selectors['width']."%" : ""?>">
      

      <?php

      if($get_selectors['answerShow'] ==1) {
        ?>
        <p>Answer: <?=$question['Answer']?></p>
        
      <?php
      }


    }



  ?>

    </div>
</div>

<?php
if($get_selectors['simple']!=1) {

  include ($path."/footer_tailwind.php");
} else {
  ?>
      <script src="index.js"></script>
    </body>
  </html>
  <?php
}

?>