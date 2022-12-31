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
        border-top: 1px solid black;
  
    
    ";

include($path."/header_tailwind.php");

?>


<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">MCQ Exercise Review</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
        <p>Name: <?=$userInfo['name_first']?> <?=$userInfo['name_last']?></p>
        <?php
            $results = getMCQquizResults($userId);
            echo "<pre>";
            //print_r($_GET);
            
            //print_r($results[2]);        
            echo "</pre>";
            if(isset($_GET['responseId'])) {
                $responses = getMCQquizResults($userId, $_GET['responseId']);
                //print_r($responses);
                if(count($responses)>0) {
                    ?>
                    <h2>MCQ Review: <?=$responses['quiz_name']?></h2>
                    <p>Name: <?=$responses['name_first']?> <?=$responses['name_last']?></p>
                    <p>Score: <?=$responses['mark']?> (<?=$responses['percentage']?>&percnt;)</p>
                    <?php
                    $questions = json_decode($responses['answers']);
                    //print_r($questions);

                    foreach($questions as $key=>$question) {
                        ?>
                        <div class="questionSummary">
                            <h2>Question: <?=(intval($key) +1)?></h2>
                            <p><i><?=$question[0]?></i></p>
                            <img src = "https://www.thinkeconomics.co.uk/mcq/question_img/<?=$question[0]?>.JPG">
                            <p class ="userAnswer <?=$question['3']=="1" ? "" : "wrongAnswer"?>">Your Answer: <?=$question[1]?></p>
                            <p class ="correctAnswer">Correct Answer:<?=$question[2]?></p>
                        </div>
                        <?php
                    }
                }

            }
            if (count($results)>0) {
                ?>
            <table class="w-full table-fixed">
                <tr>
                    <th>MCQ Exercise Name</th>
                    <th>Mark</th>
                    <th>Percentage</th>
                    <th>Date</th>
                    <th>Assignment</th>
                    <th>Review</th>
                </tr>
                <?php
                foreach($results as $result) {
                    ?>
                <tr>
                    <td><?=$result['quiz_name']?></td>
                    <td><?=$result['mark']?></td>
                    <td><?=$result['percentage']?>&percnt;</td>
                    <td><?php
                        $phpdate = strtotime($result['datetime']);
                        $mysqldate = date( 'd M y', $phpdate );
                        $mysqltime = date( 'h:ia', $phpdate );
                        echo $mysqldate;
                        echo "<br>";
                        echo $mysqltime;
                    ?></td>
                    <td><?php
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
                            <input type = "submit" value="Review">
                    </form>
                    </td>
                </tr>
                    <?php
                }

                ?>

            </table>


                <?php
            }
        ?>


    </div>
</div>

<?php   include($path."/footer_tailwind.php");?>