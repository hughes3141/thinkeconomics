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

$style_input = "
  th, td {
    border: 1px solid black;
  }

  textarea, input {
    padding-left: 0.25rem;
  }

  
  ";



$get_selectors = array(
  'quizid' => (isset($_GET['quizid'])&&$_GET['quizid']!="") ? $_GET['quizid'] : null,
  'assignid' => (isset($_GET['assignid'])&&$_GET['assignid']!="") ? $_GET['assignid'] : null,
  'questions' => (isset($_GET['questions'])&&$_GET['questions']!="") ? $_GET['questions'] : null,
  'simple' => (isset($_GET['simple'])&&$_GET['simple']!="") ? $_GET['simple'] : null,
  'answerShow' => (isset($_GET['answerShow'])&&$_GET['answerShow']!="") ? $_GET['answerShow'] : null,
  
  'topic' => (isset($_GET['topic'])&&$_GET['topic']!="") ? $_GET['topic'] : null,
  'width' => (isset($_GET['width'])&&$_GET['width']!="") ? $_GET['width'] : null,
  'noDetailShow' => (isset($_GET['noDetailShow'])&&$_GET['noDetailShow']!="") ? $_GET['noDetailShow'] : null,
  'gridShow' => (isset($_GET['gridShow'])&&$_GET['gridShow']!="") ? $_GET['gridShow'] : null


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
      <style>
        @media print
          {    
              .no-print, .no-print *
              {
                  display: none !important;
              }
          }
      </style>
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
      <form method="get" action = "" id="control_form" class="no-print">
 
        <label id="quizid_select">quizid: </label>
        <input type="text" style="width:50px" name="quizid" id="quizid_select" value="<?=$get_selectors['quizid']?>">

        <label id="width_select">width(&percnt;): </label>
        <input type="text" style="width:50px" name="width" id="width_select" value="<?=$get_selectors['width']?>">

        <input type="checkbox" name="noDetailShow" value= "1" id="noDetailShow_select" <?=($get_selectors['noDetailShow']==1) ? "checked" : ""?>>
        <label for="noDetailShow_select">Hide Details</label>

        <input type="checkbox" name="answerShow" value= "1" id="answerShow_select" <?=($get_selectors['answerShow']==1) ? "checked" : ""?>>
        <label for="answerShow_select">Show Answers</label>

        <input type="checkbox" name="gridShow" value= "1" id="gridShow_select" <?=($get_selectors['gridShow']==1) ? "checked" : ""?>>
        <label for="gridShow_select">Grid</label>
  
        <input type="checkbox" name="simple" value= "1" id="simple_select" <?=($get_selectors['simple']==1) ? "checked" : ""?>>
        <label for="simple_select">Simple Preview</label>

        <input type="hidden" name="questions" value="<?=$get_selectors['questions']?>">
        <input type="submit" value="Submit">
      </form>
      <button onclick="toggleControls();" class="no-print">Toggle Controls</button>



      <div style="<?=($get_selectors['gridShow'] ==1) ? "display:grid; grid-template-columns: auto auto; grid-gap: 0.25rem; " : ""?>">
        <?php
        
          //print_r($quiz);

          //print_r($questions);  
          //print_r($_GET);
          $imgSource = "https://thinkeconomics.co.uk";

          foreach($questions as $question) {
            $question = getMCQquestionDetails2($question)[0];
            //print_r($question);
            
            ?>
            <div id="id_<?=$question['id']?>" class="p-1">
            <!-- <?=$question['id']?>-->
            <?php
            if($get_selectors['noDetailShow']!=1) {

            
            ?>
            <h3 style="font-weight:normal; font-family:"><?=$question['examBoard']?> <?=$question['qualLevel']?> <?=$question['component']?> <?=$question['series']?> <?=$question['year']?> Q<?=$question['questionNo']?></h3>
            
            <?php
            }

            if($question['textOnly'] == 1) {
              $rootImgSource = "https://www.thinkeconomics.co.uk";
              ?>
              <div class=""  class="border border-black p-1">
              <?php
                $question1 = explode("\n", $question['question']);
                foreach($question1 as $p) {
                  ?>
                  <p class="mb-1"><?=$p?></p>
                  <?php
                }
                if($question['midImgAssetId'] != "") {
                  $midImgAssets = explode(",", $question['midImgAssetId']);
                  foreach($midImgAssets as $key => $asset) {
                    $midImgAssets[$key] = trim($asset);
                    if(count(getUploadsInfo($asset)) >0) {
                      $asset = getUploadsInfo($asset)[0];
                      //print_r($asset);
                      ?>
                      <img alt ="<?=$asset['altText']?>" src="<?=$rootImgSource.$asset['path']?>">
                      <?php
                    }
                  }
                }

                if($question['midTableArray'] != "") {
                  $midTableArray = json_decode($question['midTableArray']);
                  //print_r($midTableArray);
                  ?>
                  <h2 class=" font-bold text-center my-1"><?=$question['midTableHeader']?></h2>
                  <table class="mx-auto my-1">
                  <?php
                  foreach ($midTableArray as $row) {
                    ?>
                    <tr>
                      <?php
                      foreach($row as $cell) {
                        ?>
                        <td class="px-4 text-center "><?=$cell?></td>
                        <?php
                      }
                      ?>
                    </tr>
                    <?php

                  }
                  ?>
                  </table>
                  <?php
                }

                $question2 = explode("\n", $question['question2']);
                foreach($question2 as $p) {
                  ?>
                  <p class="mb-1"><?=$p?></p>
                  <?php
                }
                $options =(array) json_decode($question['options']);
                if($question['optionsTable'] == 0) {
                  //echo "<ul>";
                  foreach ($options as $key=>$option) {
                    if($key != $option){
                      ?>
                        <p style="<?=($get_selectors['simple']==1) ? "margin: 0px; margin-left:1.25rem;" : ""?>"><?=$key?>: <?=$option?></p>
                      <?php
                    }
                  }
                  //echo "</ul>";
                } else {
                  ?>
                  <table class="mx-auto my-1">
                    <tr >
                      <?php
                        $headerRow = $question['optionsTableHeading'];
                        $headerRow = explode("     ",$headerRow);
                        foreach ($headerRow as $cell) {
                          ?>
                          <td class="px-4 text-center "><?=$cell?></td>
                          <?php
                        }
                      ?>
                    </tr>
                    <?php
                      foreach($options as $key=>$option) {
                        $optionRows = explode("     ",$option);
                        ?>
                        <tr>
                          <td class="px-4 text-center "><?=$key?></td>
                          <?php
                            foreach($optionRows as $cell) {
                              ?>
                              <td class="px-4 text-center ">
                                <?=$cell?>
                              </td>
                              <?php
                            }
                          ?>
                        </tr>

                        <?php
                      }
                    ?>
                  </table>
                  <?php
                  }
              ?>
              </div>
              <?php

            } else {
              $imgPath = "";
              if($question['path'] == "") {
                $imgPath = $question['No'].".JPG";
              } else {
                $imgPath = $question['path'];
              }
              $img = $imgSource."/mcq/question_img/".$imgPath;
              ?>
              <img src="<?=$img?>" alt="<?=$question['No']?>" style="<?=($get_selectors['width']) ? "width: ".$get_selectors['width']."%" : "width:100%"?>">
              <?php
            }

            if($get_selectors['answerShow'] ==1) {
              ?>
              <p>Answer: <?=$question['Answer']?></p>
              
            <?php
            }

            ?>
            </div>
            <?php


          }



        ?>
      </div>

    </div>
</div>

<script>

  function toggleControls() {
    var form = document.getElementById("control_form");
    console.log(form);
    var state = window.getComputedStyle(form).display;
    console.log(state);
    if(state == "block") {
      form.style.display = "none";
    }
    if (state == "none") {
      form.style.display = "block";
    }


  }
</script>

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