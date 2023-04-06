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
  $permissions = $userInfo['permissions'];
  if (!(str_contains($permissions, 'teacher'))) {
    header("location: /index.php");
  }

  $groups = getGroupsList($userId);

}

$style_input = "

td, th {
	
	border: 1px solid black;
	padding: 3px;
}

table {
	
	border-collapse: collapse;
}



.incorrect {
	
	background-color: yellow;
}

td a {
    color: inherit;
    cursor: pointer;
    text-decoration: ;
}
      
";


$questionSummary =array();
$results = array();

if(isset($_GET['assignid'])&&$_GET['assignid']!="") {
  $assignmentInfo = getAssignmentInfoById($_GET['assignid']);

  //print_r($assignmentInfo);
  //echo "<br>";
  $quizInfo = getMCQquizInfo($assignmentInfo['quizid']);
  //print_r($quizInfo);
  ////echo "<br>";

  $questions = explode(",",$quizInfo['questions']);
  //print_r($questions);
  //echo "<br>";
  //sort($questions);

  $excluded = array();
  if(isset($_GET['excluded'])) {
    $excluded = explode(",",$_GET['excluded']);
  }
  //print_r($excluded);

  $results = getMCQquizResultsByAssignment($_GET['assignid']);
  foreach ($results as $key => $result) {
    //echo "<pre>";
    //print_r($result);
    //echo "</pre>";
    //echo "<br>";

    if(isset($_GET['filter'])) {
      if($_GET['filter'] == "last") {
        if($result['datetime'] != $result['maxdatetime']) {
          unset($results[$key]);
        }
      }
      if($_GET['filter'] == "first") {
        if($result['datetime'] != $result['mindatetime']) {
          unset($results[$key]);
        }
      }
    }
    if(in_array($result['id'], $excluded)) {
      unset($results[$key]);
    }
  }
  //print_r($results[0]);
  //print_r($results);

  //echo "<br>";
  
  foreach ($questions as $key=>$question) {
    $questionSummaryInstance = array('question' => $question, 'correctCount'=>0, 'summary'=>array(), 'correct'=>"", 'question_no' => ($key + 1));
    foreach($results as $result) {
      for ($x=0; $x<count($result['answers']); $x++) {
        if($result['answers'][$x][0]==$question) {
          $questionSummaryInstance['correctCount'] += $result['answers'][$x][3];
          $answerValue = $result['answers'][$x][1];
          if(!array_key_exists($answerValue, $questionSummaryInstance['summary'])) {
            $questionSummaryInstance['summary'][$answerValue] = 1;
          } else {
            $questionSummaryInstance['summary'][$answerValue]++;
          }
          $questionSummaryInstance['correct']=$result['answers'][$x][2];
        }
      }
    }
    ksort($questionSummaryInstance['summary']);
    
    //$questionSummary[$question] = $questionSummaryInstance;
    array_push($questionSummary, $questionSummaryInstance);
  }


  //To sort by number correct
  function cmp_by_correctCount($a, $b) {
    {
      if ($a['correctCount']==$b['correctCount']) return 0;
      return ($a['correctCount']<$b['correctCount'])?-1:1;
      }
  }
  
  if(isset($_GET['questionOrder'])&&$_GET['questionOrder']=="incorrect") {
    usort($questionSummary, "cmp_by_correctCount");
  }
  //print_r($questionSummary);
}


include ($path."/header_tailwind.php");
?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 w-full">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Multiple Choice Questions Assignment Review</h1>
  <div class="container mx-auto p-4 mt-2 bg-white text-black ">
  
  <form method="get" id="controlForm">
    <div class="w-full">
      <label class="py-1" for ="classid">Class:</label>
      <div class="mt-1.5">
        <select class="border px-3 py-2  text-sm w-full mb-2 rounded" name="classid" onchange="clearAssignmentsOnClassChange(this)">
          <option></option>
          <?php
          foreach($groups as $row) {
            ?>
            <option value="<?=$row['id']?>" <?=(isset($_GET['classid'])&&$row['id']==$_GET['classid']) ? "selected" : ""?>><?=htmlspecialchars($row['name'])?></option>
            <?php
          }
          ?>
        </select>
      </div> 
    </div>
    
    <?php

    if(isset($_GET['classid'])) {

      //$assignments = getAssignmentsList($userId, $_GET['classid'], "mcq");
      $assignments = getAssignmentsByGroup($_GET['classid'], 1000, "mcq");
      ?>
      <div class="w-full">
        <label class="py-1" for ="assignid">Assignment Name:</label>
        <div class="mt-1.5">
          <select id="assignid" class="border px-3 py-2  text-sm w-full mb-2 rounded" name="assignid" onchange="this.form.submit()">
            <option></option>
            <?php
              foreach($assignments as $assignment) {
                ?>
                <option value = "<?=$assignment['id']?>" <?=(isset($_GET['assignid'])&&$assignment['id']==$_GET['assignid']) ? "selected" : ""?>><?=htmlspecialchars($assignment['assignName'])?> (<?=date("d.m.y", strtotime($assignment['dateDue']))?>)</option>

                <?php
              }

            ?>
          </select>
        </div>
      </div>
      <?php 
    }
  ?>

<?php


//If you have any responses in your question summary:

if (count($results)>0) {

  //Create input controls
  ?>


  <div>
    <h3 class="mt-1.5 bg-pink-200">Results Type:</h3>
    <p>
      <input type="radio" id="filter_all" name="filter" value="all" <?=((isset($_GET['filter']))&&$_GET['filter']=="all")||!isset($_GET['filter']) ? "checked" : ""?>>
      <label for="filter_all">All Results</label>
    </p>
    <p>
      <input type="radio" id="filter_last" name="filter" value="last" <?=(isset($_GET['filter'])&&$_GET['filter']=="last") ? "checked" : ""?>>
      <label for="filter_last">Last Response</label>
    </p>
    <p>
      <input type="radio" id="filter_first" name="filter" value="first" <?=(isset($_GET['filter'])&&$_GET['filter']=="first") ? "checked" : ""?>>
      <label for="filter_first">First Response</label>
    </p>
  </div>


  <div>
    <h3 class="mt-1.5 bg-pink-200">Order Questions By:</h3>
    </p>
      <input type="radio" id="question_order_original" name="questionOrder" value="" <?=(!isset($_GET['questionOrder'])||$_GET['questionOrder']=="") ? "checked" : ""?>>
      <label for="question_order_original">Original (Same as assignment)</label>
    </p>
    <p>
    <input type="radio" id="question_order_incorrect" name="questionOrder" value="incorrect" <?=(isset($_GET['questionOrder'])&&$_GET['questionOrder']=="incorrect") ? "checked" : ""?>>
    <label for="question_order_incorrect">Incorrect (Show most difficult questions first)</label>
    </p>
    
  </div>

  <div>
    <input type="hidden" id="excludeInput" name="excluded" value="<?=(isset($_GET['excluded'])) ? $_GET['excluded'] : ""?>">
  </div>


  <input class="border border-black p-3 bg-pink-300 my-2 rounded w-full" type="submit" value ="Submit" onclick="clearExcludedInput();">
  </form>

  





<div class="flex flex-wrap justify-center">
  <div class="basis-1/3">
    <button class = "w-full border border-black p-3 bg-sky-100 my-2 rounded" onclick="toggleHide(this, 'student_complete_summary', 'Show Class Summary', 'Hide Class Summary', 'grid')" id="summary_toggle_button">Show Class Summary</button>
  </div>
  <div class="basis-1/3 px-2">
    <button class = "w-full border border-black p-3 bg-sky-100 my-2 rounded" onclick="nameToggle()" id="toggleButton">Hide Names</button>
  </div>    
  <div class="basis-1/3">
    <button class = "w-full border border-black p-3 bg-sky-100 my-2 rounded m" onclick="toggleHide(this, 'questions_summary', 'Hide Question Summaries', 'Show Question Summaries')" id="question_summary_toggle_button">Hide Question Summaries</button>
</div>

</div>

<div class="student_complete_summary grid grid-cols-2 space-x-2 mb-2" style="display:none">
  <?php
  $students_completed = array();
  $students = getGroupUsers($_GET['classid']);
  foreach ($students as $key=>$student) {
    foreach($results as $result) {
      if($result['userID'] == $student['id']) {
        array_push($students_completed, $student);
        unset($students[$key]);
        break;
      }
    }
  }
  ?>
  <div class="border rounded p-1">
    <h3 class="font-semibold underline">Completed Work By:</h3>
    <?php
    foreach ($students_completed as $student) {
      ?>
      <p><?=$student['name_first']." ".$student['name_last']?>
      <?php
    }
    ?>
  </div>  
  <div class="border rounded  p-1">
    <h3 class="font-semibold underline">Awaiting Work From:</h3>
    <?php
    foreach ($students as $student) {
      ?>
      <p><?=$student['name_first']." ".$student['name_last']?>
      <?php
    }
    ?>
  </div>  
</div>


<table id ="questionTable" class= "w-full table-fixed">
  <tr id ="questionTableRow" style='min-height= 72'>
    <th class="nameColumn hideClass">Student Name</th>
    <th class="hideClass">Time</th>
    <th class="percentColumn hideClass">&percnt;</th>
    <th class="hideClass">Exclude</th>
    <?php
    
    //Populate columns based on the questions from the assignment:

    foreach ($questionSummary as $key => $question) {
      ?>
      <th><?=$question['question_no']?>
      <br>
        <span class="hidden <?=(count($questionSummary)>7) ? "text-sm ":"" ?><?=(count($questionSummary)<11) ? "xl:inline":"" ?>"><?=$question['question']?></span>
      </th>
      <?php
    }
    ?>
  </tr>
  <?php

    //Populate rows for the number of results in $results:

    foreach($results as $result) {
      ?>
    <tr>
      <td class="hideClass text-lg" align="center"><p><?=htmlspecialchars($result['name_first'])?> <?=htmlspecialchars($result['name_last'])?></p>
      <?php
        /*
        //Extra info on maxdatetime and mindatetime
        echo $result['datetime'];
        echo $result['maxdatetime'];
        echo "<br>";
        echo $result['mindatetime'];
        */
      ?>

      </td>
      <td class="hideClass" align="center">
        <p><?=date("d/m/y", strtotime($result['datetime']))?></p>
        <p><?=date("H:i:s", strtotime($result['datetime']))?></p>
        <p><?=$result['duration']?> min</p>
      </td>
      <td class="hideClass" align="center"><?=$result['percentage']?></td>
      <td class="hideClass" align="center">
        <button class="rounded bg-sky-100 p-1 border border-black" onclick="updateExcludedInput(<?=$result['id']?>);">Exclude Result</button>
      </td>
        <?php
        foreach ($questionSummary as $question) {
          $questionResponse = getMCQindividualQuestionResponse($question['question'], $result['answers']);
          ?>
      <td align="center" class = "text-lg <?=($questionResponse['correct'] == "") ? "bg-pink-200" : ""?>">
        <p class=""><?=$questionResponse['answer']?></p>
        <!--
        <p><?=$questionResponse['correct_answer']?></p>
        <p><?=$questionResponse['correct']?></p>
        -->
      </td>
          <?php
        }  
        ?>
    </tr>
      <?php
    }
  
  ?>
  <tr id="questionTableLastRow">
    <td colspan=4 class="hideClass">Totals:</td>
    <?php
    foreach ($questionSummary as $key=>$question) {
      echo "<td align='center'>";
      echo $question['correctCount']."/".count($results);
      echo "</td>";
    }

    ?>
  </tr>

</table>


<div>
  <form method = "get" target ="_blank" action = "mcq_assignment_review_images.php">
    <input type="hidden" name="questions" value = "<?php
      foreach ($questionSummary as $question) {
        echo trim($question['question']).",";
      }
    ?>">
    <input class ="border border-black rounded p-1 mt-2 bg-sky-100"type = "submit" value ="Images only">
  </form>
</div>

<?php
}

?>




<div id ="summary_div">
  <?php
  foreach ($questionSummary as $key=>$question) {
    $questionName = trim($question['question']);
    ?>
    <h2 class="text-lg bg-pink-100 mt-2 border-t-2 border-black">Question <?=$question['question_no']?></h2>
    <p><em><?=$questionName?></em></p>
    <img  src="question_img/<?=$questionName?>.JPG" alt="question <?=$questionName?>">
    <p>Number Correct: <?=$question['correctCount']."/".count($results)?></p>
    <p class="questions_summary">Summary: <?php
      $count = 0;
      foreach($question['summary'] as $key=>$response) {
        if($key == "") {
          unset($question['summary'][$key]);
        } else {
          $correct = "";
          if($key == $question['correct']) {
            $correct = " class = 'bg-pink-100' ";
          }
          echo "<span ".$correct.">".$key.": ".$response."</span>";
          $count ++;
          if($count < (count($question['summary']))) {
            echo ", ";
          }
        }
      }
      //echo "<br>";
      //echo count($question['summary']);
    ?></p>
    <div>
      <?php
      /*
      The following loads information for students who got the correct answer; however it takes too long to load.
      $correctStudents = array();
      print_r($question);
      $correctAnswer = $question['correct'];
      echo $correctAnswer;
      echo "<pre>";
      //print_r($results);
      echo "</pre>";
      foreach($results as $result) {
        foreach($result['answers'] as $questionResponse) {
          if ($questionResponse[0] == $question['question']) {
            if ($questionResponse[1] == $question['correct']) {
              array_push($correctStudents, $result['userID']);
            }
          }
        }
      }
      foreach ($correctStudents as &$student) {
        $student = getUserInfo($student)['name_first']." ".getUserInfo($student)['name_last'];
      }
      print_r($correctStudents);
      echo count($correctStudents);
      */
      ?>
    </div>
    <?php
      $questionDetails = getMCQquestionDetails(null, $questionName);
      $explanations = json_decode($questionDetails['explanation']);
      $explanations = (array) $explanations;
      //print_r($explanations);
      if(count($explanations) > 0) {
        $originalMessage = "Click for Explanation".(count($explanations)>1 ? "s" : "");
        ?>
        <button class="border border-black rounded bg-pink-100 p-1 mt-2" onclick = "toggleHide(this, 'hide_<?=$questionDetails['id']?>', '<?=$originalMessage?>', 'Click to Hide')"><?=$originalMessage?></button>
        <div class="hide_<?=$questionDetails['id']?>" style="display:none;">
          <?php
          foreach($explanations as $key2=>$explanation) {
            $username = getUserInfo($key2)['username'];
            ?>
            <p class="text-pink-300"><?=$username?>:</p>
            <p class ="whitespace-pre-line font-sans"><?=$explanation?></p>

            <?php
          }
          ?>
        </div>
        <?php
      }
    ?>
    <?php
  }

  ?>
</div>




</div>
</div>

</body>

<script>


function updateExcludedInput(responseId) {
  //alert('this works');
  let excludeInput = document.getElementById("excludeInput");
  let form = document.getElementById("controlForm");
  var excludeds = excludeInput.value;
  if(excludeds =="") {
    excludeds = responseId;
  } else {
    excludeds +=","+responseId;
  }
  excludeInput.value = excludeds;

  form.submit();
  
}

function clearExcludedInput(){
  let excludeInput = document.getElementById("excludeInput");
  excludeInput.value="";
}

function clearAssignmentsOnClassChange(form_id) {
  let assignid = document.getElementById("assignid");
  console.log(assignid);
  if(assignid != null) {
    assignid.value = "";
  }

  form_id.form.submit();
}











var index = [];

var indexQuestionsGlobal = [];

function populate() {
	
	questionTab();
	tableGenerate();
	question_review();
	
	
}




<?php

//echo "var assignmentName ='".$assignName."';
//";
/*
$query = "SELECT * FROM responses WHERE assignID = '".$_GET['assignid']."'";
if ($result = mysqli_query($link, $query)) {	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		//Index 2 is a sub-index array, collecting name, userID, and answers from each instance
		echo "var index2=[];
		";		
		echo "index2.push('".$row[name]."', ".$row[userID].", ".$row[percentage].", ".$row[answers].");
		";
		echo "index.push(index2);
		";
		
	}
}
*/
?>

//document.getElementById("nameOfAssignment").innerHTML=assignmentName;

function questionTab() {

var indexQuestions = [];

//var indexQuestions is an index that tabluates results for each question.

	for(var i=0; i<questions.length; i++) {
		
		var indexQuestions2 = []
		
		indexQuestions2.push(questions[i]);
		
		var indexQuestions3 = [];
		for(var j=0; j<data.length; j++) {
			if (data[j]['answers'][i][3] == true) {
				indexQuestions3.push(1);
			}
			
			else if (data[j]['answers'][i][3] == false) {
				indexQuestions3.push(0);
			}
			
		}

    var answers = [];
    var abcde = ['A', 'B', 'C', 'D', 'E'];
    var answerCount = [];
    for(var j=0; j<data.length; j++) {
      answers.push(data[j]['answers'][i][1]);

    }

    for(var j=0; j<abcde.length; j++) {
      answerCount.push([abcde[j],0]);
    }

    for(var j=0; j<answers.length; j++) {
      for(k=0; k<answerCount.length; k++) {
        if(answers[j]==answerCount[k][0]) {
          answerCount[k][1]++;
        }
      }
    }

    //console.log(answerCount);
		
		indexQuestions2.push(answers);
		indexQuestions2.push(indexQuestions3.reduce((a, b) => a + b, 0));
    indexQuestions2.push(answerCount);
		indexQuestions.push(indexQuestions2);
		
	}
	
	indexQuestionsGlobal = indexQuestions;
	//console.log(indexQuestions);


}


function tableGenerate() {

	var row = document.getElementById("questionTableRow");
	for(var i=0; i<questions.length; i++) {
		
		var cell = row.insertCell(i+4);
		var a = document.createElement('a');
		var linkText = document.createTextNode(questions[i]);
		a.appendChild(linkText);
		a.title = questions[i];
		a.href = "#summary"+i;
		cell.appendChild(a);
		//cell.innerHTML = questions[i];
		
	}

	var table = document.getElementById("questionTable");
	for(var i=0; i<data.length; i++) {
		
		var row = table.insertRow(i+1);
		
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);

		cell1.innerHTML = data[i]['name'];
		cell1.setAttribute("class", "nameColumn hideClass")
		cell2.innerHTML = data[i]['userID'];
		cell2.setAttribute("class", "idColumn hideClass")
		cell3.innerHTML = data[i]['percentage'];
		cell3.setAttribute("class", "percentColumn hideClass")
		
		var cell4 = row.insertCell(3);
		cell4.setAttribute("class", "hideClass");
		cell4.innerHTML = "<button onclick='exclude("+i+")'>Exclude</button>";

		
		var cells= [];
		
		for(var j=0; j<questions.length; j++) {
			cell[j]=row.insertCell(j+4);
			cell[j].innerHTML = 
        //data[i]['answers'][j][0]+"<br>"+
        data[i]['answers'][j][1]+"<br>"
        //+data[i]['answers'][j][3]+"<br>"
        ;
			if (data[i]['answers'][j][3] == false) {
				cell[j].setAttribute("class", "incorrect");
			}
					
		}
		
		
			
	}

	var row = document.getElementById("questionTableLastRow");
	for(var i=0; i<indexQuestionsGlobal.length; i++) {
		
		var cell = row.insertCell(i+1);
		cell.innerHTML = indexQuestionsGlobal[i][2]+"/"+data.length;
		
	}

}

function tableClear() {
	
	var table = document.getElementById("questionTable");
	table.innerHTML = '<tr id ="questionTableRow"><td class="nameColumn hideClass">Student Name</td><td class="idColumn hideClass">User ID</td><td class="percentColumn hideClass">&percnt;</td><td class="hideClass">Exclude</td></tr><tr id="questionTableLastRow"><td colspan=4 class="hideClass">Totals:</td></tr>';
	
	
	
}

function exclude(val) {
	
	data.splice(val,1);
	tableClear();
	questionTab();
	tableGenerate();
	
	
}


function question_review() {
	/*
	
	var namehead = document.getElementById("nameHeading");
	namehead.innerHTML = index[0];
	
	var quizhead = document.getElementById("quizName");
	quizhead.innerHTML = index[1];
	
	var scorehead = document.getElementById("scoreID");
	scorehead.innerHTML = index[2]+"/"+index[7].length;
	
	var percenthead = document.getElementById("percentID");
	percenthead.innerHTML = index[3]+"&percnt;";
	*/
	//review_qs.disabled = true;

	var div2 = document.getElementById("summary_div");
	div2.innerHTML = "";

	for(var i=0; i<indexQuestionsGlobal.length; i++) {
	
		
		
		var q_no = document.createElement("h2");
		q_no.innerHTML = "Question "+(i+1);
		
		var p_no = document.createElement("p");
		p_no.innerHTML = "<em>"+(indexQuestionsGlobal[i][0])/*.toFixed(6)*/+"</em>";

		
		var img = document.createElement("img");
		
		
		var bigjpg = (indexQuestionsGlobal[i][0]).toFixed(6)+".JPG";
		var smljpg = (indexQuestionsGlobal[i][0]).toFixed(6)+".jpg";
	
		if (typeof bigjpg != "undefined") {
		
		img.setAttribute("src", "question_img/"+bigjpg);
		
		}else if (typeof smljpg != "undefined") {
		
		img.setAttribute("src", "question_img/"+smljpg);
		}
		
		/*
		img.setAttribute("src", "question_img/"+record[i][0]+".jpg");
		*/
		/*
		var your_ans = document.createElement("P");
		your_ans.innerHTML = "Your Answer: "+index[7][i][1];
		
		if (index[7][i][3]==false) {
			
			your_ans.style.backgroundColor = "#ffff00";
		
		}
		*/
		
		
		var correct_ans = document.createElement("P");
		correct_ans.innerHTML = "Number Correct: "+indexQuestionsGlobal[i][2]+"/"+index.length;
		//correct_ans.setAttribute("class", "correctAnswer");
    
    
    var summary = document.createElement('p');
    for(var j=0; j<indexQuestionsGlobal[i][3].length; j++) {
      var span = document.createElement('span');
      span.innerHTML = indexQuestionsGlobal[i][3][j][0]+":"+indexQuestionsGlobal[i][3][j][1]+" || ";
      summary.appendChild(span);
    }
		
		
		
		
		var div = document.createElement("div");
		div.setAttribute("class", "summaryQuestion")
		
		var a = document.createElement('a');
		var linkText = document.createTextNode("Click to return to summary");
		a.appendChild(linkText);
		a.title = "Click to return to summary";
		a.href = "#questionTable";
		
		var b = document.createElement('br');
		
		
		
		div.appendChild(q_no);
		div.appendChild(p_no);
		div.appendChild(a);
		div.appendChild(b);
		div.appendChild(img);
		//div.appendChild(your_ans);
		div.appendChild(correct_ans);
    div.appendChild(summary);
		div.setAttribute("id", "summary"+i)
		div2.appendChild(div);
	
	}
	





}


var toggle = 0;
//console.log(toggle);

function nameToggle() {
  //alert('this works');
  //console.log(toggle);
	

	
	if (toggle == 0) {
	
		var hideClass = document.getElementsByClassName("hideClass");
		for(var j=0; j<hideClass.length; j++) {
			hideClass[j].style.display = "none";
			}
			
			
		toggle = 1;
		document.getElementById("toggleButton").innerHTML = "Show Names";
		}	
	
	else {
		
		var hideClass = document.getElementsByClassName("hideClass");
		for(var j=0; j<hideClass.length; j++) {
		
		hideClass[j].style.display = "table-cell";
		
		}
	toggle = 0;
	document.getElementById("toggleButton").innerHTML = "Hide Names";
	}
	
	
}

</script>

<?php include ($path."/footer_tailwind.php");  ?>