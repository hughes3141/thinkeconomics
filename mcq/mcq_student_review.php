<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include($path."/php_header.php");
  $link = mysqli_connect($servername, $username, $password, $dbname);

  if (mysqli_connect_error()) {
    
    die ("The connection could not be established");
  }

?>

<html>

<head>

<style>

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

</style>

<?php include "../header.php"?>

</head>



<body>

<?php include "../navbar.php"?>

<div id="inputForm">

<h1>Multiple Choice Questions Review (by student): <span id="nameOfQuiz"></span></h1>

<form method="get">
<label for ="userid">Student Name:</label>
<select name="userid">;
<?php 


$query = "SELECT id, name FROM users WHERE active = 1";

if ($result = mysqli_query($link, $query)) {	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if ($row[id] == $_GET['userid']) {
			$selected = " selected = 'selected'";
			}
			else {$selected = "";}
		echo "<option value = '".$row[id]."'".$selected.">".$row[name]."</option>";
	}
}


?>
</select>
<input type="submit" value ="Submit">
</form>


<div id ="div1">

<table id="resultsTable">
<tr>
<th>Quiz Name
</th>
<th>Mark
</th>
<th>Percentage
</th>
<th>timeStart
</th>
<th>timeEnd
</th>
<th>assignID
</th>
<th>Review
</th>
</tr>
</table>

</div>
</div>
<button onclick="answerToggle()" id ="toggleButton">Hide Answers</button>

<button onclick="tableToggle()" id ="toggleButton2">Hide Input Form</button>


<div id ="review">
</div>
<h1 id ="quizName"></h1>
<p>Name: <span id = "nameHeading"></span></p>
<p>Score: <span id ="scoreID"></span>, <span id ="percentID"></span></p>

<div id ="summary_div">

</div>

<?php include "../footer.php"?>

</body>



<script>

//Var superIndex is an array with each item an array that desribes a quiz instance. It is used to create index, which is the values of the instsance we want to review

var index = [];

<?php 


$superIndex = array();


$userid = $_GET['userid'];


$query = "SELECT name, quiz_name, mark, percentage, timeStart, datetime, assignID, answers FROM responses WHERE userID = '".$userid."'";

if ($result = mysqli_query($link, $query)) {	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		
		$response = array();
		
		array_push($response, $row[name]);
		array_push($response, $row[quiz_name]);
		array_push($response, $row[mark]);
		array_push($response, $row[percentage]);
		array_push($response, $row[timeStart]);
		array_push($response, $row[datetime]);
		array_push($response, $row[assignID]);
		array_push($response, json_decode($row[answers]));
		
		/*
		echo $row[name];
		echo "<br>";
		echo $row[quiz_name];
		echo "<br>";

		echo $row[answers];
		echo "<br><br>";
		*/
		
		//$response = json_encode($response);
		array_push($superIndex, $response);
	}
}
echo "var superIndex =".json_encode($superIndex);
?>

//console.log(superIndex);



for(var i=0; i<superIndex.length; i++) {
	
	var table = document.getElementById("resultsTable");
	var row = table.insertRow(i+1);
		
		var cell = [];
		var cellElements =[superIndex[i][1], superIndex[i][2], superIndex[i][3]+"&percnt;", superIndex[i][4], superIndex[i][5], superIndex[i][6], "<button onclick ='review("+i+")'>Review</button>"];
		for(var j=0; j<7; j++) {
			cell[j] = row.insertCell(j);
			cell[j].innerHTML = cellElements[j];
			
			
		}
	
	var cellElements =[superIndex[i][1], superIndex[i][2], superIndex[i][3], superIndex[i][4], superIndex[i][5], superIndex[i][6]];
	
	
	
	
}

function review(k) {
	
	var div = document.getElementById("review");
	index = superIndex[k];
	
	console.log(index);
	question_review();
}


function question_review() {
	
	var namehead = document.getElementById("nameHeading");
	namehead.innerHTML = index[0];
	
	var quizhead = document.getElementById("quizName");
	quizhead.innerHTML = index[1];
	
	var scorehead = document.getElementById("scoreID");
	scorehead.innerHTML = index[2]+"/"+index[7].length;
	
	var percenthead = document.getElementById("percentID");
	percenthead.innerHTML = index[3]+"&percnt;";
	
	//review_qs.disabled = true;

	var div2 = document.getElementById("summary_div");
	div2.innerHTML = "";

	for(var i=0; i<index[7].length; i++) {
	
		
		
		var q_no = document.createElement("h2");
		q_no.innerHTML = "Question "+(i+1);
		
		var p_no = document.createElement("p");
		p_no.innerHTML = "<em>"+(index[7][i][0])/*.toFixed(6)*/+"</em>";

		
		var img = document.createElement("img");
		
		
		var bigjpg = (index[7][i][0])/*.toFixed(6)*/+".JPG";
		var smljpg = (index[7][i][0])/*.toFixed(6)*/+".jpg";
	
		if (typeof bigjpg != "undefined") {
		
		img.setAttribute("src", "question_img/"+bigjpg);
		
		}else if (typeof smljpg != "undefined") {
		
		img.setAttribute("src", "question_img/"+smljpg);
		}
		
		/*
		img.setAttribute("src", "question_img/"+record[i][0]+".jpg");
		*/
		var your_ans = document.createElement("P");
		your_ans.innerHTML = "Your Answer: "+index[7][i][1];
		
		if (index[7][i][3]==false) {
			
			your_ans.style.backgroundColor = "#ffff00";
		
		}
		
		
		
		var correct_ans = document.createElement("P");
		correct_ans.innerHTML = "Correct Answer: "+index[7][i][2];
		correct_ans.setAttribute("class", "correctAnswer");
		
		
		
		var div = document.createElement("div");
		div.setAttribute("class", "summaryQuestion")
		
		div.appendChild(q_no);
		div.appendChild(p_no);
		div.appendChild(img);
		div.appendChild(your_ans);
		div.appendChild(correct_ans);
		
		div2.appendChild(div);
	
	}
	





}

var toggle = 0;

function answerToggle() {
	

	
	if (toggle == 0) {
	
	var answersClass = document.getElementsByClassName("correctAnswer");
	for(var j=0; j<answersClass.length; j++) {
		
		answersClass[j].style.display = "none";
		
		}
	toggle = 1;
	document.getElementById("toggleButton").innerHTML = "Show Answers";
	}	
	
	else {
		
		var answersClass = document.getElementsByClassName("correctAnswer");
		for(var j=0; j<answersClass.length; j++) {
		
		answersClass[j].style.display = "block";
		
		}
	toggle = 0;
	document.getElementById("toggleButton").innerHTML = "Hide Answers";
	}
	
	
}


var toggle2 = 0;

function tableToggle() {
	

	
	if (toggle2 == 0) {
	
	var form = document.getElementById("inputForm");
		
	form.style.display = "none";
	
	var titleClass = document.getElementsByClassName("title");
	for(var j=0; j<titleClass.length; j++) {
		
		titleClass[j].style.display = "none";
		
		}
		
	var titledivClass = document.getElementsByClassName("titlediv");
	for(var j=0; j<titledivClass.length; j++) {
		
		titledivClass[j].style.display = "none";
		
		}
		
		
	toggle2 = 1;
	document.getElementById("toggleButton2").innerHTML = "Show";
	}	
	
	else {
		
		var form = document.getElementById("inputForm");
		
	form.style.display = "block";
	
	
	var titleClass = document.getElementsByClassName("title");
	for(var j=0; j<titleClass.length; j++) {
		
		titleClass[j].style.display = "block";
		
		}
		
	var titledivClass = document.getElementsByClassName("titlediv");
	for(var j=0; j<titledivClass.length; j++) {
		
		titledivClass[j].style.display = "block";
		
		}
	
		
	toggle2 = 0;
	document.getElementById("toggleButton2").innerHTML = "Hide Input Form";
	}
	
	
}

</script>

</html>