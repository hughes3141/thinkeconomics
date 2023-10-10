<?php

// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

if (!isset($_SESSION['userid'])) {
  
  header("location: /login.php");
  
}

else {
  $userInfo = getUserInfo($_SESSION['userid']);
  $userType = $userInfo['usertype'];
  if (!($userType == "teacher" || $userType =="admin")) {
    header("location: /index.php");
  }
}


?>

<!DOCTYPE html>

<html lang="en">

<head>

<style>

td, th {
	
	border: 1px solid black;
	padding: 3px;
}

table {
	
	border-collapse: collapse;
}

h2 {
	border-top: 1px solid black;
}

</style>

<?php include "../header.php"?>

</head>



<body>

<?php include "../navbar.php"?>



<h1>Student Assignment Review</h1>

<?php 

print_r($_GET);

if(isset($_GET['userid'])) {


$_SESSION["userid"] = $_GET['userid'];
}






?>

<form method="get">
<label for ="userid">Student Name:</label>
<select name="userid">;
<?php 



$query = "SELECT id, name, name_first, name_last FROM users";

if ($result = mysqli_query($conn, $query)) {	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if ($row[id] == $_GET['userid']) {
			$selected = " selected = 'selected'";
			}
			else {$selected = "";}
		echo "<option value = '".$row[id]."'".$selected.">".$row[name_first]." ".$row[name_last]"</option>";
	}
}



?>
</select>

<input type="submit" value ="Submit">
</form>


<?php 

$query = "SELECT id, name FROM users WHERE id = '".$_GET['userid']."'";

//echo $query;

if ($result = mysqli_query($conn, $query)) {
	
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	//echo $row[name];
	$_SESSION["name"] = $row[name];
	
	
}




include "../user/user_assign_review.php";

?>


<?php include "../footer.php"?>

</body>



<script>


</script>

</html>
