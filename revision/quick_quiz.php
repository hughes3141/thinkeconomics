<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


if (!isset($_SESSION['userid'])) {
  
  //header("location: /login.php");
  
}

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");
include ($path."/header_tailwind.php");

//Set img path:

/**
 * images find the path set via $question['q_path'] etc.
 * This is assumed to be in root foler if thinkeonomics
 * If other site: udpate variable $imgSourcePathPrefix to 
 */

 $imgSourcePathPrefix = "";
 $imgSourcePathPrefix = "https://www.thinkeconomics.co.uk";


//Get topics as GET variables
$topics = null;

if(isset($_GET['topic'])) {
  $topics = $_GET['topic'];
}

if(isset($_GET['topics'])) {
  $topics = $_GET['topics'];
}

$questionNosBool = 0;
if(isset($_GET['questionNos'])) {
  $questionNosBool = 1;
}

$topicShowBool = 0;
if(isset($_GET['topicShow'])) {
  $topicShowBool = 1;
}

$noQImgBool = 0;
if(isset($_GET['noQImg'])) {
  $noQImgBool = 1;
}


/*
The following function calls rows from saq_question_bank_3 with the following parameters:
  -questionId = null
  -topic LIKE $_GET['topic'] or ['topics']
  -flashCard bool true
  -subjectId = 1 (Economics)
  -userId = 1
*/
$questions = getSAQQuestions(null,  $topics, 1, 1, 1);

if(isset($_GET['qId'])) {
  $questions = getSAQQuestions($_GET['qId']);
}

if (isset($_GET['test'])) {
  echo count($questions)."<br>";
  print_r($questions);
}



$randomQuestions=array();
$number = 10;

if(isset($_GET['number'])) {
  $number = $_GET['number'];
}

//echo $number;

for($x=0; $x<$number; $x++) {
  $max = count($questions) -1;
  if($max>=0) {
    $random = rand(0,$max);
    if($noQImgBool == 0) {
      array_push($randomQuestions, $questions[$random]);
    } else {
      if($questions[$random]['img'] == "" and $questions[$random]['q_path'] == "" ) {
        array_push($randomQuestions, $questions[$random]);
      } else {
        $x --;
      }
    }
    
    array_splice($questions,$random,1);
  }

}

//print_r($randomQuestions);

              

?>

<!--

GET Variables:
  topic
  topics
  number:number of questions =10
  questionNos if set then question numbers displayed
  topicShow if set then topics are displayed
  noQImg: filters out questions that have image in question
  test: shows testing data e.g. print_r;


-->


<div id="wholeContainer" class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">

  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Quick Revision Quiz</h1>
  
  <?php


      //print_r($questions);

  ?>

  <div id="gridContainer" class="container mx-auto px-0 mt-2 bg-white text-black ">
    <div id="gridContainer2" class="grid md:grid-cols-2 gap-4">    
      <?php 
      $questionNumber = 1;
      foreach($randomQuestions as $key=>$question) {
        ?>
        
        <div class="content-center">
          <?php
            if(isset($_GET['test'])) {
              print_r($question);
            }
          ?>
          <div class=" question text-center m-3 py-2 px-4  text-black border-4 border-pink-400  rounded-lg shadow-md hover:border-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" onclick="showAnswers(<?=$key;?>)">
          <!-- bg-pink-400 text-white font-semibold--> 
          <div class = "whitespace-pre-line"><?php
              if($questionNosBool == 1) {
                echo $questionNumber.": ";
              } 
              echo htmlspecialchars(trim($question['question']));
              if($topicShowBool == 1) {
                echo " 
                <i>(".$question['topic'].")</i>";
              }
            ?></div>

            <?php
            
            if($question['img'] != "") {
              ?>
                  <img class = "mx-auto object-center " src= "<?=$imgSourcePathPrefix.htmlspecialchars($question['img'])?>" alt = "">
            <?php
              }
            if($question['q_path'] != "") {
              ?>
              <img class = "mx-auto object-center " src= "<?=$imgSourcePathPrefix.htmlspecialchars($question['q_path'])?>" alt = "<?=htmlspecialchars($question['q_alt'])?>">
              <?php
            }

          ?>

        </div>
          <div class="answer hidden    m-3 py-2 px-4 border-4 border-sky-300 rounded-lg "><?//=$question['topic'];?>
            <div class="whitespace-pre-line"><?=htmlspecialchars(trim($question['model_answer']));?></div>
            <?php

          if($question['answer_img'] != "") {
            ?><img class = "object-center " src= "<?=$imgSourcePathPrefix.htmlspecialchars($question['answer_img'])?>" alt = "<?=htmlspecialchars($question['answer_img_alt'])?>">
            <?php
          }

          if($question['a_path'] != "") {
            ?>
              <img class = "object-center " src= "<?=$imgSourcePathPrefix.htmlspecialchars($question['a_path'])?>" alt = "<?=htmlspecialchars($question['a_alt'])?>">
            <?php
          }
          
          
          ?></div>
          
        </div>

        <?php

        $questionNumber ++;

      }
    ?>


    </div>
    
    
  </div>
</div>

<div class="container mx-auto px-4 lg:w-3/4">
  <p>Number of Columns: <?php
        for($x=1; $x<5; $x++) {
          ?>
          <button class=" hover:bg-pink-400 text-white py- px-2 rounded" onclick=changeColumns('<?=$x?>')><?=$x?></button>
          <?php
        }
      
      ?> Gap: <button class=" hover:bg-pink-400 text-white py- px-2 rounded" onclick=changeGap("-")>-</button> 
              <button class=" hover:bg-pink-400 text-white py- px-2 rounded" onclick=changeGap("+")>+</button>
      Width: <button class=" hover:bg-pink-400 text-white py- px-2 rounded" onclick=changeWidth("-")>-</button>
              <button class=" hover:bg-pink-400 text-white py- px-2 rounded" onclick=changeWidth("+")>+</button>
      </p>
</div>

<?php
  foreach ($questions as $question) {
    //echo $question['topic']."<br>";
  }
?>


<script>


  function showAnswers(num) {
        var answers = document.getElementsByClassName("answer");
        for (var i=0; i<answers.length; i++) {
          if (i == num) {
            answers[i].classList.remove("hidden");
          }

        }
        
        var questions = document.getElementsByClassName("question");
        for (var i=0; i<questions.length; i++) {
          if (i == num) {
            questions[i].classList.remove("bg-pink-400");
            questions[i].classList.add("border-sky-300");
          }

        }

      }

    function changeColumns(num) {
        var contain = document.getElementById("gridContainer2");
        let text = "minmax(0, 1fr) ";
        let text2 = text.repeat(num);
        contain.style.gridTemplateColumns = text2;
      }

    var columnGap = 1;
    var margin = 0.75;

    function changeGap(input) {
      var contain = document.getElementById("gridContainer2");
      var questions = document.getElementsByClassName("question");
      var answers = document.getElementsByClassName("answer");
      let change = 0.25
      if(input == "+") {
        columnGap += change;
        margin += change;
      }
      if(input == "-") {
        if(columnGap > 0) {
          columnGap -= change;
        }
        if(margin > 0) {
          margin -= change;
        }
      }
      contain.style.columnGap = columnGap+"rem";
      contain.style.rowGap = columnGap+"rem";
      for(var i=0; i<questions.length; i++) {
        questions[i].style.margin = margin+"rem";
        answers[i].style.margin = margin+"rem";
      }

    }

    function changeWidth(input) {
      var widths = [640, 768, 1024, 1280, 1536];
      var container = document.getElementById("wholeContainer");
      var gridContainer = document.getElementById("gridContainer");

      container.style.maxWidth = "100%";
      gridContainer.style.maxWidth = "100%";
      if (input == "+") {
        container.style.width = container.offsetWidth +100+"px";
        gridContainer.style.width = container.offsetWidth +100+"px";

      }

      if (input == "-") {
        container.style.width = container.offsetWidth -100+"px";
      }

      //console.log(container.offsetWidth);
    }

    //changeWidth("input");
</script>

<?php include ($path."/footer_tailwind.php");