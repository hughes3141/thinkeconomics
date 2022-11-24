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


              //Get topics as GET variables

              //print_r($_GET);


              
              if(isset($_GET['topic'])) {
                $_GET['topics'] = $_GET['topic'];
              }

              $questionNosBool = 0;
              if(isset($_GET['questionNos'])) {
                $questionNosBool = 1;
              }

              $topicShowBool = 0;
              if(isset($_GET['topicShow'])) {
                $topicShowBool = 1;
              }
              



              //Array of questions set by the teacher, filtered by topic:

              $questions = array();
              //Select questions made by the teacher, filter by topic

              $bindArray = array();
              $paramType = "";

              $sql="SELECT * FROM saq_question_bank_3 WHERE";

                if(isset($_GET['topics'])) {

                  $topics = explode(",", $_GET['topics']);
                  $sql .= "  (";
                  $count=count($topics);
                  for($x=0; $x<$count; $x++) {
                    $sql .= "topic = ? ";
                    if($x<$count-1) {
                      $sql .= " OR ";
                    } 
                    $paramType .="s";
                  }
                  $sql .= ") AND";
                  $bindArray = $topics;
                }
              //$sql .=  "  userCreate = ? AND type LIKE '%flashCard%'";
              $sql .=  "  ( subjectId = '1') AND type LIKE '%flashCard%'";

              //echo $sql;
              #just using "AND model_answer <> ''" so we return cards with answers
              $stmt = $conn->prepare($sql);
              //array_push($bindArray, $teacher);

              //$stmt->bind_param($paramType."i", ...$bindArray);

              if(count($bindArray)>0) {
                $stmt->bind_param($paramType, ...$bindArray);
              }
              $stmt->execute();
              $result = $stmt->get_result();
              if($result ->num_rows >0) {
                while ($row=$result->fetch_assoc()) {
                  //print_r($row);
                  
                  // Following for testing purposes to isolate to one question, randomly question where id = 613
                  //if($row['id']==613) {array_push($questions, $row);}

                  //Push each row into the $questions array.

                  array_push($questions, $row);


                  
                }
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
                  array_push($randomQuestions, $questions[$random]);
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


-->


<div id="wholeContainer" class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">

  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Quick Revision Quiz</h1>
  <div id="gridContainer" class="container mx-auto px-0 mt-2 bg-white text-black ">
    <div  class="grid md:grid-cols-2 gap-4">    
      <?php 
      $questionNumber = 1;
      foreach($randomQuestions as $key=>$question) {
        ?>
        
        <div class="content-center">
          <div class=" question text-center m-3 py-2 px-4 whitespace-pre-line text-black border-4 border-pink-400  rounded-lg shadow-md hover:border-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" onclick="showAnswers(<?=$key;?>)"> <!-- bg-pink-400 text-white font-semibold--> <?php
              if($questionNosBool == 1) {
                echo $questionNumber.": ";
              } 
              echo htmlspecialchars(trim($question['question']));
              if($topicShowBool == 1) {
                echo " 
                <i>(".$question['topic'].")</i>";
              }
              ?>

        </div>
          <div class="answer hidden    m-3 py-2 px-4 border-4 border-sky-300 rounded-lg whitespace-pre-line"><?//=$question['topic'];?><?=htmlspecialchars(trim($question['model_answer']));?>

          </div>
          
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
        var contain = document.getElementById("gridContainer");
        let text = "minmax(0, 1fr) ";
        let text2 = text.repeat(num);
        contain.style.gridTemplateColumns = text2;
      }

    var columnGap = 1;
    var margin = 0.75;

    function changeGap(input) {
      var contain = document.getElementById("gridContainer");
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