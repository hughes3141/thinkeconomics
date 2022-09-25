<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");
include ($path."/header_tailwind.php");

/*
Notes on command GET variables:
  -$_GET['topics'] or $_GET['topic'] : Enter comma-separated string of topic strings, to limit questions to particular topics;
  -$_GET['restrict'] : to change the time until a card is recycled. With following parameters:
    - !isset($_GET['restrict']) : default, 3 days and 5 days
    - $_GET['restrict'] = 'none' : No wait, cards immediately recycled
    - $_GET['restrict'] = '0' : No wait, cards immediately recycled
    - $_GET['restrict'] = 'minutes' : 3 mins and 5 mins
*/


?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-1/2">

  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Revision Flashcards</h1>
  <div class="container mx-auto px-0 mt-2 bg-white text-black ">



  <?php

        $userId = $_SESSION['userid'];


        date_default_timezone_set("Europe/London");
        $t = time();


        function lastResponse($questionId) {

          /*
          lastResponse(int $questionId) : array

          Returns the detail about the last time question with $questionId was answered.
          If not answered, returns array with cardCategory=0 and current timeStamps for timeSubmit and timeStart.
          */

          global $conn;
          global $t;  
          global $userId;
          

          $sql = "SELECT * FROM flashcard_responses WHERE userId = ? AND questionId = ? ORDER BY timeSubmit DESC";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ii", $userId, $questionId);
          $stmt->execute();
          $result = $stmt->get_result();

          $row =$result->fetch_assoc();
          if($row) {
            //print_r($row);
            return $lastResponse = $row;

          }
          else {
            //echo "<br>This question has not been attempted yet";
            return $lastResponse = array("cardCategory"=>"0", "timeSubmit"=>date("Y-m-d H:i:s", $t), "timeStart"=>date("Y-m-d H:i:s", $t));
          
          }

          //echo "<br>";
          //print_r($lastResponse);
          

          /*

          if($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
              
              echo "<br>";
              print_r($row);
              
            }
          }
          else {
            echo "<br>This question has not been attempted yet";
          }
          */
        }



        function timeBetween($dateTime) {

          global $t;
          $now = new DateTime(date("Y-m-d H:i:s", $t));
          $last = new DateTime($dateTime);
          $interval = $now->diff($last);
          //return $daysSince = $interval->days;
          return $minutesSince = $interval->i;

          //echo "daysSince:".$daysSince." minutesSince:".$minutesSince;
          
          //echo "<br>".$interval->days;
          //echo "<br>difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ".$interval->h." hours ".$interval->i." minutes ".$interval->s." seconds";

        }

        function secondsBetween($dateTime, $dateTime2) {

          global $t;
          $now = new DateTime($dateTime2);
          $last = new DateTime($dateTime);
          $interval = $now->diff($last);

          $seconds = $interval->days * 24 * 60 * 60;
          $seconds += $interval->h * 60 * 60;
          $seconds += $interval->i * 60;
          $seconds += $interval->s;
          
          return $seconds;

        }



        //echo "<br>Post:";
        //print_r($_POST);


        //Insert response into database
        $stmt = $conn->prepare("INSERT INTO flashcard_responses (questionId,  userId, gotRight, timeStart, timeSubmit, cardCategory, timeDuration, dateSubmit) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissiis", $questionId, $userId, $gotRight, $timeStart, $timeSubmit, $cardCategory, $seconds, $date);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') 

        {
          $questionId = $_POST['questionId'];
          $gotRight = $_POST['rightWrong'];
          $timeStart = $_POST['timeStart'];
          

          $timeSubmit = date("Y-m-d H:i:s",$t);
          //echo "<br>".$timeSubmit."<br>";

          $seconds = secondsBetween($timeStart, $timeSubmit);

          $date = date("Y-m-d", strtotime($timeSubmit));
          //echo $date;

          

          if($gotRight === "0" || $gotRight === "1") {
            $cardCategory = 0;
          }
          else if ($gotRight = 2) {
            if ($_POST['cardCategory'] === "0") {
              $cardCategory = 1;
            } else if ($_POST['cardCategory'] === "1") {
              $cardCategory = 2;
            } else if ($_POST['cardCategory'] === "2") {
              $cardCategory = 2;
            }
          }

          $lastResponse = (lastResponse($_POST['questionId']));

          if ($lastResponse['timeStart'] === $timeStart) {
            //echo "This was a duplicate and will not be entered";
          }
          else {
            
            $stmt->execute();
              
            //echo "New records created successfully";

            


          }
          

          //print_r($lastResponse);
          

          



          
        }

        // Retreive question record.

        $sql = "SELECT * FROM flashcard_responses WHERE userId = ? ORDER BY id ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows>0) {
          while ($row = $result->fetch_assoc()) {
            /*
            echo "<br>";
            print_r($row);
            */
            
          }
        }


  ?>




        <h1 class="hidden">Flashcard Example</h1>

            <?php

            //Find the teacher of the group the student is in
              //Note: this will need to be changed to refledct that multiple teachers may teach a group

              $sql="SELECT * FROM groups WHERE id = ?";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param("i", $_SESSION['groupid']);
              $stmt->execute();
              $result = $stmt->get_result();
              $user = $result->fetch_assoc();

              //print_r($user);

              $teachers = $user['teachers'];

              //echo "<br>".$teachers;

              $teachers = json_decode($teachers);

              //echo "<br>";
              //print_r($teachers);

              //This is what needs to be changed: only the first teacher in the array is included.
              // Change with fucntion that loops through numbe of teachers. Could be done below, e.g. WHERE userCreate LIKE ? OR WHERE userCreate LIKE ? etc.

              $teacher = $teachers[0];

              //echo "<br>".$teacher;


              //Get topics as GET variables

              //print_r($_GET);


              
              if(isset($_GET['topic'])) {
                $_GET['topics'] = $_GET['topic'];
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
              $sql .=  "  userCreate = ? AND type = 'flashCard'";

              //echo $sql;
              #just using "AND model_answer <> ''" so we return cards with answers
              $stmt = $conn->prepare($sql);
              array_push($bindArray, $teacher);

              $stmt->bind_param($paramType."i", ...$bindArray);
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




              //print_r($questions);
              foreach($questions as $question) {
                $last = lastResponse($question['id']);
                //echo "<br>".$question['id'].": ".$question['question']." || "./*$last['gotRight'].*/" ".$last['timeSubmit']." cardCat:".$last['cardCategory']." timeSince: ".timeBetween($last['timeSubmit']);
                
                
                
              }
              //echo "<br>Total questions: ".count($questions);


              /*
              The below loop does the following:
                -Identifies random question from the $questions array.
                -Check to see candidate's last response to this question.
                -Performs the logic:
                  If(The question is eligible to be answered) : Break loop
                  Else IF (the question is ineligible) : Remove question from $queseetions

              */

              $bin1Duration = 3 * 24*60;
              $bin2Duration = 5 *24*60;

              if(isset($_GET['restrict'])) {
                if($_GET['restrict'] == 'none' || $_GET['restrict'] == "0" ) 
                {
                  $bin1Duration = $bin2Duration = 0;
                }
                else if($_GET['restrict'] == 'minutes') {
                  $bin1Duration = $bin1Duration /(24*60);
                  $bin2Duration = $bin2Duration /(24*60);
                }
              }

              $questionSkip = 0;
              
              while (count($questions)>0) {

                  $qCount = count($questions);

                  $randomQuestion = rand(0, $qCount-1);
                  //echo $qCount."<br>".$randomQuestion;

                  if($randomQuestion<0) {
                    $randomQuestion = 0;
                  }

                  //Find the response for the last time this question was answered:

                    $randomQuestionId = $questions[$randomQuestion]['id'];

                    //echo "<br>".$randomQuestionId;

                    $lastResponse = lastResponse($randomQuestionId);

                    //Logic to see if question should appear, based on the bin it is in.

                    
                    //echo $t;
                    //echo date("Y-m-d H:i:s", $t);       
                    //echo $lastResponse['timeSubmit'];

                    $timeSince = timeBetween($lastResponse['timeSubmit']);
                    //echo $timeSince;

                    if (
                      $lastResponse['cardCategory'] == 0 ||
                      (($lastResponse['cardCategory'] == 1 )&&($timeSince>=$bin1Duration) ) ||
                      (($lastResponse['cardCategory'] == 2 )&&($timeSince>=$bin2Duration) )
                    )

                    {
                      //echo "<br>Valid questions: ".$qCount;
                      break;
                    }

                    else {
                      $summary = array();
                      $summary['questionId'] = $questions[$randomQuestion]['id'];
                      $lastResponse = lastResponse($questions[$randomQuestion]['id']);
                      $summary['cardCategory'] = $lastResponse['cardCategory'];
                      $summary['timeSubmit'] = $lastResponse['timeSubmit'];
                      $summary = json_encode($summary);                  
                      echo "<script>console.log(".$summary.")</script>";
                      //$questionSkip ++;
                      
                      array_splice($questions, $randomQuestion, 1);

                      


                    }          
              }
              //echo "<script>console.log(".$questionSkip.")</script>";

              if(count($questions) == 0) {
              
                ?>

                <div  class="font-sans  p-3 m-2">

                <p class="mb-3">Well done! There are no more cards for you to revise.</p>

                </div>


                <?php
                
              } else {
                
                
                

            ?>

            <?php if(isset($_GET['topics'])) {echo "<p class='ml-1'>Topic: ".htmlspecialchars($questions[$randomQuestion]['topic'])."</p>";}?>

            <div id="flashcard" class="font-sans  p-3 m-2">
            
            <?php 
            
            //print_r(lastResponse($questions[$randomQuestion]['id']));
            //echo "<br>".count($questions)."<br>";
            
            ?>

              <form method="post">
              
                <h2 class ="text-lg">Question:</h2>
              
                <input type="hidden" name="questionId" value = "<?=htmlspecialchars($questions[$randomQuestion]['id'])?>">
                <input type="hidden" name="timeStart" value = "<?=date("Y-m-d H:i:s",time())?>">
                <input type="hidden" name="cardCategory" value = "<?=$lastResponse['cardCategory']?>">
                
                <p class="mb-3" style="white-space: pre-line;"><?php echo htmlspecialchars($questions[$randomQuestion]['question']);?></p>
                <p><?php //print_r(lastResponse($questions[$randomQuestion]['id']));?>
                
                <div id="buttonsDiv" class="flex justify-center">
                  <button type = "button" class="grow m-3 py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" onclick="showAnswers();hideButtons();swapButtons()">I don't know</button>
                  <button value ="0" name="rightWrong" class="grow m-3 hidden ">I don't know</button>
                  <button type = "button" class="grow m-3 py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" onclick="showAnswers();hideButtons()">Show answers</button>
                </div>
                
                <div id ="answerDiv" class="hidden">
                  <h2 class ="text-lg">Answer:</h2>
                  <p class="mb-3" style="white-space: pre-line;"><?=htmlspecialchars($questions[$randomQuestion]['model_answer']);?></p>
                  <div id ="buttonsDiv2" class="flex justify-center">
                    <button id = "1Button" value ="1" name="rightWrong" class="grow m-3 py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Wrong Answer</button>
                    <button id = "2Button" value ="2" name="rightWrong" class="grow m-3 py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Correct Answer</button>
                    <button id = "0Button" value ="0" name="rightWrong" class="grow m-3 hidden py-2 px-4 bg-pink-400 text-white font-semibold rounded-lg shadow-md hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Next Question</button>
                  </div>
                </div>

              </form>

            </div>

            <?php } ?>

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


