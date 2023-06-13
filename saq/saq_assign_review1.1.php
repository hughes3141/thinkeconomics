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

<html>


<head>

<?php include "../header.php"; 



$link = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
	
	die ("The connection could not be established");
}
?>

<style>

table {
	
	
	border-collapse: collapse;
}

th, td {
	
	
	border: 1px solid black;
	padding: 5px;
	
}


.questionImg {
	
	max-width: 50%;
	
}

.questionReviewDiv {
	
	
	border: 2px solid pink;
	padding: 5px;
	margin-bottom: 5px;
	
}

.modelAnswer {
	
	color: green;
  white-space: pre-line;
  padding: 5px;
	
}

.studentAnswer {
	
	font-size: 1.125em;
	padding: 10px;
	
}

textarea {
  width: 500px;
  height: 50px;
  max-width: 90%;
}
</style>


</head>



<body>

<?php include "../navbar.php"; 

if(isset($_GET['assignid'])) {
  $assignid = $_GET['assignid'];
}
if(isset($_GET['responseid'])) {
  $responseid = $_GET['responseid'];
}
$answers = array();
$marksTotal = array();
$marksAchieved = array();
if(isset($_GET['returnButton'])) {
  $returnButton = $_GET['returnButton'];
}


print_r($_POST);
print_r($_GET);


$feedback = array();

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

  for ($x=0; $x<$_POST['questionNumber']; $x++) {
    
    $feedbackInstance = array();
    
    array_push($feedbackInstance, $_POST['n_'.$x]);
    
    array_push($feedbackInstance, $_POST['p_'.$x]);
    array_push($feedbackInstance, $_POST['c_'.$x]);

    array_push($feedback, $feedbackInstance);
    
    
    array_push($marksAchieved, $_POST['p_'.$x]);
    
  }



  // $percentage = round(($score/$arrlength)*100, 2);


  //echo "<br>";
  //print_r($feedback);

  $marksAchieved = array_sum($marksAchieved);
  $percentage = round(($marksAchieved/$_POST['marksTotal'])*100, 2);
  $return = $_POST['return'];

  //echo "Marks: ".$marksAchieved."/".$_POST['marksTotal']."<br>Percentage: ".$percentage;
  //echo "<br>";

  $feedbackEncode = mysqli_real_escape_string($link, json_encode($feedback));

  //echo $feedbackEncode;


  $query = "UPDATE `saq_saved_work` SET `feedback` = '".$feedbackEncode."', `mark` = '".$marksAchieved."', `percentage` = '".$percentage."', `returned` = '".$return."' WHERE `saq_saved_work`.`id` = ".$_POST['responseID'];


  if (mysqli_query($link, $query)) {
    
    //echo "Record updated successfully with following record: <br>".$feedbackEncode;
    } else {
    //echo "Error updating record: " . mysqli_error($link);
    
      
  }
}

?>





<form method ="get">

<label for="assignment">Assignment:</label>
<select id="assignment" name="assignid">

<?php 

$query = "SELECT * FROM assignments WHERE type ='saq'";

if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		
		echo "<option value='".$row['id']."'";
    if(isset($_GET['assignid'])) {
      if($row['id']==$assignid) {
        echo "selected";
      }
    }
		echo ">".$row['assignName']."</option>";
		
		//print_r($row);
		}
	}

?>

</select>

<input type='checkbox' id='returnButton' onclick = 'returnButtonSync()' name='returnButton' value='1'<?php 

if(isset($returnButton)) {
  if($returnButton == 1) {
      echo "checked";
    } 
  }
  ?>>
  <label for='returnButton'>Hide Returned</label>

<input type="submit" value ="Select Assignment">
</form>



<form method ="get">

<input type = "hidden" name ="assignid" value = "<?php echo $assignid;?>">
</input>


<label for="student">Student:</label>
<select id="student" name="responseid">

<?php 

if (empty($returnButton)) {
	
	$query = "SELECT * FROM saq_saved_work WHERE assignID ='".$assignid."' AND submit = '1'";
		
}

else {
	
	$query = "SELECT * FROM saq_saved_work WHERE assignID ='".$assignid."' AND submit = '1' AND returned = '0'";
		
}


if (isset($assignid)) {

if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		
		echo "<option value='".$row[id]."'";
		if(isset($responseid)){
      if($row['id']==$responseid) {
        echo "selected";
      }
    }
		
		echo ">".$row['name']."</option>";
	
		//print_r($row);
		}
	}
}
?>


</select>

<input type='checkbox' id='returnButton2' style="display:none" name='returnButton' value='1'<?php 
if(isset($returnButton)) {
  if($returnButton == 1) {
      echo "checked";
    } 
  }?>>

<input type="submit" value ="Select Student">
</form>

<?php

/*
$query = "SELECT * FROM saq_saved_work WHERE id ='".$assignid."' AND submit = '1'";

if (isset($assignid)) {

if ($result = mysqli_query($link, $query)) {
	
	while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
		
		echo "<option value='".$row[id]."'";
		
		if($row[id]==$responseid) {
			echo "selected";
		}
		
		echo ">".$row[name]."</option>";
	
		//print_r($row);
		}
	}
}

*/

if(isset($responseid)) {
  $query = "SELECT * FROM saq_saved_work WHERE id = '".$responseid."'";

  if ($result = mysqli_query($link, $query)) {
    
    while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
      
      //echo "var index = ".$row['answers'];
      //print_r($row);
      
      $answers = json_decode($row['answers'], true);
      $feedbackField = json_decode($row['feedback'], true);
      $return = $row['returned'];
      
      echo $row['name']."<br>";
      echo $row['datetime']."<br>";
      
        if (!empty($row['returned'])) {
      
        echo "Mark: ".$row['mark']."<br>";
        echo "Percentage: ".$row['percentage'];
      
        }
      }

          
    }
  }

echo "<form method ='post'>";

for ($x=0; $x<count($answers); $x++) {
	
	$questionNo = $answers[$x][0];
	
	
	
		$query = "SELECT * FROM saq_question_bank_3 WHERE id = '".$questionNo."'";

		if ($result = mysqli_query($link, $query)) {
			
			while ($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)) {
				
				$questionNo = $row['id'];
				$text = $row['question'];
				$points = $row['points'];
				$img = $row['img'];
				$model = $row['model_answer'];
				
				array_push($marksTotal, $points);
				
				
				//echo $text;
				//echo $points;
				//echo $img;
				

				}

						
			}
	echo "<div class ='questionReviewDiv'>";
	echo ($x +1).":".$text." (".$points.")";
	echo "<br>";
	//echo $answers[$x][2];
	//echo "<br>";
	if (isset($img)) {
		
		echo "<img class = 'questionImg' src ='".$img."'>";
	}
	echo "<br>";
	echo "<div class ='studentAnswer'>".$answers[$x][1]."</div>";
	echo "<br>";
	echo "<input type='hidden' name ='n_".$x."' value = '".$questionNo."'>";
	echo "Points: <input type = 'number' value = '";
  if(is_array($feedbackField)) {
    echo $feedbackField[$x][1];
  }
  echo "'name = 'p_".$x."' min = '0' max = '".$points."'>/".$points;
	echo "<br>Comment:<br>";
	echo "<textarea name = 'c_".$x."'>";
  if(is_array($feedbackField)) {
    echo $feedbackField[$x][2];
    }
  echo "</textarea>";
	echo "<div class ='modelAnswer'>".$model."</div>";
	echo "</div>";
	
	
}
//print_r($marksTotal);
if(isset($responseid)) {
  $marksTotal = array_sum($marksTotal);
  echo "<input type='hidden' name = 'marksTotal' value = '".$marksTotal."' >";

  echo "<input type='hidden' name = 'responseID' value = '".$responseid."' >";
  echo "<input type='hidden' name = 'questionNumber' value = '".count($answers)."' >";
}
if(isset($responseid)) {
	
	


	echo "<input type='checkbox'";

	if($return == 1) {
		echo "checked";
	}
	echo " id='return' name='return' value='1'><label for='return'>Return Work</label><br>";

	echo "<input type='submit' value ='Save Comments'></form>";
	
}

?>

<div id="responseDiv"></div>








<?php include "../footer.php"; ?>

<script>


function returnButtonSync() {
	

	
	var button1 = document.getElementById("returnButton");
	var button2 = document.getElementById("returnButton2");
	
	if (button1.checked == true ) {
		button2.checked = true
	}
	
	else (
	 button2.checked = false
	)
	
	
}


</script>

</body>



</html>