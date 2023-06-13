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

print_r($_POST);

$name = $_POST['name'];
$record = $_POST['record'];
$score = $_POST['score'];
$percentage = $_POST['percentage'];
$exercisename = $_POST['exercisename'];
$timeStart = $_POST['timestart'];


$timeEnd = date("Y-m-d H:i:s");

$assignid = $_POST['assignid'];
$userid = $_POST['userid'];
$submitConfirm = $_POST['submit'];
$returnConfirm = $_POST['return'];





$link = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
	
	die ("The connection could not be established");
}

$query = "INSERT INTO `exercise_responses` (`name`, `answers`, `mark`, `percentage`, `exerciseName`, `exerciseID`,`timeStart`, `datetime`, `assignID`, `userID`, `submit`, `returned`) VALUES ('$name', '$record', '$score', '$percentage', '$exercisename', '$exerciseID', '$timeStart', '$timeEnd', '$assignid', '$userid', '$submitConfirm', '$returnConfirm')";

mysqli_query($link, $query);


?>



</body>

<script>



</script>