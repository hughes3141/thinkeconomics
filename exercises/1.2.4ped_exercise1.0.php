<html>


<head>

<?php include "../header.php";?>

<style>

.answers {
	
	border: 1px solid black;
	padding: 5px;
	margin: 5px;
	background-color: pink;
	
}

.tiny_button {
	font-size: 4px;
	
}

</style>


</head>



<body>

<?php include "../navbar.php";

echo "Post: ";
print_r($_POST);
echo "<br>Get: ";
print_r($_GET);

$exercisename = "1.2.4 Elasticity Questions 1";


$assignid= $_GET['assignid'];
$userid = $_POST['userid'];
$name = $_POST['name'];

$timeStart = $_POST['timestart'];


$submitConfirm = 1;
$returnConfirm = 1;


if (isset($assignid) and empty($userid)) {
	echo "<h1>Elasticity Exercises 1</h1>";
	echo "<p>Login required for this assignment</p>";
	include "../login_student_embed.php";
	include "../footer.php";
	die();
}

if (isset($_POST['formSubmit'])) {}

$questionCount = $_POST['questionCount'];

$recordScore = array();
$record = array();

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
	

	
	//echo "<br>";
	echo "<br>";
	echo $quant1." ".$quant2." ".$price1." ".$price2." ".$deltaQuantApparent." ".$deltaPriceApparent." ".$pedCoeff." ".$revenue1." ".$revenue2." ".$pedCoeffLabel;
	
	//Responses:
	
	$response1 = $_POST['q1_'.$x];
	$response2 = $_POST['q2_'.$x];
	$response3 = $_POST['q3_'.$x];
	$response4 = $_POST['q4_'.$x];
	
	$recordAnswers = array($response1, $response2, $response3, $response4);
	$recordAnswersData = array($recordAnswers, $recordData);
	array_push($record, $recordAnswersData);
	
	
	if( $response1 >= ($pedCoeff-0.01) && $response1 <= ($pedCoeff+0.01) ) {
		//echo "Question ".($x+1)." A is Correct";
		array_push($recordScore, 1);}
	else {
		//echo "Question ".($x+1)." A is Incorreect";
		array_push($recordScore, 0);}
	//echo "||";
	if($response2 == $pedCoeffLabel) {
		//echo "Question ".($x+1)." B is Correct";
		array_push($recordScore, 1);}
	else {
		//echo "Question ".($x+1)." B is Incorreect";
		array_push($recordScore, 0);}
	//echo "||";
	if($response3 >= ($revenue1-0.05) && $response3 <= ($revenue1+0.05)) {
		//echo "Question ".($x+1)." C is Correct";
		array_push($recordScore, 1);}
	else {
		//echo "Question ".($x+1)." C is Incorreect";
		array_push($recordScore, 0);}
	//echo "||";
	if($response4 >= ($revenue2-0.05) && $response4 <= ($revenue2+0.05)) {
		//echo "Question ".($x+1)." D is Correct";
		array_push($recordScore, 1);}
	else {
		//echo "Question ".($x+1)." D is Incorreect";
		array_push($recordScore, 0);}
	
}

echo "<br>Record Score: ";
print_r($recordScore);
echo "<br>";

$score = array_sum($recordScore);
$percentage = (array_sum($recordScore)/count($recordScore))*100;

echo "Sum: ".array_sum($recordScore);
echo "<br>";
echo "Count: ".count($recordScore);
echo "<br>";
echo "Percentage: ".$percentage;

?>

<h1>Elasticity Exercises 1</h1>

<form method="post" >
<!-- action = "1.2.4ped_exercise1.0_submit.php" -->
<input type = "text" name ="questionCount" id="questionCount">
<input type = "text" name="userid" value = "<?php echo $userid; ?>">
<input type = "text" name="assignid" value = "<?php echo $assignid; ?>">
<input type = "text" name="name" value = "<?php echo $_POST['name']; ?>">
<input type = "text" name="timestart" value = "<?php echo date("Y-m-d H:i:s"); ?>">
<!--
<input type = "text" name="record" value = "<?php json_encode($record); ?>">
<input type = "text" name="score" value = "<?php echo $score; ?>">
<input type = "text" name="percentage" value = "<?php echo $percentage; ?>">
-->
<input type = "text" name="exercisename" value = "<?php echo $exercisename; ?>">
<input type = "text" name="submit" value = "<?php echo $submitConfirm; ?>">
<input type = "text" name="return" value = "<?php echo $returnConfirm; ?>">
<input type = "text" name="formSubmit" value = "1">;

<ol>
<div id="questionsDiv"></div>
</ol>
<input type="submit">
</form>

<?php include "../footer.php";





?>



<script>

/*
index[i] follows the format:
[quantMin, quantMax, quantStep, priceMin, priceMax, priceStep, deltaQuantMin, deltaQuantMax, deltaQuantStep, deltaPriceMin, deltaPriceMax, deltaPriceStep, question_no]

index follows the following format:
D1: Different questions
D2: [quanity, price, detlaQuant, deltaPrice]
D3: [min, max, step]

*/


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

var index = [
				[ [50,50,1], [10,10,1], [-.4,-.4,0.5], [.2,.2,.05]],
				[ [40,40,10], [15,15,1], [-.5,.5,.05], [-.5,.5,0.05]],
				[ [50,50,1], [10,10,1], [-.5,.5,.05], [-.5,.5,0.05]],
				[ [50,50,1], [10,10,1], [-.5,.5,.05], [-.5,.5,0.05]]

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

var questionsDiv = document.getElementById("questionsDiv");


document.getElementById("questionCount").value= index.length

for(var i=0; i<index.length; i++) {
	
	
	var div = document.createElement("div");
	div.setAttribute("id", "question_div_"+i);
	
	var question = document.createElement("li");
	question.innerHTML = "Prices <span id='qElement_"+i+"_0'></span> from &#163<span id='qElement_"+i+"_1'></span> to &#163<span id='qElement_"+i+"_2'></span>. Sales <span id='qElement_"+i+"_3'></span> from <span id='qElement_"+i+"_4'></span> to <span id='qElement_"+i+"_5'></span>";
	
	var div2 =  document.createElement("div");
	div2.innerHTML = "<ol type='A'><li><label for='q1_"+i+"'>What is the PED?</label><br><input type='number' step='.01' id='q1_"+i+"' name='q1_"+i+"'></li><li>Is this elastic or inelastic?<br><input type='radio' id='q2_1_"+i+"' name='q2_"+i+"' value='elastic'><label for='q2_1_"+i+"'>Elastic</label><br><input type='radio' id='q2_2_"+i+"' name='q2_"+i+"' value='inelastic'><label for='q2_2_"+i+"'>Inastic</label></li><li><label for='q3_"+i+"'>What was the firm's revenue before the price change?</label><br><input type='number' step='.01' id='q3_"+i+"' name='q3_"+i+"'></li><li><label for='q4_"+i+"'>What was the firm's revenue after the price change?</label><br><input type='number' step='.01' id='q4_"+i+"' name='q4_"+i+"'></li></ol>";
	
	var button = document.createElement("button");
	button.setAttribute("onclick", "negate('q1_"+i+"')");
	button.setAttribute("type", "button");
	button.innerHTML = "click to make PED input negative";
	button.classList.add("tiny_button")
	div2.appendChild(button);
	
	var answerForm = document.createElement("p");
	answerForm.setAttribute("id", "answerForm_"+i);
	
	var answers = document.createElement("div");
	answers.setAttribute("id", "answers_"+i);
	answers.setAttribute("class", "answers");
	
	div.appendChild(question);
	div.appendChild(div2);
	div.appendChild(answerForm);
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
	
	
	document.getElementById("answers_"+i).innerHTML = "PED: "+pedCoeff + "<br> PED is "+pedCoeffLabel +"<br>Revenue 1= &#163 "+ revenue1 +"<br>Revenue 2 = &#163 "+ revenue2;
	
	
	//pedCoeff+" / "+pedCoeffLabel+" / "+deltaQuantApparent+" / "+deltaPriceApparent+" / "+revenue1+" / "+revenue2;
	
}

console.log(pedValues);
</script>

</body>

</html>