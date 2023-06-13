<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include($path."/php_header.php");
?>
<html>

<?php include '../header.php';?>

<head>

<style>

table, th, td {

border: 1px solid black;
border-collapse: collapse;
}

#question_div {
	
	padding: ;
}

.summaryQuestion {
	
	border: 5px pink solid;
	marign: 5px;
	padding: 5px;
	
	
}

</style>


</head>



<body onload>

<?php include '../navbar.php'; ?>

<h1>Exercise</h1>







<?php

//Exercise Specific:

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

echo "<br>";
print_r($recordScore);

$score = array_sum($recordScore);
$percentage = (array_sum($recordScore)/count($recordScore))*100;

echo "Sum: ".array_sum($recordScore);
echo "<br>";
echo "Count: ".count($recordScore);
echo "<br>";
echo "Percentage: ".$percentage;




//General Submit:


print_r($_POST);

$name = $_POST['name'];
//$record = $_POST['record'];
//$score = $_POST['score'];
//$percentage = $_POST['percentage'];
$exercisename = $_POST['exercisename'];
$timeStart = $_POST['timestart'];


$timeEnd = date("Y-m-d H:i:s");

$assignid = $_POST['assignid'];
$userid = $_POST['userid'];
$submitConfirm = $_POST['submit'];
$returnConfirm = $_POST['return'];

$record = json_encode($record);

echo "<br>";
echo $record;


$link = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
	
	die ("The connection could not be established");
}

$query = "INSERT INTO `exercise_responses` (`name`, `answers`, `mark`, `percentage`, `exerciseName`, `exerciseID`,`timeStart`, `datetime`, `assignID`, `userID`, `submit`, `returned`) VALUES ('$name', '$record', '$score', '$percentage', '$exercisename', '$exerciseID', '$timeStart', '$timeEnd', '$assignid', '$userid', '$submitConfirm', '$returnConfirm')";



// This element is added to ensure that  the same completed assignment is not submitted twice

$query2 = "SELECT * FROM exercise_responses WHERE userID='".$userid."' AND timeStart='".$timeStart."'";

$result = mysqli_query($link, $query2);

$row = mysqli_fetch_array($result,  MYSQLI_ASSOC);

$timeEnd2 = $row['datetime'];



if ((mysqli_num_rows($result) == 0) and (isset($userid)) ) {
	
	//This line submits the result to responses:

	mysqli_query($link, $query);
}

else {
	
	echo "<p style = 'background-color: pink;'>Note: This form has already been submitted and score recorded ".$timeEnd2.".</p>";
}





?>



</body>

<script>



</script>