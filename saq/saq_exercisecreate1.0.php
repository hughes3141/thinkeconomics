<?php

session_start();


?>

<!DOCTYPE html>


<html lang="en">

<head>

<?php include "../header.php";?>

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

<?php include "../navbar.php";?>


<?php 

//print_r($_POST);

if (isset($_SESSION['userid'])==false) {

  $_SESSION['name'] = $_POST['name'];
  $_SESSION['userid'] = $_POST['userid'];
  $_SESSION['usertype'] = $_POST['usertype'];
  $_SESSION['groupid'] = $_POST['groupid'];

}

//print_r($_SESSION);

?>

<h1>SAQ Exercise Create</h1>

<?php 

if (isset($_SESSION['userid'])==false) {
  
  ?>
    
  <div id = 'logindiv'>
  <h2>User Login:</h2>
  <!--<p>Please login to contribute to the news database:</p>-->

  <?php include "../login_embed_envelope.php"; ?>
    


  </div>
  
  <?php
  
} else {
  echo "<p>Logged in as ".$_SESSION['name']."</p>";
}


if (isset($_SESSION['userid'])) {

  ?>




  <form method="post">
    <p>
      <label for="quizName">SAQ Exercise Name</label>
      <input type="text" id="quizName" name="quizName">
    
      <label for="questions">Questions</label>
      <input type="text" id="questions" name="questions">
   
      <label for="notes">Notes</label>
      <input type="text" id="notes" name="notes">
    </p>
    <p>
      <input type="submit" name="submit" value="Create Exercise">
    </p>
  </form>

  <?php

}

?>



<?php 



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



$quizName = $_POST["quizName"];
$questions = $_POST["questions"];
$notes = $_POST["notes"];
//$review = $_POST["review"];
$datetime = date("Y-m-d H:i:s");
$user = $_SESSION['userid'];

//echo var_dump($_POST)."<br>";
//echo $datetime;

$stmt = $conn->prepare("INSERT INTO saq_exercises (exerciseName, questions, notes, dateCreated, userCreate) VALUES (?, ?, ?, ?, ?)");

$stmt->bind_param("ssssi", $quizName, $questions, $notes, $datetime, $user);


//Execute

//$stmt->execute();

echo "New records created successfully";





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


$stmt = $conn->prepare("SELECT * FROM saq_exercises ORDER BY id");
//$stmt -> bind_param();
$stmt -> execute();
$result = $stmt->get_result();




if($result/*->num_rows>0*/) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
			echo "<td>$row[id]</td>";
			echo "<td>$row[exerciseName]</td>";
			echo "<td>$row[questions]</td>";
			echo "<td>$row[notes]</td>";
			echo "<td>$row[dateCreated]</td>";
			
			echo "</tr>";
  }
} else {
  echo "No results";
}



?>




<script>


</script>

</body>

</html>