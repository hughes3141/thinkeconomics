
<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include($path."/php_header.php");
  $link = mysqli_connect($servername, $username, $password, $dbname);

  if (mysqli_connect_error()) {
    
    die ("The connection could not be established");
  }

session_start();
?>

<html>

<head>

<style>

td, th {
	
	border: 1px solid black;
	padding: 5px;
}

table {
	
	border-collapse: collapse;
}

h2 {
	//border-top: 1px solid black;
}

</style>

<?php include "../header.php"?>

</head>



<body>

<?php include "../navbar.php";


//print_r($_POST);


$userid = $_SESSION['userid'];



?>



<h1>Short Answer Questions Review: <?php echo $_SESSION[name];?></h1>




<div id ="div1">

<table id="resultsTable">
<tr>
<th>assignID
</th>
<th>Exercise Name
</th>
<th>Mark
</th>
<th>Percentage
</th>
<th>Time Submitted
</th>
<th>Submit
</th>

<th>Returned
</th>
<th>Review
</th>
</tr>


<?php

$query = "SELECT * FROM saq_saved_work WHERE userID = '".$userid."' AND submit=1";

if ($result = mysqli_query($link, $query)) {	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		
		echo "<tr><td>";
		echo $row[assignID]."</td><td>";
		echo $row[exerciseName]."</td><td>";
		echo $row[mark]."</td><td>";
		echo $row[percentage]."</td><td>";
		echo $row[datetime]."</td><td>";
		echo $row[submit]."</td><td>";
		echo $row[returned]."</td><td>";
		echo "<form method = 'post'><input type='hidden' name = 'responseid' value = '".$row[id]."'><input type='hidden' name = 'userid' value = '".$row[userID]."'><input type='submit' value = 'Review'></form>";
		//print_r($row);
		echo "</tr>";
	
		
	}
}

echo "</table>";

if (isset($_POST['responseid'])) {

	$query = "SELECT * FROM saq_saved_work WHERE id = '".$_POST[responseid]."'";

if ($result = mysqli_query($link, $query)) {	
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);	
	echo "<h2>Review: ".$row[exerciseName]."</h2>";

	
	
	echo "<table>
<tr>
<th>Question No
</th>
<th>Question
</th>
<th>Your Answer
</th>
<th>Marks
</th>
<th>Feedback
</th>
<th>Guidance
</th>

</tr>";
	
	

	
		$answers = json_decode($row[answers], true);
		
		$feedback = json_decode($row[feedback], true);
		
		//print_r($answers);
		//print_r($feedback);	
		
		for ($x=0; $x <count($answers); $x++)	{
			
			$query2 = "SELECT * FROM saq_question_bank_3 WHERE id = '".$answers[$x][0]."'";
			$result2 = mysqli_query($link, $query2);
			$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
		
			echo "<tr><td>";
			echo ($x+1)."</td><td>";
			echo $answers[$x][2]."</td><td>";
			echo $answers[$x][1]."</td><td>";
			echo $feedback[$x][1]."/".$row2[points]."</td><td>";
			echo $feedback[$x][2]."</td><td>";
			echo $row2[model_answer]."</td>";
			
		
			
		echo "</tr>";
		}
		
	
}
	
	
echo "</table>";	
}



?>






</div>
</div>

<?php include "../footer.php"?>

</body>



<script>









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