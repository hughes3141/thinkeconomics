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
	padding: 5px;
	word-wrap:break-word;
	
}

table {
	
	border-collapse: collapse;
	table-layout: auto;

  width: 75%;

</style>
</head>


<body>

<form method="post">
<label for="quizName">Quiz Name</label>
<input type="text" id="quizName" name="quizName">
<label for="questions">Questions</label>
<input type="text" id="questions" name="questions">
<label for="notes">Notes</label>
<input type="text" id="notes" name="notes">
<!--
<label for="reviewOn">Review On</label>
<input type="radio" id="reviewOn" name="review" value = "1">
<label for="reviewOff">Review Off</label>
<input type="radio" id="reviewOff" name="review" value = "0">
-->
<input type="submit" value="Create Quiz">

</form>

<?php 




$quizName = htmlspecialchars($_POST["quizName"]);
$questions = htmlspecialchars($_POST["questions"]);
$notes = htmlspecialchars($_POST["notes"]);
$review = $_POST["review"];
$datetime = date("Y-m-d H:i:s");
$userCreate = 1;

echo var_dump($_POST)."<br>";
echo $datetime;



$query = "INSERT INTO `mcq_quizzes` (`quizName`, `questions`, `notes`, `dateCreated`, `reviewQs`, `userCreate`) VALUES ('$quizName', '$questions', '$notes', '$datetime', '$review', $userCreate)";

if (empty($quizName)==false) {
	

mysqli_query($link, $query);
}

?>


<table>
<tr>

<th>id</th>
<th>quizName</th>
<th>Questions</th>
<th>Notes</th>
<th>dateCreated</th>

</tr>

<?php

$query = "SELECT * FROM mcq_quizzes";

if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		
			echo "<tr>";
			echo "<td>$row[id]</td>";
			echo "<td>$row[quizName]</td>";
			echo "<td>$row[questions]</td>";
			echo "<td>$row[notes]</td>";
			echo "<td>$row[dateCreated]</td>";
			
			echo "</tr>";
		
	}
	
}



?>




<script>


</script>

</body>

</html>