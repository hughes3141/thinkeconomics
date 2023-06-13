<?php

  // Initialize the session
  session_start();

  $_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

  $path = $_SERVER['DOCUMENT_ROOT'];
  include($path."/php_header.php");
  include($path."/php_functions.php");

  if (!isset($_SESSION['userid'])) {
    
    //header("location: /login.php");
    
  }

  
  /*
  else {
    $userInfo = getUserInfo($_SESSION['userid']);
    $userType = $userInfo['usertype'];
    if (!($userType == "teacher" || $userType =="admin")) {
      header("location: /index.php");
    }
  }
  */


?>

<html>


<head>

<?php include "../header.php";

/*
This resource created 27 October 2021

It is based off 1.2.4ped_exercise1.2.php

This exercise is designed to use self-generated data have students practice, in the style of examination quesitons that are used in a resource titled "PED Exercises 3"



*/

$exercisename = "1.2.4 Elasticity Exercises 2";


?>

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



function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

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
	echo "<h1>".$exercisename."</h1>";
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
			//$response2 = mysqli_real_escape_string($link, $_POST['q2_'.$x]);
			//$response3 = mysqli_real_escape_string($link, $_POST['q3_'.$x]);
			//$response4 = mysqli_real_escape_string($link, $_POST['q4_'.$x]);
			
			$recordScoreMatrixInstance = array();
			$recordAnswers = array($response1, $response2, $response3, $response4);
			$recordAnswersData = array($recordAnswers, $recordData);
			array_push($record, $recordAnswersData);
			
			
// HERE IS WHERE TO CHANGE MARK SCHEME TO REFLECT CHANGES TO QUESTIONS

			if ($x == 0) {
				
				if( $response1 >= ($pedCoeff-0.01) && $response1 <= ($pedCoeff+0.01) ) {
				
					array_push($recordScore, 1);
					array_push($recordScoreMatrixInstance, 1);}
				else {
				
					array_push($recordScore, 0);
					array_push($recordScoreMatrixInstance, 0);}
				
				
				
			}
			
			if ($x == 1) {
				
				$response1 = clean($response1);
				echo $response1;
				
				if($response1 >= ($revenue2-1) && $response1 <= ($revenue2+1))  {
				
					array_push($recordScore, 1);
					array_push($recordScoreMatrixInstance, 1);}
				else {
				
					array_push($recordScore, 0);
					array_push($recordScoreMatrixInstance, 0);}
				
				
				
			}
			
			if ($x == 2) {
				
				if( $response1 >= ($pedCoeff-0.01) && $response1 <= ($pedCoeff+0.01) ) {
				
					array_push($recordScore, 1);
					array_push($recordScoreMatrixInstance, 1);}
				else {
				
					array_push($recordScore, 0);
					array_push($recordScoreMatrixInstance, 0);}
				
				
				
			}
			
		}
			
			
			/*
			
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
		
		*/

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
		
		echo "<h1>Elasticity Exercises 2: Feecback</h1>";
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
					
					
					echo "<li>";
// HERE IS WHERE TO CHANGE FEEDBACK TO REFLECT QUESTIONS

					if ($x == 0) {
						echo "Your answer: ".$response1;
						echo "<br>";
						echo "Correct answer: ".$pedCoeff;
						echo "<br>";
				
					}
					
					if ($x == 1) {
						echo "Your answer: ".$response1;
						echo "<br>";
						echo "Correct answer: ".$revenue2;
						echo "<br>";
				
					}
					
					if ($x == 2) {
						echo "Your answer: ".$response1;
						echo "<br>";
						echo "Correct answer: ".$pedCoeff;
						echo "<br>";
				
					}
			
			echo "</li>";
			
			
			
		}
		echo "</ol>";
		
		/*
		
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
		*/
		echo "<a href = '".pathinfo(__FILE__)['filename'].".php?assignid=".$assignid."'>Click here to try again</a>";
		
		include "../footer.php";
		
				
		die();
}
?>

<h1><?php echo $exercisename;?></h1>
<p></p>




<form method="post" id = "myForm">

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
<input type = "hidden" name="submitState" value = "<?php echo $submitConfirm; ?>">
<input type = "hidden" name="return" value = "<?php echo $returnConfirm; ?>">
<input type = "hidden" name="formSubmit" value = "1">

<ol>
<div id="questionsDiv">

</div>
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
				[ [20,25,1], [5,7,1], [-.2,-.1,0.05], [.2,.3,.05]],
				[ [5000,5500,100], [10,10,1], [.2, .4,.05], [-.2,-.05,0.05]],
				[ [100,100,2], [50,50,5], [-.2,-.1,.05], [0.2,.4,0.05]],
				[ [55,65,2], [15,25,1], [0,.25,.05], [-.5, -.25,0.05]]

];


/*

/////TO CHANGE THE QUESTIONS \\\\\\\\\\

1. Insure index (above) gives desired random variables
2. Change indexQuestions (below) for new quesitons.
3. Change indexAnswers (below) for new explanations.

4. Change PHP mark scheme (above) to reflect answers.
5. Change PHP feedback (above) to reflect answers.
6. Change $exercisename to reflect new name.

Enter in questions in questionIndex.
Use the following span classes to generate random numbers for the following variables:

"price1"
"price2"
"quant1"
"quant2"
"revenue1"
"revenue2"
"pedCoeff"
"deltaQuant"
"deltaPrice"
"pedCoeffLabel"
"priceDirection"
"quantDirection"


*/

var questionIndex = [

"A firm <span class='priceDirection'></span> the price of its product from &pound;<span class='price1'></span> to &pound;<span class='price2'></span>. As a result, revenue for this product rises from &pound;<span class='revenue1'></span> to &pound;<span class='revenue2'></span>. What is the PED for this product? ",

"A product has a PED of <span class='pedCoeff'></span>. Suppose that the price is currently &pound;<span class='price1'></span> per unit, and sales are <span class='quant1'></span> per week. If the price <span class='priceDirection'></span> to &pound;<span class='price2'></span> per unit, what will be the new revenue earned from this product?",

"When the price of a product <span class='priceDirection'></span> from &pound;<span class='price1'></span> to &pound;<span class='price2'></span>, the quantity demanded <span class='quantDirection'></span> from <span class='quant1'></span>m units to <span class='quant2'></span>m units. What is the PED for this product?"




];

/*

The above questions are taken from Eduqas MCQs.

Full information is given beow:

1.	A firm increases the price of its product from £5 to £7. As a result, revenue for this product rises from £100 to £112. What is the PED for this product? (101.170603)
2.	A product has a PED of -1.5. Suppose that the price is currently £10 per unit, and sales are 500 per week. If the price rises to £12 per unit, what will be the new revenue earned from this product? (101.180602)
3.	Suppose an individual’s monthly income rises from £800 to £1000. As a result, the weekly spending on a product falls from 10 units per week to 9. What is the YED for this product? (101.180620)
4.	The PES for a product is +0.5. The price for the product changes from £2.00 to £2.40. What will be the percentage change in quantity supplied for this product as a result of the change? (101.190602)
5.	When the price of a product falls from £90 to £72, the quantity demanded increases from 5m units to 5.75m units. What is the PED for this product? (0201.160610)


*/

var answerIndex = [

"Revenue = P x Q, so Q = Revenue / P<br>New Revenue = &pound;<span class='revenue2'></span>; New Quantity = &pound;<span class='revenue2'></span> / &pound;<span class='price2'></span> = <span class='quant2'></span><br>Old Revenue = &pound;<span class='revenue1'></span>; Old Quantity = &pound;<span class='revenue1'></span> / &pound;<span class='price1'></span> = <span class='quant1'></span><br>&percnt; change Qd = (<span class='quant2'></span>-<span class='quant1'></span>) / <span class='quant1'></span> = <span class='deltaQuant'></span><br>&percnt; change P = (&pound;<span class='price2'></span>-&pound;<span class='price1'></span>) / &pound;<span class='price1'></span> = <span class='deltaPrice'></span><br>PED = &percnt;&Delta;Qd / &percnt;&Delta;Price = <span class='deltaQuant'></span> / <span class='deltaPrice'></span> = <span class='pedCoeff'></span>",

"&percnt;&Delta;Qd = PED x &percnt;&Delta;Price = <span class='pedCoeff'></span> x <span class='deltaPrice'></span> = <span class='deltaQuant'></span><br>New Quantity = Old Quantity <span class='quantDirection'></span> by <span class= 'deltaQuant'></span> = <span class='quant1'></span> <span class='quantDirection'></span> by <span class= 'deltaQuant'></span> = <span class='quant2'></span><br>Revenue = Price x Quantity = &pound;<span class='price2'></span> x <span class='quant2'></span> = &pound;<span class='revenue2'></span>",

"&percnt; change Qd = (<span class='quant2'></span>-<span class='quant1'></span>) / <span class='quant1'></span> = <span class='deltaQuant'></span><br>&percnt; change P = (&pound;<span class='price2'></span>-&pound;<span class='price1'></span>) / &pound;<span class='price1'></span> = <span class='deltaPrice'></span><br>PED = &percnt;&Delta;Qd / &percnt;&Delta;Price = <span class='deltaQuant'></span> / <span class='deltaPrice'></span> = <span class='pedCoeff'></span>"



]


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


document.getElementById("questionCount").value= questionIndex.length

for(var i=0; i<questionIndex.length; i++) {
	
	var div = document.createElement("div");
	div.setAttribute("id", "question_div_"+i);
	
	var question = document.createElement("li");
	
	question.innerHTML = questionIndex[i];
	
	
	
	var input = document.createElement("input");
		input.setAttribute("type", "text");
		input.setAttribute("step", ".01");
		input.setAttribute("id", "q1_"+i);
		input.setAttribute("name", "q1_"+i);
	
	
	
	div.appendChild(question);
	
	<?php
		if (isset($assignid)) {
		echo "
		div.appendChild(input);
		";}
		?>
	
	
	
	
	
	
	//answerForm is a hidden element that contains inputs for price, quantity, delta price, and delta quantity
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
	answers.innerHTML = answerIndex[i];
	
	
	
	div.appendChild(answerForm);
	
	<?php
	if (!isset($assignid)) {
	echo "
	div.appendChild(button);
	div.appendChild(answers);
	";}
	?>
	
	
	questionsDiv.appendChild(div);
	
	
	
	
	
	
	do {
		var price1 = randomGen(index[i][1][0], index[i][1][1], index[i][1][2]);
		var quant1 = randomGen(index[i][0][0], index[i][0][1], index[i][0][2]);
		var deltaQuant = randomGen(index[i][2][0], index[i][2][1], index[i][2][2]);
		var deltaPrice = randomGen(index[i][3][0], index[i][3][1], index[i][3][2]);
		
				
		var price2 = round((price1*(1+deltaPrice)), 2);
		var quant2 = round((quant1*(1+deltaQuant)), 2);
		
		
		//The following ensures that quanitty and price are maintained when form is submitted:
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
	
	
	
	
	var span = document.getElementById("question_div_"+i).getElementsByClassName("price1");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = price1
		}
	
	var span = document.getElementById("question_div_"+i).getElementsByClassName("price2");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = price2
		}
		
	var span = document.getElementById("question_div_"+i).getElementsByClassName("quant1");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = numberWithCommas(quant1)
		}
		
	var span = document.getElementById("question_div_"+i).getElementsByClassName("quant2");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = numberWithCommas(quant2)
		}
		
	var span = document.getElementById("question_div_"+i).getElementsByClassName("revenue1");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = numberWithCommas(round(revenue1,2))
		}
		
	var span = document.getElementById("question_div_"+i).getElementsByClassName("revenue2");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = numberWithCommas(round(revenue2,2))
		}
		
	var span = document.getElementById("question_div_"+i).getElementsByClassName("pedCoeff");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = pedCoeff
		}
	
	var span = document.getElementById("question_div_"+i).getElementsByClassName("deltaQuant");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = round(deltaQuantApparent,2)*100+"&percnt;"
		}	
		
	var span = document.getElementById("question_div_"+i).getElementsByClassName("deltaPrice");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = round(deltaPriceApparent,2)*100+"&percnt;"
		}
		
	var span = document.getElementById("question_div_"+i).getElementsByClassName("pedCoeffLabel");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = pedCoeffLabel
		}
		
	var span = document.getElementById("question_div_"+i).getElementsByClassName("priceDirection");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = priceDirection
		}
		
	var span = document.getElementById("question_div_"+i).getElementsByClassName("quantDirection");
		for (var j=0; j<span.length; j++) {
		span[j].innerHTML = quantDirection
		}
	
	

	// The following element is essential as it populates the answerForm, which sends price and quantity values to server for checking.
	
	document.getElementById("answerForm_"+i).innerHTML = "<input type='number' name = 'a1_"+i+"' value='"+quant1+"'><input type='text' name = 'a2_"+i+"'  value='"+quant2+"'><input type='number' name = 'a3_"+i+"'  value='"+price1+"'><input type='number' name = 'a4_"+i+"'  value='"+price2+"'>";
	document.getElementById("answerForm_"+i).style.display = "none";
	
	

	
}

//console.log(pedValues);
</script>

</body>

</html>