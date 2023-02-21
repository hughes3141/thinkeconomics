<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];


if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

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

.noReturn	{
	
	
	background-color: #FFFF00;
}

.noComplete {
	
	color: red;
}

</style>

<?php include "../header.php"?>

</head>



<body>

<?php include "../navbar.php";




?>



<h1>All Assignments Review: <?php echo $_SESSION['name'];?></h1>
<p>This page contains all the assignments that have been given to you or your class.</p>
<p>You can use this page to ensure you are up to date with your work, or re-submit assignments. This is the same information your teacher sees when processing report data.</p>





<h2>
Assignment List</h2>



<?php //echo '<form method="post"><label for="userID">User ID:</label><input id ="userID" type ="text" name ="userid"><input type="submit" value="See Assignments"></form>';

?>

<?php 




$userid = $_SESSION['userid'];
//echo $userid;



$user = getUserInfo($userid);
//print_r($user);

$groupid_array = json_decode($user['groupid_array']);

//print_r($groupid_array);


?>


<table>
<tr>
<th>ID
</th>
<th>Assignment Name
</th>
<!--
<th>quizid
</th>
<th>groupid
</th>
<th>notes
</th>
-->
<th>Date Assigned
</th>

<th>Due Date
</th>
<th>Type
</th>
<th>
Your Score(s)
</th>

<th>
Assignment Link
</th>
</tr>


<?php 



$assignments = getAssignmentsArray($groupid_array);
//print_r($assignments);



foreach($assignments as $value) {
  echo "<tr>";
    echo "<td>".$value['id']."</td>";
    echo "<td>".$value['assignName']."</td>";
    echo "<td>".date("Y-m-d",strtotime($value['dateCreated']))."</td>";
    echo "<td>".$value['dateDue']."</td>";
    if($value['type'] == 'mcq') {
      echo "<td>MCQ</td>";
    }
    else if($value['type'] == 'sqa') {
      echo "<td>Short Answer</td>";
    }
    else {
      echo "<td>".$value['type']."</td>";
    }
		
		if ($value['type'] == "mcq") {
			
			echo "<td>";
			
			$query = "SELECT * FROM responses WHERE userID = ".$userid." AND assignID =".$value['id'];

      $result = $conn->query($query);
      
			
						$query2 = "SELECT assignReturn FROM assignments WHERE id = ".$value['id'];
            $result2 = $conn->query($query2);
						if ($result2->num_rows>0) {
							
						$row2 = $result2 -> fetch_assoc();
            //mysqli_fetch_array($result2, MYSQLI_ASSOC);
								
						if ($row2['assignReturn'] == 1 or $row2['assignReturn'] == null) {
								
								
								$assignReturn = 1;
							}
							
						else {
								
								$assignReturn = 0;
							}
							
							//$assignReturn = $row2[assignReturn];
								
							
							
							
							
						}
			
			
				if ($assignReturn == 0) {
					
					echo "<span class='noReturn'>Not Yet Returned</span>";
					
				}
			
				else {
			
				if ($result->num_rows>0 ) {


					
					while ($row = $result->fetch_assoc()) {
						
						//print_r($row);
						
						
						$s = $row['datetime'];
						$dt = new DateTime($s);

						$date = $dt->format('d.m.y');
						//$time = $dt->format('H:i:s');

						//echo $date, ' | ', $time;
						
						
						echo $row['percentage']."&percnt; (".$date.")";
						echo "<br>";
						
						
					
						}
				
				}
				}
			echo "</td>";
			echo "<td>";

// THIS IS WHERE TO CHANGE THE LINK AFTER MAKING CHANGES TO MCQ PAGE

			echo "<a href = '../mcq/mcq_exercise.php?assignid=".$value['id']."'>Link to MCQ</a>";
			echo "</td>";
			
			
		}
		
		if ($value['type'] == "saq") {
			
			echo "<td>";
			
			
			$query = "SELECT * FROM saq_saved_work WHERE userID = '".$userid."' AND submit=1 AND assignID = '".$value['id'  ]."'";

      $result = $conn->query($query);
			
			if ($result) {
				
				if ($result->num_rows==0) {
						
						echo "<span class = 'noComplete'>Not yet submitted</span>";
					}

				
				while ($row = $result->fetch_assoc()) {
				$s = $row['datetime'];
				$dt = new DateTime($s);
				$date = $dt->format('d.m.y');
				echo "Submitted: ".$date."<br>";
				//echo "Submitted: ".$row[datetime]."<br>";
				
				if ($row['returned'] == 1) {
				//echo "Returned<br>";
				echo "Score: ".$row['percentage']."&percnt;<br>";
				}
				else {
				echo "<span class='noReturn'>Not Yet Returned</span><br>";
				}
				/*
				echo $row[assignID];
				echo $row[exerciseName];
				echo $row[mark];
				echo $row[percentage];
				echo $row[datetime];
				echo $row[submit];
				echo $row[returned];
				//echo "<form method = 'post'><input type='hidden' name = 'responseid' value = '".$row[id]."'><input type='hidden' name = 'userid' value = '".$row[userID]."'><input type='submit' value = 'Review'></form>";
				//print_r($row);
				
				*/
		
				}
			}
			
			echo "</td>";
			echo "<td>";
			
				$query = "SELECT * FROM saq_saved_work WHERE userID = '".$userid."' AND submit=1 AND assignID = '".$value['id']."'";

        $result = $conn->query($query);
				
				if ($result) {

					if ($result->num_rows== 0) {


// THIS IS WHERE TO CHANGE THE LINK AFTER MAKING CHANGES TO SAQ PAGE
						
						echo "<a href = '../saq/saq1.7.php?assignid=".$value['id']."'>Complete Assignment</a>";
					}
					
					else {
						
						echo "<a href = 'user_saq_review2.0.php'>Review Assignments</a>";
						
					}
				}
			
			
			echo "</td>";
			
			
			
		}
		
		if ($value['type'] == "exercise") {
			
			
			echo "<td><em>Not yet entered</em>";
			echo "</td>";
			echo "<td>";
			echo "</td>";
			
		}
		
		
echo "</tr>";
}

?>

</table>


<?php
/*
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
*/


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