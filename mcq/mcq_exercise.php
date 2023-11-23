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

$quizInfo = array();
$assignInfo = array();
if(isset($_GET['assignid'])) {
  $assignInfo = getAssignmentInfoById($_GET['assignid']);
  //print_r($assignInfo);
  $quizid = $assignInfo['quizid'];
  $quizInfo = getMCQquizInfo($quizid);
}

if(isset($_GET['quizid'])) {
  $quizInfo = getMCQquizInfo($_GET['quizid']);
  $quizid = $quizInfo['id'];
}

$questions = explode(",",$quizInfo['questions_id']);
$quesitonsCount = count($questions);

$randomQuestions = 0;
$randomQuestions = 1;


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
    if($_POST['submit_info'] == "submittedForm") {

      $record = json_decode($_POST['record']);
      $name = $_POST['name'];
      $quizname = $_POST['quizname'];


      $answers = array();
      $score = 0;
      $timeStart = $_POST['startTime'];
      $timeEnd = date("Y-m-d H:i:s");

      $assignid = $_POST['assignid'];
      $userid = $_POST['userid'];
      $review = $_POST['reviewQ'];
      $multi = $_POST['multi'];

      $arrlength = count($record);


      for($x = 0; $x < $arrlength; $x++) {
        
        $response = array();

        array_push($response, $record[$x][0]);
        array_push($response, $record[$x][1]);
        
        /*!!! Below is the question bank that must be updated to included most recent questions*/
        
        $sql = "SELECT * FROM question_bank_3 WHERE No= ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $record[$x][0]);
        $stmt->execute();
        $result = $stmt->get_result();
      
        if($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            array_push($response, $row['Answer']);
          }
        }
        if ($response[1]==$response[2]) {              
          array_push($response, true);
          $score = $score +1;
          }
          else {         
          array_push($response, false);  
          }
        array_push($answers, $response);
      }

      $percentage = round(($score/$arrlength)*100, 2);
      $record2 = json_encode($answers);

      /*!!!The below command determines where the results are sent to*/

      $sql = "INSERT INTO `responses` (`answers`, `mark`, `percentage`, `quiz_name`, `timeStart`, `datetime`, `assignID`, `userID`, `quizId`) VALUES (?,?,?,?,?,?,?,?,?)";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssssiii", $record2, $score, $percentage, $quizname, $timeStart, $timeEnd, $assignid, $userid, $quizid);
      //$stmt->execute();

      // This element is added to ensure that  the same completed assignment is not submitted twice

      $sql2 = "SELECT * FROM responses WHERE userID= ? AND timeStart= ?";

      $stmt2 = $conn->prepare($sql2);
      $stmt2->bind_param("is", $userid, $timeStart);
      $stmt2->execute();
      $result2 = $stmt2->get_result();

      if($result2->num_rows == 0) {
        $stmt->execute();
      }

      echo "Record entered successfully";

      $responseId= getMCQresponseByUsernameTimestart($userid, $timeStart);
   

      echo "<script>window.location.replace('/user/user_mcq_review.php?responseId=".$responseId."')</script>";


     
      

    }
    
  }

include($path."/header_tailwind.php");

?>



<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 lg:w-3/4">
    <h1 class="font-mono text-2xl bg-pink-400 pl-1">MCQ Exercise</h1>
    <div class="font-mono container mx-auto px-0 mt-2 bg-white text-black mb-5">
      <?php
      
        print_r($quizInfo);
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

	<form method  = "post" action ="" class="border border-black p-1">
		<input type = "text" name ="startTime" value = "<?php echo date("Y-m-d H:i:s") ?>" >
		<input type = "text" name ="userid" value ="<?=$userId?>" style="display: ;" >
		
		<?php
		//print_r($questions);
		foreach ($questions as $key=>$question) {
			$questionInfo = getMCQquestionDetails($question);
			//print_r($questionInfo);
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

      $navButtons = '
      <div class="flex flex-row">
        <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 previous" value ="Previous Question" id="previous2" onclick="changeQuestion(this);">
        <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 submit" value ="Submit" id="submit2">
        <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 next" value ="Next Question" id="next2">
      </div>
      
      
      ';
			?>
			<div class="border border-black p-2 font-sans" id="question_div_<?=$key?>">
				<h2>Question <?=$key + 1?>/<?=$quesitonsCount?></h2>
				<p class="text-xs"><em id = "q4"><?=$questionInfo['No']?></em></p>
        <? //echo $navButtons;?>
        <div class="flex flex-row">
          <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 previous" value ="Previous Question" id="previous2" onclick="changeQuestion(this);" <?=($key == 0) ? "disabled" : ""?>>
          <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 submit" value ="Submit" id="submit2">
          <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1 next" value ="Next Question" id="next2" onclick="changeQuestion(this);" <?=($key == ($quesitonsCount-1)) ? "disabled" : ""?>>
        </div>
				<?php
				if($textOnly == 1) {
					?>
					<p class="my-2"><?=$questionInfo['question']?></p>
					<?php
				} else {
				?>
				<img src="<?=$img?>" class="lg:w-3/4 mx-auto mt-3" alt = "<?=$questionInfo['No']?>">
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
						<p class="mb-2">
							<input type="radio" id="a_<?=$question?>_<?=$optKey?>" name="a_<?=$question?>" value="<?=$optKey?>">
						<label class=" " for="a_<?=$question?>_<?=$optKey?>"><?=$option?></label>
						</p>
						<?php
					}
					?>
				</div>
        <?php //echo $navButtons;?>

			</div>
			<?php
		}
		?>

	</form>


    <form id="myForm" method="post" action="" style="display:none  ;">
    <p>Name: <input type = "text" name ="name" id = "name" style="" value="<?=$userInfo['name_first']?> <?=$userInfo['name_last']?>"> </p>
    <input type = "text" name ="record" id = "f1" style="display:;" >
    <input type = "text" name ="quizname" id = "f2" style="display: ;" value = "<?=$quizInfo['quizName']?>">
    <input type = "text" name ="startTime" value = "<?php echo date("Y-m-d H:i:s") ?>" style="display:;">
    <input type = "text" name ="assignid" value ="<?= (isset($_GET['assignid'])) ? $_GET['assignid'] : ""?>" style="display: ;" >
    <input type = "text" name ="userid" value ="<?=$userId?>" style="display: ;" >

    <input type = "text" name ="reviewQ" id = "reviewInput" style="display: ;" >
    <input type = "text" name ="multi" id = "multiInput" style="display: ;" >
    <input type ="text" name ="submit_info" value ="submittedForm">

    </form>

<button onclick="submit()" style="display:none">Click to submit</button>
<button onclick="view()" style ="display:none;">Click to see console</button>


<div class="p-2">
<h2>Question <span id="q1"></span>/<span id="q2"></span></h2>
<p class="text-xs"><em id = "q4"></em></p>
<div class="flex flex-row">
  <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1" value ="Previous Question" id="previous2">
  <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1" value ="Submit" id="submit2">
  <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1" value ="Next Question" id="next2">
</div>

<img src="" class="lg:w-3/4 mx-auto mt-3" alt="Question" id ="question" >

	<div id= "d1" class="">

	</div>

<br>
<div class="flex flex-row">
  <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1" value ="Previous Question" id="previous">
  <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1" value ="Submit" id="submit">
  <input type="button" class="flex-1 px-1 text-sm bg-sky-100 hover:bg-pink-300 disabled:opacity-75 p-1" value ="Next Question" id="next">
</div>

</div>

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


var quizName = "<?=$quizInfo['quizName']?>";
var index = [<?=$quizInfo['questions']?>];

var record = []
var record2 = []



var question_no = 0;
/*
var next_id = document.getElementById("next");
next_id.onclick=function() {next_q()};
var submit_id = document.getElementById("submit");
submit_id.onclick=function() {submit()};
var previous_id = document.getElementById("previous");
previous_id.onclick=function() {previous_q()};
var next_id2 = document.getElementById("next2");
next_id2.onclick=function() {next_q()};
var submit_id2 = document.getElementById("submit2");
submit_id2.onclick=function() {submit()};
var previous_id2 = document.getElementById("previous2");
previous_id2.onclick=function() {previous_q()};

*/

function populate() {
	

	for(var i=0; i<index.length; i++) {
		var record3 = [];	
		record3[0] = (index[i]).toFixed(6);
		record3[1] = "";
		record2.push(record3);
	
    }

  var div = document.getElementById("d1");

	load_q();
	
document.getElementById("q2").innerHTML= index.length;
//document.getElementById("q3").innerHTML= index.length;

previous_id.disabled = true;
previous_id2.disabled = true;
	
}

populate();

function next_q() {
	if (question_no < index.length-1) {
	
		record_mark();
		question_no ++;
		
		load_q();
		console.log(record2);
	}
	
	if (question_no == index.length-1) {
	
		next_id.disabled = true;
		next_id2.disabled = true;
	}
	
	if (question_no != 0) {
	
		previous_id.disabled = false;
		previous_id2.disabled = false;
	}
}

function previous_q() {

	if (question_no > 0) {
		record_mark();
		question_no --;
		load_q();

		console.log(record2);
	}
	
	
	if (question_no == 0) {
	
		previous_id.disabled = true;
		previous_id2.disabled = true;
	}
	
	if (question_no != index.length-1) {
	
		next_id.disabled = false;
		next_id2.disabled = false;
	}
	
	
}

function load_q() {
	
	document.getElementById("q1").innerHTML=question_no+1;
	document.getElementById("q4").innerHTML=(index[question_no]).toFixed(6);
	
	/*
	var i;
	for (i=0; i<ans.length; i++) {
	ans[i].checked=false;
	}
	
	
	if (record[question_no][2] != "" || record[question_no][2] == "0") {
		ans[record[question_no][2]].checked =true;
	}
	*/
	var question = document.getElementById("question");
	
	var bigjpg = (index[question_no]).toFixed(6)+".JPG";
	var smljpg = (index[question_no]).toFixed(6)+".jpg";
	
	if (typeof bigjpg != "undefined") {
		
		question.setAttribute("src", "question_img/"+bigjpg);
		
	}else if (typeof smljpg != "undefined") {
		
		question.setAttribute("src", "question_img/"+smljpg);
	}
	
	/*
	question.setAttribute("src", "question_img/"+(index[question_no][0]).toFixed(6)+".jpg");
	
	*/
	var div = document.getElementById("d1");
	div.innerHTML ="";
	//var button = [[],[],[],[],[]];
	//var label = [[],[],[],[],[]]
	var abcde = ["A", "B", "C", "D", "E"];
	
	/*
	!!! This is where you can update the number of MCQ options that are given to the user. Use examBoardOptions array.
	*/
	
	var optionsNumber;
	var examBoardOptions = [["10",5],["11", 5],["12",4], ["13",5], ["14",4] ]
	
	for (var i=0; i<examBoardOptions.length; i++) {
		
		if ((index[question_no]).toString().substring(0,2) == examBoardOptions[i][0] ) {
			
			optionsNumber = examBoardOptions[i][1]
			
		}
		
		
	}
	console.log((index[question_no]).toString().substring(0,2));
	
	for(var j=0; j<optionsNumber; j++) {
		var button = document.createElement("input");
		button.setAttribute("type", "radio");
		button.setAttribute("id", "a_"+question_no+"_"+j);
		button.setAttribute("name", "a_"+question_no);
		button.setAttribute("class", "button");
		var label = document.createElement("label");
		label.setAttribute("for", "a_"+question_no+"_"+j)
		label.innerHTML = abcde[j];
		
		if(record2[question_no][1]==abcde[j]) {
			button.checked = true;
		}
		
		div.appendChild(button);
		div.appendChild(label);

		var br = document.createElement("br");
		div.appendChild(br);
	}
		/*
		button[j] = document.createElement("input");
		button[j].setAttribute("type", "radio");
		button[j].setAttribute("id", "a_"+question_no+"_"+j);
		button[j].setAttribute("class", "button");
		button[j].setAttribute("name", "a_"+question_no);
		label[j] = document.createElement("label");
		label[j].innerHTML = abcde[j];
		div.appendChild(label[j]);
		div.appendChild(button[j]);
		div.appendChild("<br")}
		*/
	console.log(question_no);
	

}

function record_mark() {

	var abcde = ["A", "B", "C", "D", "E"]
	var answer ="";
	var answer_code="";
	var checked = false;
	
	//record2[question_no][0]=index[question_no][0];
	
	var buttons = document.getElementsByClassName("button");
	for (var i=0; i<buttons.length; i++) {
	
	//var i;
	//	for (i=0; i<ans.length; i++) {
		if (buttons[i].checked == true) {
			answer = abcde[i];
			answer_code = i;
		};
				
}
		
	record2[question_no][1]= answer;
	//record[question_no][2]= answer_code;
	

	


}

function submit() {
	
	record_mark();

	record = [];
	
	name = document.getElementById("name").value;
	console.log(name);

if (name == "") {alert("Please enter your name")}

else {
	
	
	var r = confirm("You are about to submit your answers. This will record your score.");
			if (r == true)
			
			{
	

				/*for(var i=0; i<index.length; i++) {
					var a = document.getElementById("a_"+i+"_0");
					var b = document.getElementById("a_"+i+"_1");
					var c = document.getElementById("a_"+i+"_2");
					var d = document.getElementById("a_"+i+"_3");
					var e = document.getElementById("a_"+i+"_4");
					
					var questionRecord = [];
					questionRecord[0] = (index[i]).toFixed(6);
					
					if (a.checked == true) {
						questionRecord[1] = "A"
						}
					else if (b.checked == true) {
						questionRecord[1] = "B"
						}
						
					else if (c.checked == true) {
						questionRecord[1] = "C"
						}
					else if (d.checked == true) {
						questionRecord[1] = "D"
						}
					else if (e.checked == true) {
						questionRecord[1] = "E"
						}
					else {
					questionRecord[1] = ""
						}
					
					record.push(questionRecord);
				}
				*/
				record = JSON.stringify(record2);
				console.log(record);
				document.getElementById("f1").value = record;
				//document.getElementById("f2").value = quizName;
				document.getElementById("myForm").submit();
			}
	}
}

function view() {
	
	record = [];

	for(var i=0; i<index.length; i++) {
		var a = document.getElementById("a_"+i+"_0");
		var b = document.getElementById("a_"+i+"_1");
		var c = document.getElementById("a_"+i+"_2");
		var d = document.getElementById("a_"+i+"_3");
		
		var questionRecord = [];
		questionRecord[0] = (index[i]).toFixed(6);
		
		if (a.checked == true) {
			questionRecord[1] = "A"
			}
		else if (b.checked == true) {
			questionRecord[1] = "B"
			}
			
		else if (c.checked == true) {
			questionRecord[1] = "C"
			}
		else if (d.checked == true) {
			questionRecord[1] = "D"
			}
		else {
		questionRecord[1] = ""
			}
		
		record.push(questionRecord);
	}
	
	record = JSON.stringify(record);
	console.log(record);
	document.getElementById("f1").value = record;
	document.getElementById("f2").value = quizName;
	
}

</script>

<?php   include($path."/footer_tailwind.php");?>


