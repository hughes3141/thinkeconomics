<html>

<?php include '../header.php';?>

<head>

<style>

#submitReview {
	
	border: solid 1px black;
	margin: 5px;
	padding: 5px;
	
}

</style>


</head>



<body onload="">

<?php include '../navbar.php'; ?>

<h1>SAQ: Your work has been saved</h1>







<?php



/*
---THIS IS SAQ Save---


1.2
Changes from htmlspecialchars to mysqli_real_escape_string

1.1

1.0
Building up using MCQ2.2_submit_php as template

*/


/*
echo "Var Dup of Post:";
echo var_dump($_POST);
*/
//print_r($_POST);



if ($link ->connect_error) {
	die("The connection could not be established");
}
/*
if (mysqli_connect_error()) {
	
	die ("The connection could not be established");
}
*/
$record = json_decode($_POST['record']);


//print_r($record);


$responseCollection = array();

for ($x=0; $x<$_POST['number_of_questions']; $x++) {
	
	$responseCollection2 = array();
	
	
	
	//This inserts the question id number:	
	array_push($responseCollection2, $record[$x][0]);
	
	
	//This inserts the candidate response:
	array_push($responseCollection2, $_POST[response_.$x]); 
	//array_push($responseCollection, rawurlencode($_POST[response_.$x]));
	
	
	//This inserts question as third element of array:
	//!!!!!If at any point in the future you wish to stop collecting questions as part of 'answers' datavalue, remove following line:
	array_push($responseCollection2, $record[$x][1]);
	
	
	array_push($responseCollection, $responseCollection2);
}


/*
echo "print_r responseCollection:<br>";
print_r($responseCollection);

echo "<br><br>Encode Array:<br>".json_encode($responseCollection);
*/






//$record = json_decode($_POST['record']);
//$record = ($_POST['record']);

$record = json_encode($responseCollection);
//$record = mysqli_real_escape_string($link, json_encode($responseCollection));

//$name = mysqli_real_escape_string($link, $_POST['name']);
//$exercisename = mysqli_real_escape_string($link, $_POST['exercisename']);

$name = $_POST['name'];
$exercisename = $_POST['exercisename'];

$exerciseID = $_POST['exerciseID'];


$answers = array();
$score = 0;
$percentage = 0;
$timeStart = $_POST['startTime'];
$timeEnd = date("Y-m-d H:i:s");

$assignid = $_POST['assignid'];
$userid = $_POST['userid'];
$review = $_POST['reviewQ'];
$multi = $_POST['multi'];
$submitConfirm = $_POST['submitConfirm'];



$arrlength = count($record);




/*!!!The below command determines where the results are sent to*/

//$query = "INSERT INTO `saq_saved_work` (`name`, `answers`, `mark`, `percentage`, `exerciseName`, `exerciseID`,`timeStart`, `datetime`, `assignID`, `userID`, `submit`) VALUES ('$name', '$record', '$score', '$percentage', '$exercisename', '$exerciseID', '$timeStart', '$timeEnd', '$assignid', '$userid', '$submitConfirm')";

$stmt = $link->prepare("INSERT INTO saq_saved_work (name, answers, mark, percentage, exerciseName, exerciseID, timeStart, datetime, assignID, userID, submit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssiisissiii", $name, $record, $score, $percentage, $exercisename, $exerciseID, $timeStart, $timeEnd, $assignid, $userid, $submitConfirm);

//$stmt = $link->prepare("INSERT INTO saq_saved_work (name, answers, mark) VALUES (?, ?, ?)");



//$stmt->bind_param("sss", $name, $record, $mark);
/*
echo $name;
echo "<br>";
echo $record;
echo "<br>";
echo $mark;
echo "<br>";
*/


$stmt->execute();



// This element is added to ensure that  the same completed assignment is not submitted twice



$query2 = "SELECT * FROM responses WHERE userID='".$userid."' AND timeStart='".$timeStart."'";

$result = mysqli_query($link, $query2);

$row = mysqli_fetch_array($result,  MYSQLI_ASSOC);

$timeEnd2 = $row['datetime'];



//if (mysqli_num_rows($result) == 0 ) {
	
	//This line submits the result to responses:

	//mysqli_query($link, $query);
//}


/*
else {
	
	echo "<p style = 'background-color: pink;'>Note: This form has already been submitted and score recorded ".$timeEnd2.".</p>";
}


*/


echo "<p>Name: ".$name."</p>";
echo "<p>Exercise: ".$exercisename."</p>";





?>

<p>Your response has been recorded on the server as follows:</p>

<div id="submitReview">
<?php


$query = "SELECT * FROM saq_saved_work WHERE userID='".$userid."' AND datetime='".$timeEnd."'";

$answersCheck = array();

if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		

		//print_r($row);
		echo "Date and Time Submitted: ".$timeEnd."<br>";
		$answersCheck = (json_decode($row[answers]));
		
			for($x=0; $x<count($answersCheck); $x++ ) {
			
				echo "<p><b>".$answersCheck[$x][2]."</b>: ".$answersCheck[$x][1]."</p>";
			
			
			}
		
		
		
		}

				
	}

?>

</div>


<?php include "../footer.php"; ?>

</body>

<script>


</script>