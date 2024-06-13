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

$assignid = "";

$quizInfo = array();
$assignInfo = array();
if(isset($_GET['assignid'])) {
  $assignInfo = getAssignmentInfoById($_GET['assignid']);
  //print_r($assignInfo);
  $quizid = $assignInfo['quizid'];
  $quizInfo = getMCQquizInfo($quizid);
  $assignid = $_GET['assignid'];
}

if(isset($_GET['quizid'])) {
  $quizInfo = getMCQquizInfo($_GET['quizid']);
  $quizid = $quizInfo['id'];
}

if(isset($_GET['quizid']) || isset($_GET['assignid'])) {
  //The following array item is the original question order as listed in database.
  $quizInfo['question_order_original'] = $quizInfo['questions_id'];
}

$get_selectors = array(
  'id' => (isset($_GET['id'])&&$_GET['id']!="") ? $_GET['id'] : null,
  'topics' => (isset($_GET['topics'])&&$_GET['topics']!="") ? $_GET['topics'] : null,
  'number' => (isset($_GET['number'])&&$_GET['number']!="") ? $_GET['number'] : null,
  'examBoard' => (isset($_GET['examBoard'])&&$_GET['examBoard']!="") ? $_GET['examBoard'] : null
);




//Quiz Generation:

//The following will create a new random quiz when get variable 'topics' is defined. This will allow users to create a newly-minted random set of questions by a topic.

if(!is_null($get_selectors['topics'])) {

  $quizid = 0;
  $topics = $get_selectors['topics'];
  $topics = explode(",",$topics);
  //print_r($topics);
  foreach ($topics as $key=>$topic) {
    $topics[$key] = trim($topic);
  }
  //var_dump($topics);

  //Until getMCQquestionDetails2() can handle more than one topic, we will use $topics[0] and enter single topic

  $questions = getMCQquestionDetails2($get_selectors['id'], null, $topics[0], null, null, null, $get_selectors['examBoard']);

  $onlyRelevant = 1;
  $noSimilar = 1;

  foreach ($questions as $key=>$question) {
    if($onlyRelevant == 1) {
      if($question['relevant'] !='1') {
        unset($questions[$key]);
        //echo $key." ";
      }
    }
    if($noSimilar == 1) {
      if($question['similar'] !='') {
        unset($questions[$key]);
        //echo $key." ";
      }
    }
	  
     //Variable $excludedYear is set to prevent questions from coming from a particular year, e.g. for purposes of mock examination. Change when not required
     $excludedYear = 2023;
     $excludedYear = null;
     if($question['year'] == $excludedYear) {
        unset($questions[$key]);
        //echo $key." ";
      }
	  
  }

  $questions = array_values($questions);

  $number = 10;
  if(!is_null($get_selectors['number'])) {
    $number = $get_selectors['number'];
  }
  if ($number > count($questions)) {
    $number = count($questions);
  }

  $numbers = range(0,count($questions)-1);
  shuffle($numbers);
  
  $questionsFilter = array();
  $questionsFilterIds = array();
  for($x=0; $x<$number; $x++) {
    $questionsFilter[$x] = $questions[$numbers[$x]];
    array_push($questionsFilterIds, $questions[$numbers[$x]]['id']);
  }

  $questionsFilterIds = implode(",",$questionsFilterIds);

  $quizInfo = array(
    'quizName' => "Quiz Generator:".(!is_null($get_selectors['topics']) ? " Topic ".$get_selectors['topics'] : "").(!is_null($get_selectors['examBoard']) ? " Exam Board: ".$get_selectors['examBoard'] : "")." ".$number."/".count($questions),
    'questions_id'=> $questionsFilterIds,
    'question_order_original' => $questionsFilterIds

  );

  $quizid = 0;

}

//These are original variables brought down in code so that we can populate with random questions

$questions = explode(",",$quizInfo['questions_id']);
$questionsDetails = array();
$questionsOriginal = $questions;
$quesitonsCount = count($questions);


$randomQuestionOrder = 0;
//The following takes random Question Order parameter from $assignInfo:
if(isset($assignInfo['randomQuestions'])) {
  $randomQuestionOrder = $assignInfo['randomQuestions'];
}

//This allows override via GET variable:
if(isset($_GET['randomQuestions'])) {
  if($_GET['randomQuestions'] == 1) {
    $randomQuestionOrder = 1;
  }
  if($_GET['randomQuestions'] == 0) {
    $randomQuestionOrder = 0;
  }
}

function getOriginalOrder($questionid) {
  global $questionsOriginal;
  foreach ($questionsOriginal as $key=>$question) {
    if ($questionid == $question) {
      return $key;
    }
  }
}

if($randomQuestionOrder == 1) {
  shuffle($questions);
}

$randomOptionsOrder = 0;
//The following takes randomOptions parameter from $assignInfo:
if(isset($assignInfo['randomOptions'])) {
  $randomOptionsOrder = $assignInfo['randomOptions'];
}
//This allows override via GET variable:
if(isset($_GET['randomOptions'])) {
  if($_GET['randomOptions'] == 1) {
    $randomOptionsOrder = 1;
  }
  if($_GET['randomOptions'] == 0) {
    $randomOptionsOrder = 0;
  } 
}

//The following variable will toggle to show original question numbers (e.g. 5/10 as first question) when set to 1. Otherwise questions will come in random order but numbered sequentually e.g. 1/10 as first question
$originalQuestionNumbers = 0;




$style_input = ".hide {
  display: none;
  }
  input, button, textarea, th, td, select {
    border: 1px solid black;
  }
  td, th {
    padding: 5px;
  }

  
  ";

  if($_SERVER['REQUEST_METHOD']==='POST') {
    
    if($_POST['submit_info'] == "submittedForm2") {
      if(isset($_GET['test'])) {
        print_r($_POST);
      }
      $record = array();

      $submitTime = date("Y-m-d H:i:s");

      $questionsOriginal = explode(",",$_POST['question_order_original']);

      //print_r($questionsOriginal);


      foreach ($questionsOriginal as $key => $question) {
        $response = "";
        if(isset($_POST['a_'.$question])) {
          $response = $_POST['a_'.$question];
        }
        $record[$question] = $response;

        //The following will update mcq_responses_questions table:

        insertMCQquestionResponse($_POST['userid'], $question, $response, null, null, $submitTime, $_POST['quizid'], $_POST['assignid'], $key);


      }
    
    $responseId = insertMCQRecord($record, $_POST['userid'], $_POST['startTime'], $_POST['quizid'], $_POST['assignid'], $_POST['quizname']);

    echo "<script>window.location.replace('/user/user_mcq_review.php?responseId=".$responseId."')</script>";

    }
    
  }

include($path."/header_tailwind.php");

if(str_contains($permissions, "main_admin")) {
  ?>
  <!--

  GET Variables:
  -randomQuestions
  -randomOptions

  -->
  <?php
}

?>



<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">MCQ Exercise</h1>
    <div class="container mx-auto lg:p-4 mt-2 bg-white text-black mb-5">
      <?php
       
        //print_r($assignInfo);
        
        //print_r($permissions);
        //print_r($quizInfo);
        //echo "<br>";
        //print_r($_GET);
        //echo "<br>";
        //print_r($_POST);
        //print_r($get_selectors);
        //print_r($questions);
   
        
      ?>
    <div class="p-1 lg:p-0">
      <h1 class="font-mono text-xl bg-pink-300 pl-1 rounded mb-1"><?=$quizInfo['quizName']?></h1>
      <p class=" bg-pink-200 pl-1 rounded mb-1">Name: <?=$userInfo['name_first']?> <?=$userInfo['name_last']?></p>
      <?php
      if (str_contains($permissions, "teacher")) {
        ?>
        <form method="post" action = "/assign_create1.0.php" target="_blank">
          <input type="hidden" name = "exerciseid" value ="<?=$quizInfo['id']?>"></input>
          <input type="hidden" name = "type" value ="mcq"></input>
          <input type="hidden" name = "groupId" value =""></input>
          <p class="mt-2" ><input class="bg-sky-200 p-1" type="submit" value="Create Assignment With this Exercise"></p>
        </form>
        <?php
      }
      ?>
    </div>

	<form method  = "post" action ="" class="p-2">
    <div id="alertBox" class="fixed top-10 left-1 right-1 bottom-1 border-8 m-3 p-5 border-pink-400 rounded-xl bg-white z-10 hidden flex  justify-center ">
      <div class="lg:w-3/4">
        <div class="  bg-sky-200 p-2 text-center mx-auto">
          <p>You are about to submit your answers.</p>
          <p>This will record your score.</p>
        </div>
        <div id="alertIncompleteDiv" class="hidden mt-2  bg-pink-400 p-2 text-center">
          <p>You have incomplete questions!!!</p>
          <p>There <span id="isAreQuestionCount"></span> <span id="incompleteQuestionCount"></span> question<span id="questionCountPlural">s</span> you have not completed.</p>
          <p>Are you sure you want to submit?</p>
        </div>

          <button type="button" class="border-4 border-sky-300 rounded bg-sky-200 hover:bg-sky-300 w-full mt-2 h-12" onclick="goBack(this)">Go Back</button>

          <button type="button" class="border-4 border-pink-300 rounded bg-pink-200 hover:bg-pink-300 w-full mt-2 h-12" onclick="this.form.submit()">Submit Score</button>

          <input type="hidden" name="question_order_original" value="<?=$quizInfo['question_order_original']?>">
      </div>
  
    </div>
    <div class="hidden">
      <input type = "text" name ="startTime" value = "<?php echo date("Y-m-d H:i:s") ?>" >
      <input type = "text" name ="userid" value ="<?=$userId?>" style="display: ;" >
      <input type = "text" name="quizid" value = "<?=$quizid?>">
      <input type = "text" name="assignid" value = "<?=$assignid?>">
      <input type = "text" name="quizname" value = "<?=$quizInfo['quizName']?>">
      
      <input type ="hidden" name ="submit_info" value ="submittedForm2">
    </div>
		
		<?php
		//print_r($questions);
    if(count($questions)>0 && $questions[0]!= "") {
      foreach ($questions as $key=>$question) {
        
        $questionInfo = getMCQquestionDetails2($question)[0];
        print_r($questionInfo);
        $questionsDetails[$question] = $questionInfo;
        $imgSource = "https://thinkeconomics.co.uk";
        $rootImgSource = "https://www.thinkeconomics.co.uk";
        $imgPath = "";
        if($questionInfo['path'] == "") {
          $imgPath = $questionInfo['No'].".JPG";
        } else {
          $imgPath = $questionInfo['path'];
        }
        $img = $imgSource."/mcq/question_img/".$imgPath;

        $textOnly = 0;
        if($questionInfo['textOnly'] == 1) {
          $textOnly = 1;
        }
        $noRandom = 0; 
        if($questionInfo['noRandom'] == 1) {
          $noRandom = 1;
        }
        $optionsTable = 0;
        if($questionInfo['optionsTable'] == 1) {
          $optionsTable = 1;
        }

        $options = $questionInfo['options'];
        $options = json_decode($options, true);

        $questionNo = $key + 1;
        if($originalQuestionNumbers == 1) {
          $questionNo = getOriginalOrder($question) + 1;
        }
        ?>
        <div class=" font-sans" id="question_div_<?=$key?>">
          <h2>Question <?=$questionNo?>/<?=$quesitonsCount?></h2>
          <p class="text-xs hidden"><em id = "q4"><?=$questionInfo['No']?></em></p>

          <div class="flex flex-row gap-x-2 font-mono text-xs md:text-base mt-2">
            <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 previous" value ="Previous Question" id="previous1" onclick="changeQuestion(this);" <?=($key == 0) ? "disabled" : ""?>>
            <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 submit" value ="Submit" id="submit1" onclick="submit2();">
            <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 next" value ="Next Question" id="next1" onclick="changeQuestion(this);" <?=($key == ($quesitonsCount-1)) ? "disabled" : ""?>>
          </div>
          <div class=" mx-auto">
            <?php
            if($textOnly == 1) {
              ?>
              <div class=" my-3 mx-auto lg:w-3/4">
                <?php
                $question1 = explode("\n", $questionInfo['question']);
                  foreach($question1 as $p) {
                    ?>
                    <p class="mb-1"><?=$p?></p>
                    <?php
                  }
                  if($questionInfo['midImgAssetId'] != "") {
                    $midImgAssets = explode(",", $questionInfo['midImgAssetId']);
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
                  if($questionInfo['midTableArray'] != "") {
                    $midTableArray = json_decode($questionInfo['midTableArray']);
                    //print_r($midTableArray);
                    ?>
                    <h2 class=" font-bold text-center my-1 mb-2"><?=$questionInfo['midTableHeader']?></h2>
                    <table class="mx-auto my-2">
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
                  $question2 = explode("\n", $questionInfo['question2']);
                  foreach($question2 as $p) {
                    ?>
                    <p class="mb-1"><?=$p?></p>
                    <?php
                  }
                ?>
              </div>
              
              <?php
            } else {
            ?>
            <img src="<?=$img?>" class=" my-3 mx-auto max-h-screen" alt = "<?=$questionInfo['No']?>">
            <?php
            }
            ?>
            <div class="mx-auto <?=$textOnly == 1 ? "lg:w-3/4" : "w-11/12 " ?>">
              <?php

              if($randomOptionsOrder ==1 && $textOnly == 1 && $noRandom == 0) {
                $options = shuffle_assoc($options);
              }
              
              if($optionsTable == 1) {
                ?>
                <table class="mx-auto my-1">
                  <tr >
                    <?php
                      $headerRow = $questionInfo['optionsTableHeading'];
                      $headerRow = explode("     ",$headerRow);
                      foreach ($headerRow as $cell) {
                        ?>
                        <td class="px-4 text-center "><?=$cell?></td>
                        <?php
                      }
                    ?>
                  </tr>
                  <?php
                  }
                    foreach($options as $optKey=>$option) {
                      if($textOnly == 0) {
                        $option = $optKey;
                      }
                      if($optionsTable == 0) {                
                        ?>
                        <p class="mb-2 ml-5">
                          <input type="radio" class="-ml-5 mt-1.5 absolute" id="a_<?=$question?>_<?=$optKey?>" name="a_<?=$question?>" value="<?=$optKey?>" onclick="questionRecord(<?=$question?>)">
                        <label class=" " for="a_<?=$question?>_<?=$optKey?>"><?=$option?></label>
                        </p>
                        <?php
                      } else {
                        $optionRows = explode("     ",$option);
                        ?>
                        <tr>
                          <td class="px-4 text-center ">
                            <input type="radio" class="" id="a_<?=$question?>_<?=$optKey?>" name="a_<?=$question?>" value="<?=$optKey?>" onclick="questionRecord(<?=$question?>)">
                          </td>
                          <?php
                            foreach($optionRows as $cell) {
                              ?>
                              <td class="px-4 text-center ">
                                <label for="a_<?=$question?>_<?=$optKey?>">
                                  <?=$cell?>
                                </label>
                              </td>
                              <?php
                            }
                          ?>
                        </tr>
                        <?php
                      }
                    }
                    if($optionsTable == 1) {
                    ?>
                </table>
              <?php
              }
              ?>
            </div>
          </div>
          
          <div class="flex flex-row gap-x-2 font-mono text-xs md:text-base mt-2">
            <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 previous" value ="Previous Question" id="previous1" onclick="changeQuestion(this);" <?=($key == 0) ? "disabled" : ""?>>
            <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 submit" value ="Submit" id="submit1" onclick="submit2();">
            <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 next" value ="Next Question" id="next1" onclick="changeQuestion(this);" <?=($key == ($quesitonsCount-1)) ? "disabled" : ""?>>
          </div>

        </div>
        <?php
      }
    }
		?>

	</form>








</div>

</div>






<script>



var question_no = 0;
const count = <?=count($questions)?>;

function hideQuestions(qNumber) {
  for (var i = 0; i<count; i++) {
    var questionDiv = document.getElementById("question_div_"+i);
    //console.log(questionDiv);
    if(i != qNumber) {
      questionDiv.classList.add("hidden");
    }
    if(i == qNumber) {
      questionDiv.classList.remove('hidden');
    }
  }
}

hideQuestions(0);

function changeQuestion(button) {
  button = button.value;
  //console.log(button);
  if(button == "Next Question") {
    question_no ++;
    //console.log(question_no);
    hideQuestions(question_no);
  }
  if(button == "Previous Question") {
    question_no --;
    //console.log(question_no);
    hideQuestions(question_no);
  }

}

attemptedQuestions = [];

function submit2() {
  const alertBox = document.getElementById("alertBox");
  alertBox.classList.remove("hidden");

  const alertIncompleteDiv = document.getElementById("alertIncompleteDiv")

  //console.log(attemptedQuestions.length+" "+count);

  if(attemptedQuestions.length != count) {
    alertIncompleteDiv.classList.remove("hidden");
    const difference = count - attemptedQuestions.length;
    const incompleteQuestionCount = document.getElementById("incompleteQuestionCount");
    incompleteQuestionCount.innerHTML = difference;
    //console.log(difference);
    const isAreQuestionCount = document.getElementById("isAreQuestionCount");
    //console.log(isAreQuestionCount);
    const questionCountPlural = document.getElementById("questionCountPlural");
    if(difference > 1) {
      isAreQuestionCount.innerHTML = "are";
      questionCountPlural.innerHTML = "s";
    } else {
      isAreQuestionCount.innerHTML = "is";
      questionCountPlural.innerHTML = "";
    }


  } else {
    alertIncompleteDiv.classList.add("hidden");
  }
  
}

function goBack() {
  const alertBox = document.getElementById("alertBox");
  alertBox.classList.add("hidden");
 
}



function questionRecord(questionid) {
  //console.log(questionid);
  if(attemptedQuestions.includes(questionid) == false) {
    attemptedQuestions.push(questionid)
  }
  //console.log(attemptedQuestions);
  //console.log(count);
}











</script>

<?php   include($path."/footer_tailwind.php");?>


