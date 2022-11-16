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

-->


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">

  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Quick Revision Quiz</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black ">
    <div class="grid md:grid-cols-2 gap-4">    
      <?php 
      $questionNumber = 1;
      foreach($randomQuestions as $key=>$question) {
        ?>
        
        <div class="content-center">
          <div class=" question text-center m-3 py-2 px-4  text-black border-4 border-pink-400  rounded-lg shadow-md hover:border-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" onclick="showAnswers(<?=$key;?>)">

          <!-- bg-pink-400 text-white font-semibold-->

            <?php
              if($questionNosBool == 1) {
                echo $questionNumber.": ";
              }
                
              echo $question['question'];
              ?>

        </div>
          <div class="answer hidden    m-3 py-2 px-4 border-4 border-sky-300 rounded-lg whitespace-pre-line"><?//=$question['topic'];?><?=$question['model_answer'];?>

          </div>
          
        </div>

        <?php

        $questionNumber ++;

      }
    ?>


    </div>
  </div>
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
</script>

<?php include ($path."/footer_tailwind.php");