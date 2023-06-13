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
  $userType = $userInfo['usertype'];
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

<?php

$head_insert = "


<style>


.answerBox {
	
	width: 100%;
	height: 200px;
	resize: none;
	font-family: 'Arial', Times, serif;
	font-size: 12px;
	white-space: pre-wrap;
	
}

.linebreak {
	
	white-space: pre-wrap;
	
}

#logindiv {
	
	border: 1px solid black;
	background-color: coral;
	
	
}

.questionImage {
	width:100%;
    max-width:600px;
	
	
}

.questionContainer {
	
	border-top: 3px solid pink;
	margin-top: 5px;
	//border: 2px solid black;
	//margin: 5px;
	//padding: 5px;
	
}

#submitMessage {
	
	
	background-color: coral;
}

";

?>
<?=$head_insert;?>
</style>



</head>


<body onload="populate()">




<h1>Short Answer Questions: <span id="nameOfQuiz"></span></h1>

<?php 


//Calling details from assignments table
$assignid = $_GET['assignid'];

$sql = "SELECT * FROM assignments WHERE id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $assignid);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows>0) {
  $row = $result->fetch_assoc();

  if ($row['type'] != "saq")  {
			
    $errorText = "Loading error: assignid not linked to SAQ assignment.";
    
    exit($errorText);
  }
  
  print_r($row);
  
  $exerciseid = $row['quizid'];
  $exerciseName = $row['assignName'];
  $groupArray = json_decode($row['groupid_array']);
  


}



if (isset($_SESSION['userid'])) {
	
	
	echo '<p>Open previously saved versions:</p><div id="savedWork"></div>';
	
	
}


if (isset($_GET['exerciseid'])) {

  $exerciseid = $_GET['exerciseid'];
}




//Retreive previously completed assignments
$datesCompleted = array();

$sql = "SELECT id, datetime FROM saq_saved_work WHERE userID= ? AND exerciseID = ?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("ii", $_SESSION['userid'], $exerciseid);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows>0) {
  while ($row = $result->fetch_assoc()) {
    print_r($row);
		array_push($datesCompleted, $row['datetime']);
		//echo "<br>";
  }
}

print_r($datesCompleted);

	
$dateRecent = max($datesCompleted);
	
echo "<br>Most recent date: ".$dateRecent;
	
//echo "<br><br>";
	


?>

<br>
<button onclick="saveWork()" id="saveButton">Save Work</button>


<?php 

if (isset($assignid) && isset($_SESSION['userid'])) {

  ?>
	
	<br><button onclick='submitWork()' id='submitButton'>Submit Work</button>
	
  <?php
	
}


//Retrieve exercise information

echo "<br>".$exerciseid;


$sql = "SELECT * FROM saq_exercises WHERE id = ?";
$stmt= $conn->prepare($sql);
$stmt->bind_param("i", $exerciseid);
$stmt->execute();

$result= $stmt->get_result();

if($result->num_rows>0) {
  $row = $result->fetch_assoc();
  print_r($row);
  $questionsArray = explode(",", $row['questions']);
  foreach($questionsArray as &$value) {
    $value = trim($value);
  }
  $exerciseName = $row['exerciseName'];

  print_r($questionsArray);

  $questions = array();

  $sql = "SELECT * FROM saq_question_bank_3 WHERE id=?";
  $stmt=$conn->prepare($sql);

  foreach($questionsArray as $value) {
    $stmt->bind_param("i", $value);
    $stmt->execute();
    $result=$stmt->get_result();
    if ($result->num_rows>0) {
      $row = $result->fetch_assoc();
      //print_r($row);
      array_push($questions, $row);
    }

  }

  print_r($questions);

  foreach($questions as $key=>$row) {

    ?>

    <div class="questionContainer">
      <p><?=$key+1?>: <?=$row['question']?> (<?=$row['points']?>)</p>

      <?php
        if($row['img']!="") {
          ?>
            <p>
              <img src = "<?=$row['img']?>" class="questionImage">
            </p>
          <?php
        }
      ?>

      <textarea class="answerBox" id="answerBox_<?=$key?>" name = "response_<?=$key?>" onselectstart="return false" onpaste="return false" oncopy="return false">Response</textarea>

      
    </div>


    <?php

  }


}


?>




<div id = "questionDiv">

</div>



<?php include "../footer.php"; ?>




<script>



<?php 



//Check to see if assignment has already been submitted, error message if not.

if (isset($assignid)) {

$query = "SELECT * FROM saq_saved_work WHERE userID='".$userid."' AND assignID='".$assignid."'";

		if ($result = mysqli_query($link, $query)) {
			
			while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
				
				//print_r($row);
				if ($row[submit] ==1) {
					
					echo "document.getElementById('saveButton').disabled = true;";
					
					echo "document.getElementById('submitButton').disabled = true;";
					
					echo "document.getElementById('submitMessage').innerHTML = 'You have already submitted this assignment on ".$row[datetime].". Please contact your teacher if you  need to access your work';";
					
					//$errorText = "Error: You have already submitted this assignment on ".$row[datetime].". Please contact your teacher if you  need to access your work";
					//exit($errorText);
					
				}
				 
				
			
				
				}
						
			}
}





echo "
/*";








$query = "SELECT * FROM saq_exercises WHERE id='".$exerciseid."'";

if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		
		

		//print_r($row);
		$questionNos = $row[questions];
		$questionNos = (explode(",",$questionNos));
		$exerciseName = $row[exerciseName];
		
		//print_r($questionNos);
		
		
		
		
		}

				
	}


$questions = array();
$images = array();
$points = array();

for ($x = 0; $x <= count($questionNos); $x++) {

  $query = "SELECT * FROM saq_question_bank_3 WHERE id='".$questionNos[$x]."'";
  if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		
		

		//print_r($row);
		
		$question = $row[question];
		$image = $row[img];
		$point = $row[points];
		//echo $question;
		
		
		array_push($questions, $question);
		array_push($images, $image);
		array_push($points, $point);
		
		
		
		}
	}


}

//print_r($questions);
print_r($images);



echo "*/
";

echo "document.getElementById('nameOfQuiz').innerHTML ='".$exerciseName."';";

echo "
var index = ".json_encode($questions).";
var questionNos = ".json_encode($questionNos).";
var exerciseName = '".$exerciseName."';
var images = ".json_encode($images).";
var points = ".json_encode($points).";


var savedResponse = [];



";



if (!empty($_POST['record'])) {
	
	echo "savedResponse = ".$_POST['record'].";

	";
}



$query = "SELECT id, answers, datetime FROM saq_saved_work WHERE userID='".$userid."' AND exerciseID='".$exerciseid."' AND datetime='".$dateRecent."'";

if (isset($userid)) {

	if ($result = mysqli_query($link, $query)) {
		
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			
		
			echo "/*
			";
			
		//print_r($row);
		
			echo "
			*/";
		
		if(!empty($row['answers'])) {
		
		echo "savedResponseServer = ".$row['answers'].";";
		
		}
		
	}
}

$query = "SELECT id, answers, datetime FROM saq_saved_work WHERE userID='".$userid."' AND exerciseID='".$exerciseid."'";


echo "

var savedWorkDates = [];
var savedWorkResponses = []

";

if ($result = mysqli_query($link, $query)) {

	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		
		//print_r($row);
		echo "savedWorkDates.push('".$row['datetime']."');";
		echo "savedWorkResponses.push(".$row['answers'].");";
		
		
		}
				
	}




?>

console.log(savedWorkDates);
console.log(savedWorkResponses);

var answers = [];
var record = [];



//window.onbeforeunload = function(){ return '';};

var loggedIn;

<?php
	
	if (!empty($_POST['userid'])) {
		
		echo "loggedIn = 1";
		
		
	} 
	
	?>

function populate() {

	for (var i=0; i<index.length; i++) {
	
	var p = document.createElement("p");
	var div = document.createElement("div");
	div.setAttribute("class", "questionContainer")
	var input = document.createElement("textarea");
	var header = document.createElement("span");
	var pointsSpan = document.createElement("span");
	
	
	
	
	
	header.innerHTML = i+1+": ";
	p.innerHTML = index[i];
	
	
	pointsSpan.innerHTML = " ("+points[i]+")";
	
	p.appendChild(pointsSpan);
	
	
	
	
	input.setAttribute("class", "answerBox");
	input.setAttribute("id", "answerBox_"+i);
	//input.setAttribute("type", "text");
	//input.setAttribute("style", "width: 100px; height: 50px; resize: none; font-family: 'Arial', Times, serif; font-size: 12px;  ");
	
	
	
	if (typeof savedResponseServer !== 'undefined') {
		
		input.innerHTML = savedResponseServer[i][1];
		//input.innerHTML = decodeURIComponent(savedResponseServer[i]);
	}
	
	else if (savedResponse.length == index.length) {
		input.innerHTML = savedResponse[i][1];	
		}
	
	
 
	
	
	
	input.setAttribute("onselectstart","return false");
	input.setAttribute("onpaste","return false");
	input.setAttribute("onCopy", "return false"); 
	//onCut="return false" onDrag="return false" onDrop="return false"
	
	var questionDiv = document.getElementById("questionDiv");
	
	//div.appendChild(header);
	p.insertBefore(header, p.childNodes[0]);
	div.appendChild(p);
	
	if (images[i] != "") {
		
		var p2 = document.createElement("p");
		
		var img = document.createElement("img");
		img.setAttribute("src", images[i]);
		img.setAttribute("class", "questionImage");
		p2.appendChild(img);
		div.appendChild(p2);
		
		
		
	}
	
	
	div.appendChild(input);
	
	

	
	questionDiv.appendChild(div);
	
	
	
	var form = document.getElementById("myForm");
	
	
	
	
	var input = document.createElement("input");
	
	input.setAttribute("name", "response_"+i);
	input.setAttribute("id", "question_response_input"+i);
	
	form.appendChild(input);
	
	}
	
	
if (loggedIn == 1) {
	
		for (var i=0; i<savedWorkDates.length; i++) {
			
			var div = document.getElementById("savedWork");
			var button = document.createElement("button");
			var br = document.createElement("br");
			
			button.setAttribute("onclick", "savedRecall("+i+")")
			
			button.innerHTML = savedWorkDates[i];
			
			div.appendChild(button);
			div.appendChild(br);
		}	
	}

}





function saveWork() {
	
if (loggedIn == 1) {
	
	
	
	compileRecord();
	
	document.getElementById("f1").value = JSON.stringify(record);
	
	document.getElementById("f2").value = <?php echo "'".$exerciseName."';";
	?>
	document.getElementById("f3").value = <?php echo $exerciseid.";";?>
	
	for(var i=0; i<index.length; i++) {
		
		
		questionInputFill(i);
	}
	
	
	document.getElementById("f5").value = index.length;
	
	document.getElementById("myForm").submit();
	}
	
	else {
		
		
		alert("You must be logged in to save your work");
	}
}

function compileAnswers() {
	
	answers.length = 0;
	
	var inputbox = document.getElementsByClassName("answerBox");
	
	for(var i=0; i<inputbox.length; i++) {
		answers.push(inputbox[i].value)
		
		
	}
	
	console.log(answers)
}

function compileRecord() {
//	compileAnswers();
	record.length = 0;
	
	for(var i=0; i<index.length; i++) {
		
		var record2 = [];
		record2.push(questionNos[i]);
		
		//record2.push(answers[i]);
		record2.push(index[i]);
		record.push(record2);
		
		
		
	}
	
	console.log(record);
	
}

function questionInputFill(i) {
	
	
	var input = document.getElementById("question_response_input"+i);
	
	var answerbox = document.getElementById("answerBox_"+i);
	
	input.value = answerbox.value;
	
	
	
}

function loginClick() {
	
	compileAnswers();
	
	record.length = 0;
	
	for(var i=0; i<index.length; i++) {
		
		var record2 = [];
		record2.push(questionNos[i]);
		
		record2.push(answers[i]);
		record2.push(index[i]);
		record.push(record2);
		
		
		
	}
	
	
	document.getElementById("f4").value = JSON.stringify(record);
	
	
	
}

function savedRecall(i) {
	
	
	
	for (var j=0; j<index.length; j++) {
		
		var input = document.getElementById("answerBox_"+j);
		input.innerHTML = savedWorkResponses[i][j][1];
		
		
		
	}
	
	
}

function submitWork() {
	
	
	var confirmText = "You are about to submit your work. You will not be able to change your answers."
	
	if (confirm(confirmText)) {
		
		document.getElementById("submitconfirmId").value = 1;
		saveWork();
		
		
	}
	
	
}

</script>


</body>






</html>