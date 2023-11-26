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

$randomQuestionOrder = 0;
$randomQuestionOrder = 1;

$questions = explode(",",$quizInfo['questions_id']);
$questionsDetails = array();
$questionsOriginal = $questions;
$quesitonsCount = count($questions);

function getOriginalOrder($questionid) {
  global $questionsOriginal;
  foreach ($questionsOriginal as $key=>$question) {
    if ($questionid == $question) {
      return $key;
    }
  }
}

if($randomQuestionOrder == 1) {
  $qustions = shuffle($questions);
}

$randomQuestions = 0;
$randomQuestions = 1;

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
      //print_r($_POST);
      $record = array();
      foreach ($questionsOriginal as $question) {
        $response = "";
        if(isset($_POST['a_'.$question])) {
          $response = $_POST['a_'.$question];
        }
        $record[$question] = $response;
      }
    
    $responseId = insertMCQRecord($record, $_POST['userid'], $_POST['startTime'], $_POST['quizid'], $_POST['assignid']);

    echo "<script>window.location.replace('/user/user_mcq_review.php?responseId=".$responseId."')</script>";

    }
    
  }

include($path."/header_tailwind.php");

?>



<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">MCQ Exercise</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <?php
      
        //print_r($quizInfo);
        //echo "<br>";
        //print_r($_GET);
        //echo "<br>";
        //print_r($_POST);
        
      ?>
    <h1 class="font-mono text-xl bg-pink-300 pl-1"><?=$quizInfo['quizName']?></h1>
    <p class="font-mono text-lg bg-pink-200 pl-1">Name: <?=$userInfo['name_first']?> <?=$userInfo['name_last']?></p>
    <?php
    if (str_contains($permissions, "teacher")) {
      ?>
      <form method="post" action = "/assign_create1.0.php" target="_blank">
        <input type="hidden" name = "exerciseid" value ="<?=$quizInfo['id']?>"></input>
        <input type="hidden" name = "type" value ="mcq"></input>
        <input type="hidden" name = "groupId" value =""></input>
        <p class="mt-2" >Teacher: <input class="bg-pink-200 p-1" type="submit" value="Create Assignment With this Exercise"></p>
      </form>
      <?php
    }


    ?>

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
      </div>
  
    </div>
    <div class="hidden">
      <input type = "text" name ="startTime" value = "<?php echo date("Y-m-d H:i:s") ?>" >
      <input type = "text" name ="userid" value ="<?=$userId?>" style="display: ;" >
      <input type = "text" name="quizid" value = "<?=$quizid?>">
      <input type = "text" name="assignid" value = "<?=$assignid?>">
      
      <input type ="hidden" name ="submit_info" value ="submittedForm2">
    </div>
		
		<?php
		//print_r($questions);
		foreach ($questions as $key=>$question) {
      
			$questionInfo = getMCQquestionDetails($question);
			//print_r($questionInfo);
      $questionsDetails[$question] = $questionInfo;
			$imgSource = "https://thinkeconomics.co.uk";
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

			$options = $questionInfo['options'];
			$options = json_decode($options, true);

      $questionNo = $key + 1;
      if($originalQuestionNumbers == 1) {
        $questionNo = getOriginalOrder($question) + 1;
      }
			?>
			<div class=" font-sans" id="question_div_<?=$key?>">
				<h2>Question <?=$questionNo?>/<?=$quesitonsCount?></h2>
				<p class="text-xs"><em id = "q4"><?=$questionInfo['No']?></em></p>

        <div class="flex flex-row gap-x-2 font-mono text-xs md:text-base mt-2">
          <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 previous" value ="Previous Question" id="previous1" onclick="changeQuestion(this);" <?=($key == 0) ? "disabled" : ""?>>
          <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 submit" value ="Submit" id="submit1" onclick="submit2();">
          <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 next" value ="Next Question" id="next1" onclick="changeQuestion(this);" <?=($key == ($quesitonsCount-1)) ? "disabled" : ""?>>
        </div>

				<?php
				if($textOnly == 1) {
					?>
					<p class="my-2"><?=$questionInfo['question']?></p>
					<?php
				} else {
				?>
				<img src="<?=$img?>" class="lg:w-3/4 mx-auto my-3" alt = "<?=$questionInfo['No']?>">
				<?php
				}
				?>
				<div class="ml-3">
					<?php

          if($randomQuestions ==1 && $textOnly == 1) {
            $options = shuffle_assoc($options);

          }
					foreach($options as $optKey=>$option) {
						if($textOnly == 0) {
							$option = $optKey;
						}
						?>
						<p class="mb-2 ml-5">
							<input type="radio" class="-ml-5 mt-1.5 absolute" id="a_<?=$question?>_<?=$optKey?>" name="a_<?=$question?>" value="<?=$optKey?>" onclick="questionRecord(<?=$question?>)">
						<label class=" " for="a_<?=$question?>_<?=$optKey?>"><?=$option?></label>
						</p>
						<?php
					}
					?>
				</div>
        
        <div class="flex flex-row gap-x-2 font-mono text-xs md:text-base mt-2">
          <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 previous" value ="Previous Question" id="previous1" onclick="changeQuestion(this);" <?=($key == 0) ? "disabled" : ""?>>
          <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 submit" value ="Submit" id="submit1" onclick="submit2();">
          <input type="button" class="flex-1 px-1  bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 next" value ="Next Question" id="next1" onclick="changeQuestion(this);" <?=($key == ($quesitonsCount-1)) ? "disabled" : ""?>>
        </div>

			</div>
			<?php
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


