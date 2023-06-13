<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include($path."/php_header.php");
  $link = mysqli_connect($servername, $username, $password, $dbname);

  if (mysqli_connect_error()) {
    
    die ("The connection could not be established");
  }

?>

<html>
<?php include "../header.php"; ?>
<head>

<style>

.answer {
	
	background-color: yellow;
}

h2 {
	border-top: 1px solid black;
}

</style>



</head>




<body onload="populate()">
<?php include "../navbar.php"; ?>

<h1>Multiple Choice Questions Preview: <span id="nameOfQuiz"></span></h1>



<form method="get">
<label for ="quizid">Search by Quiz:</label>
<select name="quizid">;
<?php 



$query = "SELECT * FROM mcq_quizzes";

if ($result = mysqli_query($link, $query)) {	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo "<option value = '".$row[id]."'>".$row[quizName]." (id".$row[id].")</option>";
	}
}
?>
</select>
<input type="submit" value ="Submit">
</form>


<form method="get">
<label for ="quizid">Search by Assignment:</label>
<select name="assignid">;
<?php 



//In future it may be an idea to change the below to select only on condition, e.g. relevant = 1

$query = "SELECT * FROM assignments WHERE type = 'mcq'";

if ($result = mysqli_query($link, $query)) {	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo "<option value = '".$row[id]."'>".$row[assignName]." (id".$row[id].")</option>";
	}
}
?>
</select>
<input type="submit" value ="Submit">
</form>

<input type ="radio" name ="answersDisplay" id ="answersOn" checked onclick="answerChange()">
<label for="answersOn">Show Answers</label>
<input type ="radio" name ="answersDisplay" id ="answersOff" onclick="answerChange()">
<label for="answersOff">Hide Answers</label>

<?php //echo var_dump($_GET); ?>

<!--
<h1>Multiple Choice Questions: <span id="nameOfQuiz"></span></h1>

<p>Name: <?php //echo $_POST['name'];?></p>


<form id="myForm" method="post" action="mcq2.1_submit.php" style="display: none ;">
<p>Name: <input type = "text" name ="name" id = "name" style="" value="<?php echo $_POST['name'];?>"> </p>
<input type = "text" name ="record" id = "f1" style="display:none;" >
<input type = "text" name ="quizname" id = "f2" style="display: none;" >
<input type = "text" name ="email" value ="<?php echo $_POST['email'];?>" style="display: none;" >
<input type = "text" name ="startTime" value = "<?php echo date("Y-m-d H:i:s") ?>" style="display:;">
<input type = "text" name ="assignid" value ="<?php echo $_POST['assignid'];?>" style="display: ;" >
<input type = "text" name ="userid" value ="<?php echo $_POST['userid'];?>" style="display: ;" >

<input type = "text" name ="reviewQ" id = "reviewInput" style="display: ;" >
<input type = "text" name ="multi" id = "multiInput" style="display: ;" >

</form>
-->

<div id="questions">

</div>



	


<?php include "../footer.php"; ?>



</body>

<script>



<?php 


/*
This section retreives question data from 
Database: thinkeco_data »Table: mcq_quizzes
Database: thinkeco_data »Table: assignments
*/



$quizid = $_GET['quizid'];

//Calling variables from assignments

$assignid = $_GET['assignid'];

$query = "SELECT * FROM assignments WHERE id='".$assignid."' AND type = 'mcq'";

if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		

		//print_r($row);
	
		$quizid = $row[quizid];
		$quizName = ($row[assignName]);
		$groupid= $row[groupid];
		$review = $row[reviewQs];
		$multi = $row[multiSubmit];
		
		
		}

				
	}

//echo $quizid.$quizName.$groupid.$review.$multi;

//Calling variables from mcq_quizzes:



$query = "SELECT * FROM mcq_quizzes WHERE id='".$quizid."'";

if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		

		//print_r($row);
		if (empty($quizName) != false) {
			$quizName= ($row[quizName]);}
		$questions = ($row[questions]);
		$notes = ($row[notes]);
		//$reviewQs = ($row[reviewQs]);
		
		}

				
	}	
	
echo "var quizName = '".$quizName."'";
echo ';
//'.$notes.';
';


$questions = '['.$questions.']';
$questions = json_decode($questions);

$arrlength = count($questions);


$index = array();

// $index is 2D array that contains question name and answers
// $index2 is used to create $index 1, a 1D array that contains the question name and answer for each x in the below for statement.
//$questions2 formats the numbers to include those on all six digits e.g. 1201.090610

for($x = 0; $x < $arrlength; $x++) {
	$index2 = array();
	$questions2 = number_format($questions[$x], 6, '.', '');
	
	/*!!! Below is the question bank that must be updated to included most recent questions*/
	
	$query = "SELECT * FROM question_bank_3 WHERE No='".$questions2."'";
	
	
if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		
		array_push($index2, $questions2);
		array_push($index2, $row[Answer]);
		}
	}
	
	array_push($index, $index2);
	
}	

//print_r($index);

echo 'var index = '.json_encode($index);



?>




/*

var question_no = 0;

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
		
	document.getElementById("nameOfQuiz").innerHTML = quizName;
	var div = document.getElementById("questions");
	var totalQuestions = index.length;
	
	for(var i=0; i<index.length; i++) {
		
		var heading = document.createElement("h2");
		heading.innerHTML= "Question "+(i+1)+"/"+totalQuestions;
		var questionName = document.createElement("p");
		questionName.innerHTML = "<em>"+index[i][0]+"</em>";
		var question = document.createElement("img");
		
		var bigjpg = (index[i][0])+".JPG";
		var smljpg = (index[i][0])+".jpg";
	
		if (typeof bigjpg != "undefined") {
		
		question.setAttribute("src", "question_img/"+bigjpg);
		
		}else if (typeof smljpg != "undefined") {
		
		question.setAttribute("src", "question_img/"+smljpg);
		}
		
		var answer = document.createElement("p");
		answer.innerHTML = "Answer: "+index[i][1];
		answer.setAttribute("class", "answer");
	
		
		
		
		
		
		div.appendChild(heading);
		div.appendChild(questionName);
		div.appendChild(question);
		div.appendChild(answer);
		
		
		
	}
	

	
	
}

var showAnswers = 1;

function answerChange() {
	
	var answers = document.getElementsByClassName("answer");
	
	if (showAnswers==1) { 
	
		for(var i=0; i<answers.length; i++) {
			answers[i].style.display = "none";
			
		}
		showAnswers = 0;
		console.log(showAnswers);
	}
	
	else if (showAnswers==0) { 
	
		for(var i=0; i<answers.length; i++) {
			answers[i].style.display = "block";
			
		}
		showAnswers = 1;
		console.log(showAnswers);
	}
	
}

/*
var div = document.getElementById("d1");

	load_q();


for(var i=0; i<index.length; i++)	{
	
	var a = document.createElement("p");
	a.innerHTML = index[i].toFixed(6);
	
	
	div.appendChild(a);
	var button = [[],[],[],[],[]]
	for(var j=0; j<button.length; j++) {
		button[j] = document.createElement("input");
		button[j].setAttribute("type", "radio");
		button[j].setAttribute("id", "a_"+i+"_"+j);
		button[j].setAttribute("name", "a_"+i);
		div.appendChild(button[j]);
		}
		
	}
*/	
//document.getElementById("q2").innerHTML= index.length;
//document.getElementById("q3").innerHTML= index.length;

/*
previous_id.disabled = true;
previous_id2.disabled = true;
	
}

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
	*/
	/*
	var i;
	for (i=0; i<ans.length; i++) {
	ans[i].checked=false;
	}
	
	
	if (record[question_no][2] != "" || record[question_no][2] == "0") {
		ans[record[question_no][2]].checked =true;
	}
	*/
	/*
	var question = document.getElementById("question");
	
	var bigjpg = (index[question_no]).toFixed(6)+".JPG";
	var smljpg = (index[question_no]).toFixed(6)+".jpg";
	
	if (typeof bigjpg != "undefined") {
		
		question.setAttribute("src", "question_img/"+bigjpg);
		
	}else if (typeof smljpg != "undefined") {
		
		question.setAttribute("src", "question_img/"+smljpg);
	}
	*/
	/*
	question.setAttribute("src", "question_img/"+(index[question_no][0]).toFixed(6)+".jpg");
	
	*/
	/*
	var div = document.getElementById("d1");
	div.innerHTML ="";
	//var button = [[],[],[],[],[]];
	//var label = [[],[],[],[],[]]
	var abcde = ["A", "B", "C", "D", "E"];
	
	/*
	!!! This is where you can update the number of MCQ options that are given to the user. Use examBoardOptions array.
	
	*/
	/*
	var optionsNumber;
	var examBoardOptions = [["10",5],["11", 5],["12",4]]
	
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
		label.innerHTML = abcde[j];
		
		if(record2[question_no][1]==abcde[j]) {
			button.checked = true;
		}
		
		div.appendChild(button);
		div.appendChild(label);

		var br = document.createElement("br");
		div.appendChild(br);
	}
	*/
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
		/*
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
	*/

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
				/*
				record = JSON.stringify(record2);
				console.log(record);
				document.getElementById("f1").value = record;
				document.getElementById("f2").value = quizName;
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
*/
</script>

</html>