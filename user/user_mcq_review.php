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
  $userId = $_SESSION['userid'];
  $schoolId = $userInfo['schoolid'];
  $permissions = $userInfo['permissions'];
  
}
$style_input = ".hide {
    display: none;
    }
    input, button, textarea, th, td, select {
      border: 1px solid black;
    }
    td, th {
      padding: 5px;
    }

    .wrongAnswer {
        background-color: rgb(249 168 212);
    }
    .questionSummary {
        //border-top: 1px solid black;
  
    
    ";

include($path."/header_tailwind.php");

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">MCQ Exercise Review</h1>
    <div class="font-mono container mx-auto py-2 px-2 mt-2 bg-white text-black mb-5">
        <p class="">Name: <?=$userInfo['name_first']?> <?=$userInfo['name_last']?></p>


        <?php

        $results = getMCQquizResults($userId);
        if(isset($_GET['responseId'])) {
          $responseId = $_GET['responseId'];
        }
        echo "<pre>";
        //print_r($_GET);

        //print_r($results[2]);        
        echo "</pre>";

        if (count($results)>0) {
          ?>
        <div id="accordion-collapse" data-accordion="collapse" class="my-2 border rounded-xl border-gray-200 mt-2 mb-2">
          <h2 id="accordion-collapse-heading-1">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="<?=(empty($responseId)) ? "true" : "false"?>" aria-controls="accordion-collapse-body-1">
              <span>MCQ Record</span>
              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
              </svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
            <div class=" py-5  border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
              <table class="w-full table-fixed font-sans">
                <tr class="font-mono sticky">
                    <th class="text-xs md:text-lg"><span class="hidden md:inline">MCQ </span>Exercise<span class="hidden md:inline"> Name</span></th>
                    <th class="text-xs md:text-lg hidden md:table-cell">Mark</th>
                    <th class="text-xs md:text-lg"><span class="hidden md:inline">Percentage</span><span class="inline md:hidden">&percnt;</span></th>
                    <th class="text-xs md:text-lg">Date</th>
                    <th class="text-xs md:text-lg">Assignment</th>
                    <th class="text-xs md:text-lg">Review</th>
                </tr>
                <?php
                foreach($results as $result) {
                    ?>
                <tr>
                    <?php
                      $linkPlaceHolder = "";
                      if($result['assignID'] != 0) {
                        $linkPlaceHolder = "assignid=".$result['assignID'];
                      }
                      else {
                        $linkPlaceHolder = "quizid=".$result['quizId'];
                      }
                    ?>
                    <td class="text-xs md:text-lg break-words "><a class ="hover:bg-pink-200 hover:underline" href="/mcq/mcq_exercise.php?<?=$linkPlaceHolder?>"><?=$result['quiz_name']?></a></td>
                    <td class="hidden md:table-cell text-center"><?=$result['mark']?></td>
                    <td class="text-center"><?=$result['percentage']?>&percnt;</td>
                    <td class="text-xs md:text-lg break-words"><?php
                        $phpdate = strtotime($result['datetime']);
                        $mysqldate = date( 'd M y', $phpdate );
                        $mysqltime = date( 'h:ia', $phpdate );
                        echo $mysqldate;
                        echo "<br>";
                        echo $mysqltime;
                    ?></td>
                    <td class="text-xs md:text-lg break-words"><?php
                        if($result['assignId'] == "") {
                            echo "--";
                        }
                        else {
                            echo $result['assignName'];
                        }
                    ?></td>
                    <td>
                        <form method ="get" action ="">
                            <input type = "hidden" name = "responseId" value = "<?=$result['id']?>">
                            <input class="bg-pink-300 rounded border border-pink-300 hover:bg-pink-200 text-gray-800 text-sm md:text-lg w-full md:px-2 py-2 hover"type = "submit" value="Review">
                    </form>
                    </td>
                </tr>
                    <?php
                }

                ?>

              </table>
            </div>
          </div>
        </div>


          <?php
        }


        ?>
        <?php

            if(isset($_GET['responseId'])) {
                $responses = getMCQquizResults($userId, $_GET['responseId']);
                //print_r($responses);
                if(count($responses)>0) {
                    ?>
                    <h2 class="w-full bg-pink-300 rounded p-1 text-xl mb-2">MCQ Review: <?=$responses['quiz_name']?></h2>
                    <?php
                    $phpdate = strtotime($responses['datetime']);
                    $mysqldate = date( 'd M y', $phpdate );
                    $mysqltime = date( 'h:ia', $phpdate );
                    ?>
                    <p>Completed: <?=$mysqltime?> <?=$mysqldate?> </p>
                    <p>Score: <?=$responses['mark']?> (<?=$responses['percentage']?>&percnt;)</p>
                    <?php
                    $questions = json_decode($responses['answers']);
                    //print_r($questions);

                    foreach($questions as $key=>$question) {
                        $questionDetails = getMCQquestionDetails(null, $question[0]);
                        //print_r($questionDetails);
                        ?>
                        <div class="questionSummary border-2  border-pink-300 rounded-xl my-2 p-2">
                            <h2>Question <?=(intval($key) +1)?></h2>
                            <p class="text-sm"><i><?=$question[0]?></i></p>
                            <img src = "https://www.thinkeconomics.co.uk/mcq/question_img/<?=$question[0]?>.JPG">
                            <?php
                            $wrongAnswer = 1;
                            if($question['3']==true) {
                              $wrongAnswer = 0;
                            }
                            ?>
                            <p class ="">Your Answer:<span class="py-1 px-2 <?=($wrongAnswer == 1 ) ? 'bg-pink-300 ' : '' ?>"><?=$question[1]?></span></p>
                            <p class ="correctAnswer">Correct Answer: <?=$question[2]?></p>
                            <?php
                              $explanations = json_decode($questionDetails['explanation']);
                              $explanations = (array) $explanations;
                              if(count($explanations) > 0) {
                                ?>
                                <div class="p-1 border border-sky-100 rounded bg-sky-100">
                                  <p class="underline">Explanation<?=count($explanations)>1 ? "s" : ""?>:</p>
                                  <?php
                                    foreach($explanations as $key2=>$explanation) {
                                    $username = getUserInfo($key2)['username'];
                                    ?>
                                    <p class="text-pink-500 "><?=$username?>:</p>
                                    <p class ="whitespace-pre-line font-sans"><?=$explanation?></p>
                                    <?php
                                }
                                ?>
                                </div>
                                <?php
                              }
                            ?>
                        </div>
                        <?php
                    }
                }

            }

        ?>


    </div>
</div>

<?php   include($path."/footer_tailwind.php");?>