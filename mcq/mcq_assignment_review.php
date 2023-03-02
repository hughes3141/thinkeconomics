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

h2 {
	border-top: 1px solid black;
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

include ($path."/header_tailwind.php");
?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20 w-full">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1 ">Multiple Choice Questions Assignment Review</h1>
  <div class="container mx-auto p-4 mt-2 bg-white text-black ">
  
  <form method="get">
    <label for ="classid">Class:</label>
    <select name="classid" onchange="this.form.submit()">
      <option></option>
      <?php
      foreach($groups as $row) {
        ?>

        <option value="<?=$row['id']?>" <?=(isset($_GET['classid'])&&$row['id']==$_GET['classid']) ? "selected" : ""?>><?=htmlspecialchars($row['name'])?></option>

        <?php
      }
      ?>
    </select>
    <?php

    if(isset($_GET['classid'])) {

      //$assignments = getAssignmentsList($userId, $_GET['classid'], "mcq");
      $assignments = getAssignmentsByGroup($_GET['classid'], 1000, "mcq");
      //print_r($assignments);
      ?>
      <label for ="assignid">Assignment Name:</label>
      <select name="assignid">
        <option></option>
        <?php
          foreach($assignments as $assignment) {
            ?>
            <option value = "<?=$assignment['id']?>" <?=(isset($_GET['assignid'])&&$assignment['id']==$_GET['assignid']) ? "selected" : ""?>><?=htmlspecialchars($assignment['assignName'])?></option>

            <?php
          }

        ?>
      </select>

      <?php 
    }
  ?>
  <div>
    <input type="radio" id="filter_all" name="filter" value="all" <?=(isset($_GET['filter'])&&$_GET['filter']=="all") ? "checked" : ""?>>
    <label for="filter_all">All Results</label><br>
    <input type="radio" id="filter_last" name="filter" value="last" <?=(isset($_GET['filter'])&&$_GET['filter']=="last") ? "checked" : ""?>>
    <label for="filter_last">Last Response</label><br>
    <input type="radio" id="filter_first" name="filter" value="first" <?=(isset($_GET['filter'])&&$_GET['filter']=="first") ? "checked" : ""?>>
    <label for="filter_first">First Response</label>
  </div>


  <div>
    <input type="radio" id="question_order_original" name="questionOrder" value="" <?=(!isset($_GET['questionOrder'])||$_GET['questionOrder']=="") ? "checked" : ""?>>
    <label for="question_order_original">Original</label><br>  
    <input type="radio" id="question_order_incorrect" name="questionOrder" value="incorrect" <?=(isset($_GET['questionOrder'])&&$_GET['questionOrder']=="incorrect") ? "checked" : ""?>>
    <label for="question_order_incorrect">Incorrect</label><br>
    
  </div>


  <input class="border border-black p-3 bg-pink-300 my-2" type="submit" value ="Submit">
  </form>
<button onclick="nameToggle()" id="toggleButton">Click to Hide Names</button>

<?php
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
  }
  //print_r($results[0]);
  //print_r($results);

  echo "<br>";
  $questionSummary =array();
  foreach ($questions as $question) {
    $questionSummaryInstance = array('question' => $question, 'correctCount'=>0, 'summary'=>array(), 'correct'=>"");
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

?>

<table id ="questionTable">
  <tr id ="questionTableRow">
    <th class="nameColumn hideClass">Student Name</th>
    <th>Time</th>
    <th class="percentColumn hideClass">&percnt;</th>
    <th class="hideClass">Exclude</th>
    <?php
    foreach ($questionSummary as $key => $question) {
      ?>
      <th><?=$question['question']?></th>

      <?php
    }
      
    ?>
  </tr>
  <?php
    foreach($results as $result) {
      ?>
    <tr>
      <td><p><?=htmlspecialchars($result['name_first'])?> <?=htmlspecialchars($result['name_last'])?></p>
      <?php
        /*
        echo $result['datetime'];
        echo $result['maxdatetime'];
        echo "<br>";
        echo $result['mindatetime'];
        */
      ?>

    </td>
    <td>
      <p><?=date("d/m/y", strtotime($result['datetime']))?></p>
      <p><?=date("H:i:s", strtotime($result['datetime']))?></p>
      <p><?=$result['duration']?> min</p>
    </td>
      <td><?=$result['percentage']?></td>
      <td>Exclude Button</td>
      <?php
      foreach ($questionSummary as $question) {
        $questionResponse = getMCQindividualQuestionResponse($question['question'], $result['answers']);
        ?>
        <td <?=($questionResponse['correct'] == "") ? "class='bg-pink-200'" : ""?>>
          <p><?=$questionResponse['answer']?></p>
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

  }
  ?>
  <tr id="questionTableLastRow">
    <td colspan=1 class="hideClass">Totals:</td>
    <td></td>
    <td></td>
    <td></td>
    <?php
    foreach ($questionSummary as $key=>$question) {
      echo "<td>";
      echo $question['correctCount'];
      echo "</td>";
    }

    ?>
  </tr>

</table>

<?php


/*
use getAssignmentInfoById():


//$sql = "SELECT * FROM assignments WHERE id = '".$assignId."'";
$sql = "SELECT * FROM assignments WHERE id = ?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("i", $assignId);
$stmt->execute();
$result=$stmt->get_result();
if ($result) {
	$row = $result->fetch_assoc();
	$quizid = $row['quizid'];
	$assignName=$row['assignName'];
	echo $quizid."<br>";
}
*/


?>




<div id ="summary_div">
  <?php
  foreach ($questionSummary as $key=>$question) {
    ?>
    <h2>Question <?=$key + 1?></h2>
    <p><em><?=$question['question']?></em></p>
    <img src="question_img/<?=trim($question['question'])?>.JPG" alt="question <?=$question['question']?>">
    <p>Number Correct: <?=$question['correctCount']."/".count($results)?></p>
    <p>Summary: <?php
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




    <?php
  }

  ?>
</div>

<div id="testDiv">
</div>



<?php

/*
use getMCQquizResultsByAssignment($_GET['assignid']); 

$data = array();
$sql = "SELECT name, mark, percentage, answers, timeStart, datetime, userID FROM responses WHERE assignId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $assignId);
$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    //print_r($row);
    //echo "<br>";
    
    $row['answers'] = json_decode($row['answers']);
    //print_r($row['answers']);
    array_push($data, $row);
  }
}

//print_r($data);

$data = json_encode($data);
//echo $data;

*/
?>

  </div>
</div>

</body>

<script>





var testDiv = document.getElementById("testDiv");




for(var i=0; i<data.length; i++) {
    var p = document.createElement("p");
    p.innerHTML = data[i]['answers'];
    //testDiv.appendChild(p);


}



var questions = [<?php 

$sql = "SELECT questions FROM mcq_quizzes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $quizid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	echo $row['questions'];

}

?>];

//console.log(questions);

var index = [];

var indexQuestionsGlobal = [];

function populate() {
	
	questionTab();
	tableGenerate();
	question_review();
	
	
}




<?php

echo "var assignmentName ='".$assignName."';
";
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

document.getElementById("nameOfAssignment").innerHTML=assignmentName;

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
	console.log(indexQuestions);


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

function nameToggle() {
	

	
	if (toggle == 0) {
	
		var hideClass = document.getElementsByClassName("hideClass");
		for(var j=0; j<hideClass.length; j++) {
			hideClass[j].style.display = "none";
			}
			
			
		toggle = 1;
		document.getElementById("toggleButton").innerHTML = "Click to Show Names";
		}	
	
	else {
		
		var hideClass = document.getElementsByClassName("hideClass");
		for(var j=0; j<hideClass.length; j++) {
		
		hideClass[j].style.display = "table-cell";
		
		}
	toggle = 0;
	document.getElementById("toggleButton").innerHTML = "Click to Hide Names";
	}
	
	
}

</script>

<?php include ($path."/footer_tailwind.php");  ?>