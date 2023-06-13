<?php



$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");


?>

<html>


<head>

<?php include "../header.php";?>

<style>

.answers {
	
	display: none;
	border: 1px solid black;
	padding: 5px;
	margin: 5px;
	background-color: pink;
	
}

.tiny_button {
	font-size: 4px;
	
}


.incorrectReview {
	
	background-color: yellow;
	
}

.correctReview {
	
	background-color: #90EE90;
	
}

</style>


</head>



<body>

<?php include "../navbar.php";


$link = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
			
	die ("The connection could not be established");
}

//echo "Post: ";
//print_r($_POST);
//echo "<br>Get: ";
//print_r($_GET);

$exercisename = "1.2.4 Elasticity Questions 1";

if(isset($_GET['assignid'])) {
  $assignid= $_GET['assignid'];
}

if (isset($assignid)) {

$query = "SELECT id, type FROM assignments WHERE id = '".$assignid."'";

if ($result = mysqli_query($link, $query)) {
	
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	//print_r($row);
	
	if($row[type] != 'exercise') {
		
		die("Error: Incorrect assignment type");
	}
	
}

}


if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
  $userid = $_POST['userid'];
  $name = $_POST['name'];

  $timeStart = $_POST['timestart'];
}

$submitConfirm = 1;
$returnConfirm = 1;


if (isset($assignid) and empty($userid)) {
	echo "<h1>Elasticity Exercises 1: PED Practice</h1>";
	echo "<p>Login required for this assignment</p>";
	include "../login_student_embed.php";
	include "../footer.php";
	die();
}

if (isset($_POST['formSubmit'])) {

		$questionCount = $_POST['questionCount'];

		$recordScore = array();
		$recordScoreMatrix = array();
		$record = array();

		for ($x=0; $x< $questionCount; $x++) {
			
			
			
			$quant1 = mysqli_real_escape_string($link, $_POST['a1_'.$x]);
			$quant2 = mysqli_real_escape_string($link, $_POST['a2_'.$x]);
			$price1 = mysqli_real_escape_string($link, $_POST['a3_'.$x]);
			$price2 = mysqli_real_escape_string($link, $_POST['a4_'.$x]);
			
			$recordData = array($quant1, $quant2, $price1, $price2);
			
			$deltaQuantApparent = ($quant2-$quant1)/$quant1;
			$deltaPriceApparent = ($price2-$price1)/$price1;
			
			$pedCoeff = round(($deltaQuantApparent/$deltaPriceApparent), 2);
			
			$revenue1 = $price1*$quant1;
			$revenue2 = $price2*$quant2;
			
			if ($pedCoeff<-1) {$pedCoeffLabel = "elastic";}
			else if ($pedCoeff>-1) {$pedCoeffLabel = "inelastic";}
			

			
			//echo "<br>";
			//echo "<br>";
			//echo $quant1." ".$quant2." ".$price1." ".$price2." ".$deltaQuantApparent." ".$deltaPriceApparent." ".$pedCoeff." ".$revenue1." ".$revenue2." ".$pedCoeffLabel;
			
			//Responses:
			
			$response1 = mysqli_real_escape_string($link, $_POST['q1_'.$x]);
			$response2 = mysqli_real_escape_string($link, $_POST['q2_'.$x]);
			$response3 = mysqli_real_escape_string($link, $_POST['q3_'.$x]);
			$response4 = mysqli_real_escape_string($link, $_POST['q4_'.$x]);
			
			$recordScoreMatrixInstance = array();
			$recordAnswers = array($response1, $response2, $response3, $response4);
			$recordAnswersData = array($recordAnswers, $recordData);
			array_push($record, $recordAnswersData);
			
			
			if( $response1 >= ($pedCoeff-0.01) && $response1 <= ($pedCoeff+0.01) ) {
				
				array_push($recordScore, 1);
				array_push($recordScoreMatrixInstance, 1);}
			else {
				
				array_push($recordScore, 0);
				array_push($recordScoreMatrixInstance, 0);}
			
			if($response2 == $pedCoeffLabel) {
				
				array_push($recordScore, 1);
				array_push($recordScoreMatrixInstance, 1);}
			else {
				
				array_push($recordScore, 0);
				array_push($recordScoreMatrixInstance, 0);}
			
			if($response3 >= ($revenue1-0.05) && $response3 <= ($revenue1+0.05)) {
				
				array_push($recordScore, 1);
				array_push($recordScoreMatrixInstance, 1);}
			else {
				
				array_push($recordScore, 0);
				array_push($recordScoreMatrixInstance, 0);}
			
			if($response4 >= ($revenue2-0.05) && $response4 <= ($revenue2+0.05)) {
				
				array_push($recordScore, 1);
				array_push($recordScoreMatrixInstance, 1);}
			else {
				
				array_push($recordScore, 0);
				array_push($recordScoreMatrixInstance, 0);}
				
				
			array_push($recordScoreMatrix,$recordScoreMatrixInstance);
			
		}

		//echo "<br>Record Score: ";
		//print_r($recordScore);
		//print_r($recordScoreMatrix);
		//echo json_encode($recordScoreMatrix);
		//echo "<br>";

		$score = array_sum($recordScore);
		$percentage = (array_sum($recordScore)/count($recordScore))*100;

		//echo "Sum: ".array_sum($recordScore);
		//echo "<br>";
		//echo "Count: ".count($recordScore);
		//echo "<br>";
		//echo "Percentage: ".$percentage;
		
		
		//General Submit:




		//$name = $_POST['name'];
		//$record = $_POST['record'];
		//$score = $_POST['score'];
		//$percentage = $_POST['percentage'];
		//$exercisename = $_POST['exercisename'];
		//$timeStart = $_POST['timestart'];


		$timeEnd = date("Y-m-d H:i:s");

		//$assignid = $_POST['assignid'];
		//$userid = $_POST['userid'];
		//$submitConfirm = $_POST['submit'];
		//$returnConfirm = $_POST['return'];

		$record = json_encode($record);

		//echo "<br>";
		//echo $record;


		

		$query = "INSERT INTO `exercise_responses` (`name`, `answers`, `mark`, `percentage`, `exerciseName`, `exerciseID`,`timeStart`, `datetime`, `assignID`, `userID`, `submit`, `returned`) VALUES ('$name', '$record', '$score', '$percentage', '$exercisename', '$exerciseID', '$timeStart', '$timeEnd', '$assignid', '$userid', '$submitConfirm', '$returnConfirm')";



		// This element is added to ensure that  the same completed assignment is not submitted twice

		$query2 = "SELECT * FROM exercise_responses WHERE userID='".$userid."' AND timeStart='".$timeStart."'";

		$result = mysqli_query($link, $query2);

		$row = mysqli_fetch_array($result,  MYSQLI_ASSOC);

		$timeEnd2 = $row['datetime'];



		if ((mysqli_num_rows($result) == 0) and ($userid != 0) ) {
			
			//This line submits the result to responses:

			mysqli_query($link, $query);
		}

		else {
			
			if ($userid == 0 ) {
				
				echo "<p style = 'background-color: pink;'>You must log in before a result can be submitted.</p>";
			}
			
			echo "<p style = 'background-color: pink;'>Note: This form has already been submitted and score recorded ".$timeEnd2.".</p>";
		}

		
		
		//Feedback Section
		
		echo "<h1>Elasticity Exercises 1: Feecback</h1>";
		echo "<p>Your score: ".$score."/".count($recordScore)."</p>";
		echo "<p>Percentage: ".$percentage."%</p>";
		
		echo "<ol>";
		
		for ($x=0; $x< $questionCount; $x++) {
			
			
			$quant1 = $_POST['a1_'.$x];
			$quant2 = $_POST['a2_'.$x];
			$price1 = $_POST['a3_'.$x];
			$price2 = $_POST['a4_'.$x];
			
			$recordData = array($quant1, $quant2, $price1, $price2);
			
			$deltaQuantApparent = ($quant2-$quant1)/$quant1;
			$deltaPriceApparent = ($price2-$price1)/$price1;
			
			$pedCoeff = round(($deltaQuantApparent/$deltaPriceApparent), 2);
			
			$revenue1 = $price1*$quant1;
			$revenue2 = $price2*$quant2;
			
			if ($pedCoeff<-1) {$pedCoeffLabel = "elastic";}
			else if ($pedCoeff>-1) {$pedCoeffLabel = "inelastic";}
			
		
			//Responses:
			
			$response1 = $_POST['q1_'.$x];
			$response2 = $_POST['q2_'.$x];
			$response3 = $_POST['q3_'.$x];
			$response4 = $_POST['q4_'.$x];
			
				
			echo "<li>Price changes from &pound".$price1." to &pound".$price2.". Quantity Demanded chagnes from ".$quant1." to ".$quant2.".";
			
			echo "<ol type ='A'>";
			echo "<li><p>What is PED?</p> </li>";
			echo "<div>";
			
				
			if($recordScoreMatrix[$x][0] == 1) {
				echo "<p class='correctReview'>Your response: ".$response1."</p> ";
			}
				
			
			
			if($recordScoreMatrix[$x][0] == 0) {
				echo "<div class='incorrectReview'>";

					if(!empty($response1)) {
						echo "<p>Your response: ".$response1."</p> ";
					}
			
				echo"<p>Correct answer: </p><p>PED = (&percnt; change in Qd) / (&percnt; change in Price)</p><p>= ( ( ".$quant2." - ".$quant1." ) / ".$quant1." ) / ( ( &pound;".$price2." - &pound;".$price1." ) / &pound;".$price1." )</p><p>= ".round($deltaQuantApparent*100)."&percnt; / ".round($deltaPriceApparent*100)."&percnt; = ".$pedCoeff."</p></div>";
			
				}
			echo "</div>";
			
			echo "<li><p>Is this elastic or inelastic?<p></li>";
			echo "<div>";
			 
				
			if($recordScoreMatrix[$x][1] == 1) {
				echo "<p class='correctReview'>Your response: ".$response2."</p> ";
				}
				
			
			
			if($recordScoreMatrix[$x][1] == 0) {
				echo "<div class='incorrectReview'>";
					if(!empty($response2)) {
						echo "<p>Your response: ".$response2."</p>";
						
					}
			
				echo"<p>Correct answer: ".$pedCoeffLabel."</p></div>";
			
				}
			
			echo "</div>";
			
			echo "<li>What was the firm's revenue before the price change?</li>";
			echo "<div>";
			 
				
			if($recordScoreMatrix[$x][2] == 1) {
				echo "<p class='correctReview'>Your response: &pound;".$response3."</p> ";			
			}
			
			if($recordScoreMatrix[$x][2] == 0) {
				echo "<div class='incorrectReview'>";
				if(!empty($response3)) {
					echo "<p>Your response: &pound;".$response3."</p>";
				}
				
				echo"<p>Correct answer: </p><p>Revenue = Price X Quantity</p><p>= &pound;".$price1." X ".$quant1."</p><p>= &pound;".$revenue1."</p></div>";
				
			}
			echo "</div>";
			
			echo "<li>What was the firm's revenue after the price change?</li>";
			echo "<div>"; 
			
			
				
			if($recordScoreMatrix[$x][3] == 1) {
				echo "<p class='correctReview'>Your response: &pound;".$response4."</p> ";				
				
				}
			
			
			
			if($recordScoreMatrix[$x][3] == 0) {
				echo "<div class='incorrectReview'>";
				if(!empty($response4)) {
					echo "<p>Your response: &pound;".$response4."</p>";
						
				}
					
				echo"<p>Correct answer: </p><p>Revenue = Price X Quantity</p><p>= &pound;".$price2." X ".$quant2."</p><p>= &pound;".$revenue2."</p></div>";
				
			}
			echo "</div>";
			
		echo "</ol>";	
		echo "</li>";
		}
		
		echo "</ol>";
		echo "<a href = '1.2.4ped_exercise1.2.php?assignid=".$assignid."'>Click here to try again</a>";
		
		include "../footer.php";
		
				
		die();
}
?>

<h1>Elasticity Exercises 1: PED Practice</h1>

<form method="post" id = "myForm" >
<!-- action = "1.2.4ped_exercise1.0_submit.php" -->
<input type = "hidden" name ="questionCount" id="questionCount">
<input type = "hidden" name="userid" value = "<?php echo $userid; ?>">
<input type = "hidden" name="assignid" value = "<?php echo $assignid; ?>">
<input type = "hidden" name="name" value = "<?php echo $_POST['name']; ?>">
<input type = "hidden" name="timestart" value = "<?php echo date("Y-m-d H:i:s"); ?>">
<!--
<input type = "hidden" name="record" value = "<?php json_encode($record); ?>">
<input type = "hidden" name="score" value = "<?php echo $score; ?>">
<input type = "hidden" name="percentage" value = "<?php echo $percentage; ?>">
-->
<input type = "hidden" name="exercisename" value = "<?php echo $exercisename; ?>">
<input type = "hidden" name="submit" value = "<?php echo $submitConfirm; ?>">
<input type = "hidden" name="return" value = "<?php echo $returnConfirm; ?>">
<input type = "hidden" name="formSubmit" value = "1">

<ol>
<div id="questionsDiv"></div>
</ol>



<?php
if (isset($assignid)) {
//echo "<input type='submit' value = 'submit'>";
echo "<button onclick = 'submitForm()'>Submit</button>";
//type='submit'
//echo "<input type='submit' id = 'submit' value = 'Submit' onclick = 'submitForm()'>";
echo "<script>
function submitForm() {
	//alert('this works');
	document.getElementById('myForm').submit();
	
	
}
</script>";
}
?>


<?php

/*
if (isset($assignid)) {
echo "
<input type='submit'>
";}
*/
?>
</form>

<?php include "../footer.php";





?>



<script>



<?php   if(isset($_POST['questionCount'])) {
			
			
			$postIndex = array();
			
			for ($x=0; $x< $questionCount; $x++) {
				
				$subArray = array();
				
				array_push($subArray, $_POST['a1_'.$x], $_POST['a2_'.$x], $_POST['a3_'.$x], $_POST['a4_'.$x]);

				array_push($postIndex, $subArray);
				
				
			}
			
			
			//echo "/*";
			//print_r($postIndex);
			echo "var postValues = ".json_encode($postIndex).";";
			//echo "*/";
			
		}

		?>

/*
index[i] follows the format:
[quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no]

index follows the following format:
D1: Different questions
D2: [quanity, price, detlaQuant, deltaPrice]
D3: [min, max, step]


[ [45,60,5], [9,13,1], [-.45,-.25,0.05], [0,.25,.05]],

*/

var index = [
				[ [45,60,5], [9,13,1], [-.45,-.25,0.05], [0,.25,.05]],
				[ [40,70,10], [12,17,1], [.25, .45,.05], [-.25,0,0.05]],
				[ [70,80,2], [20,35,5], [-.25,0,.05], [0.25,.5,0.05]],
				[ [55,65,2], [15,25,1], [0,.25,.05], [-.5, -.25,0.05]]

];

var pedValues = [];

function randomGen(min, max, step) {

	return Math.round(
	(
	Math.floor(Math.random()*((max-min)/step +1))*step+min
	)
	*1000)/1000;

}

function round(number,dpNo) {

	return Math.round(number*(10**dpNo))/(10**dpNo);

}



function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function negate(i) {
	
	var inputvalue = document.getElementById(i).value;
	document.getElementById(i).value = inputvalue*-1
}


function toggleAnswer(i) {
	
	var div = document.getElementById("answers_"+i);
	var button = document.getElementById("button_"+i);
	
	if (button.innerHTML == "Show Answers") {
		div.style.display="block";
		button.innerHTML = "Hide Answers";
		
	}
	
	else if (button.innerHTML == "Hide Answers") {
		
		div.style.display="none";
		button.innerHTML = "Show Answers";
		
	}
	
	//alert ("This works "+i);
	
	
	
}

var questionsDiv = document.getElementById("questionsDiv");


document.getElementById("questionCount").value= index.length

for(var i=0; i<index.length; i++) {
	
	
	var div = document.createElement("div");
	div.setAttribute("id", "question_div_"+i);
	
	var question = document.createElement("li");
	question.innerHTML = "Price <span id='qElement_"+i+"_0'></span> from &#163<span id='qElement_"+i+"_1'></span> to &#163<span id='qElement_"+i+"_2'></span>. Quantity Demanded <span id='qElement_"+i+"_3'></span> from <span id='qElement_"+i+"_4'></span> to <span id='qElement_"+i+"_5'></span>";
	
	var div2 =  document.createElement("div");
		
		var list = document.createElement("ol");
		list.setAttribute("type", "A");
		var listItem = document.createElement("li");
		var label = document.createElement("label");
		label.setAttribute("for", "q1_"+i);
		label.innerHTML = "What is the PED?";
		var br = document.createElement("br");
		var input = document.createElement("input");
		input.setAttribute("type", "text");
		input.setAttribute("step", ".01");
		input.setAttribute("id", "q1_"+i);
		input.setAttribute("name", "q1_"+i);
		var button = document.createElement("button");
		button.setAttribute("onclick", "negate('q1_"+i+"')");
		button.setAttribute("type", "button");
		button.innerHTML = "click to make PED input negative";
		button.classList.add("tiny_button")
		
			
		
		
		listItem.appendChild(label);
		
		<?php
		if (isset($assignid)) {
		echo "
		listItem.appendChild(br);
		listItem.appendChild(input);
		//listItem.appendChild(button);
		";}
		?>
		
		list.appendChild(listItem);
		
		var listItem = document.createElement("li");
		listItem.innerHTML = "Is this elastic or inelastic?";
		var br = document.createElement("br");
		var input = document.createElement("input");
		input.setAttribute("type", "radio");
		input.setAttribute("id", "q2_1_"+i);
		input.setAttribute("name", "q2_"+i);
		input.setAttribute("value", "elastic");
		var label = document.createElement("label");
		label.setAttribute("for", "q2_1_"+i);
		label.innerHTML = "Elastic";
		
		var br2 = document.createElement("br");
		var input2 = document.createElement("input");
		input2.setAttribute("type", "radio");
		input2.setAttribute("id", "q2_2_"+i);
		input2.setAttribute("name", "q2_"+i);
		input2.setAttribute("value", "inelastic");
		var label2 = document.createElement("label");
		label2.setAttribute("for", "q2_2_"+i);
		label2.innerHTML = "Inelastic";
		
		<?php
		if (isset($assignid)) {
		echo "
		listItem.appendChild(br);
		listItem.appendChild(input);
		listItem.appendChild(label);
		listItem.appendChild(br2);
		listItem.appendChild(input2);
		listItem.appendChild(label2);
		";}
		?>
		list.appendChild(listItem);
		
		var listItem = document.createElement("li");
		var label = document.createElement("label");
		label.setAttribute("for", "q3_"+i);
		label.innerHTML = "What was the firm's revenue before the price change?";
		var br = document.createElement("br");
		var span = document.createElement("span");
		span.innerHTML = "&pound; "
		var input = document.createElement("input");
		input.setAttribute("type", "number");
		input.setAttribute("step", ".01");
		input.setAttribute("id", "q3_"+i);
		input.setAttribute("name", "q3_"+i);
		
		listItem.appendChild(label);
		<?php
		if (isset($assignid)) {
		echo "
		listItem.appendChild(br);
		listItem.appendChild(span);
		listItem.appendChild(input);
		";}
		?>
		list.appendChild(listItem);
		
		var listItem = document.createElement("li");
		var label = document.createElement("label");
		label.setAttribute("for", "q4_"+i);
		label.innerHTML = "What is the firm's revenue after the price change?";
		var br = document.createElement("br");
		var span = document.createElement("span");
		span.innerHTML = "&pound; "
		var input = document.createElement("input");
		input.setAttribute("type", "number");
		input.setAttribute("step", ".01");
		input.setAttribute("id", "q4_"+i);
		input.setAttribute("name", "q4_"+i);
		
		listItem.appendChild(label);
		<?php
		if (isset($assignid)) {
		echo "
		listItem.appendChild(br);
		listItem.appendChild(span);
		listItem.appendChild(input);
		";}
		?>
		list.appendChild(listItem);
		
		
		div2.appendChild(list);
	//var div3 =  document.createElement("div");
	//div3.innerHTML = "<ol type='A'><li><label for='q1_"+i+"'>What is the PED?</label><br><input type='number' step='.01' id='q1_"+i+"' name='q1_"+i+"'></li><li>Is this elastic or inelastic?<br><input type='radio' id='q2_1_"+i+"' name='q2_"+i+"' value='elastic'><label for='q2_1_"+i+"'>Elastic</label><br><input type='radio' id='q2_2_"+i+"' name='q2_"+i+"' value='inelastic'><label for='q2_2_"+i+"'>Inelastic</label></li><li><label for='q3_"+i+"'>What was the firm's revenue before the price change?</label><br>&pound; <input type='number' step='.01' id='q3_"+i+"' name='q3_"+i+"'></li><li><label for='q4_"+i+"'>What is the firm's revenue after the price change?</label><br>&pound; <input type='number' step='.01' id='q4_"+i+"' name='q4_"+i+"'></li></ol>";
	
	
	var answerForm = document.createElement("p");
	answerForm.setAttribute("id", "answerForm_"+i);
	
	var button = document.createElement("button");
	button.setAttribute("onclick", "toggleAnswer("+i+")");
	button.setAttribute("type", "button");
	button.setAttribute("id", "button_"+i);
	button.innerHTML="Show Answers";
	
	var answers = document.createElement("div");
	answers.setAttribute("id", "answers_"+i);
	answers.setAttribute("class", "answers");
	
	div.appendChild(question);
	div.appendChild(div2);
	//div.appendChild(div3);
	div.appendChild(answerForm);
	
	<?php
	if (!isset($assignid)) {
	echo "
	div.appendChild(button);
	";}
	?>
	div.appendChild(answers);
	
	questionsDiv.appendChild(div);
	
	
	
	var span = [
		document.getElementById('qElement_'+i+'_0'),
		document.getElementById('qElement_'+i+'_1'),
		document.getElementById('qElement_'+i+'_2'),
		document.getElementById('qElement_'+i+'_3'),
		document.getElementById('qElement_'+i+'_4'),
		document.getElementById('qElement_'+i+'_5')
		]
	
	
	do {
		var price1 = randomGen(index[i][1][0], index[i][1][1], index[i][1][2]);
		var quant1 = randomGen(index[i][0][0], index[i][0][1], index[i][0][2]);
		var deltaQuant = randomGen(index[i][2][0], index[i][2][1], index[i][2][2]);
		var deltaPrice = randomGen(index[i][3][0], index[i][3][1], index[i][3][2]);
		
				
		var price2 = round((price1*(1+deltaPrice)), 2);
		var quant2 = round((quant1*(1+deltaQuant)), 2);
		
		<?php   if(isset($_POST['questionCount'])) {
			
			echo "quant1 = parseFloat(postValues[i][0]);
			quant2 = parseFloat(postValues[i][1]);
			price1 = parseFloat(postValues[i][2]);
			price2 = parseFloat(postValues[i][3]);
			";
			
			
			
		}


		?>
		
		var deltaQuantApparent = (quant2-quant1)/quant1;
		var deltaPriceApparent = (price2-price1)/price1;
		
	
		
		var pedCoeff = round((deltaQuantApparent/deltaPriceApparent), 2);
		//var pedCoeff = (deltaQuantApparent/deltaPriceApparent);
		var pedCoeffRound = round((round(deltaQuantApparent, 2)/round(deltaPriceApparent,2)), 2);
		
		
		
		var revenue1 = price1*quant1;
		var revenue2 = price2*quant2;
		
		
		var pedCoeffLabel;
		
		if (pedCoeff<-1) {pedCoeffLabel = "elastic"}
		else if (pedCoeff>-1) {pedCoeffLabel = "inelastic"}
		
		
		
		var priceDirection;
		var quantDirection;
		
		if (price2 > price1) {priceDirection = "rises"}
		else if (price2 < price1) {priceDirection = "falls"}
		
		if (quant2 > quant1) {quantDirection = "rises"}
		else if (quant2 < quant1) {quantDirection = "falls"}
		
		
	}
	
	while (
		
		(deltaQuant*deltaPrice>0)||
		(deltaQuant ==0)||
		(deltaPrice ==0)||
		
		(price1==price2)||
		(quant1==quant2)||
		(revenue1 == revenue2)||
		
		(round(pedCoeff,1) == -1)||
		
		//((pedCoeff[0]>-1.1)&&(pedCoeff[0]<-0.9)&&(deltaQuant[0]>.25))||
		
		((pedCoeff<-1)&&(price1<price2)&&(revenue1<revenue2))||
		((pedCoeff<-1)&&(price1>price2)&&(revenue1>revenue2))||
		((pedCoeff>-1)&&(price1<price2)&&(revenue1>revenue2))||
		((pedCoeff>-1)&&(price1>price2)&&(revenue1<revenue2))||
		
		(pedCoeff < -3) ||
		(pedCoeff !== pedCoeffRound) ||
		
		(pedValues.includes(pedCoeff) == true)
		
	)
	
	pedValues.push(pedCoeff);
	
	span[0].innerHTML = priceDirection;
	span[1].innerHTML = price1;
	span[2].innerHTML = price2;
	span[3].innerHTML = quantDirection;
	span[4].innerHTML = quant1;
	span[5].innerHTML = quant2;
	
	document.getElementById("answerForm_"+i).innerHTML = "<input type='number' name = 'a1_"+i+"' value='"+quant1+"'><input type='text' name = 'a2_"+i+"'  value='"+quant2+"'><input type='number' name = 'a3_"+i+"'  value='"+price1+"'><input type='number' name = 'a4_"+i+"'  value='"+price2+"'>";
	document.getElementById("answerForm_"+i).style.display = "none";
	
	
	<?php
	if (!isset($assignid)) {
	echo '
	document.getElementById("answers_"+i).innerHTML = "PED: "+pedCoeff + "<br> PED is "+pedCoeffLabel +"<br>Revenue 1= &#163 "+ round(revenue1,2) +"<br>Revenue 2 = &#163 "+ round(revenue2, 2);
	
	';}
	?>
	
	
	
	
	//pedCoeff+" / "+pedCoeffLabel+" / "+deltaQuantApparent+" / "+deltaPriceApparent+" / "+revenue1+" / "+revenue2;
	
}

console.log(pedValues);
</script>

</body>

</html>