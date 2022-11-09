<?php
 
// Initialize the session
session_start();

$_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

$loggedIn = 0;
$userId = "";

if (isset($_SESSION['userid'])) {
  
  $loggedIn = 1;
  $userId = $_SESSION['userid'];
  
}

//var_dump($loggedIn);

//Define $exerciseId if called via $_GET['exerciseid'];

$exerciseId = "";
if(isset($_GET['exerciseid'])) {
  $exerciseId = $_GET['exerciseid'];

}

//Define assignment and call details from assignment table:

$assignId = "";
$assignment = "";

if(isset($_GET['assignid'])) {
  $assignId = $_GET['assignid'];

  $assignment = getAssignmentInfoById($assignId);
  $exerciseId = $assignment['quizid'];

  
}
var_dump($userId);
//var_dump($assignId);
//var_dump($assignment);
//var_dump($exerciseId);

print_r($_POST);



if($_SERVER['REQUEST_METHOD'] == 'POST') {

  if(isset($_POST['control']) && $_POST['control'] == "Get Version") {
    $versionId = $_POST['savedId'];

  }

  if(isset($_POST['control']) && $_POST['control'] == "Save Work" && isset($_SESSION['userid'])) {
    $record = array();
    for($x=0; $x<$_POST['questionCount']; $x++) {
      $record2 = array();
      $record2[0] = $_POST['id_'.$x];
      $record2[1] = $_POST['response_'.$x];
      $record2[2] = getQuestionById($_POST['id_'.$x])['question'];
      array_push($record, $record2);
    }
    $record = json_encode($record);

    $sql = "INSERT INTO saq_saved_work (exerciseID, answers, timeStart, datetime, assignID, userID, version, exerciseName, name) VALUES (?, ?, ?, ?, ?, ?, ?)";

    //$stmt=bind_param("isssiiiss", );


    

  }









}

echo isset($versionId);



function getPreviousSAQSubmissions($userId, $exerciseId, $maxDate = 0, $dataReturn = 0) {
  //Retreives all previous work from user of a particular exercise. 
  //Third argument = 1 to show most recent submission, returns as 1-dimension array.
  //Fourth argument = 1 to return answers and feedback

  $userData = array();
  
  global $conn;

  $sql = "SELECT ";
  $sql .= "id, datetime, version ";
  if($dataReturn == 1) {
    $sql .= ", answers, feedback ";
  }
  $sql .= " FROM saq_saved_work WHERE userID = ? AND exerciseID = ? ORDER BY dateTime";

  if($maxDate) {
    $sql .= "  DESC LIMIT 1 ";
  }
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("ii", $userId, $exerciseId);
  $stmt->execute();

  $result = $stmt->get_result();

  if($result->num_rows>0) {
    while ($row = $result->fetch_assoc()) {
      if($maxDate) {
        return $row;
      }
      else {
        
        $userData[$row['id']] = $row;
        //array_push($userData, $row);
      }
    }
  }
  return $userData;

  

}

//$userData is an array of all previous saved versions that this user has made for this exerciseId.
$userData = getPreviousSAQSubmissions($userId, $exerciseId, 0, 1);


//$selectUserData is the data that is used on the loaded page. It is what the studnet will be working on.
//If $versionId is set (from selecting a differnt version) then $selectUserData is generated from $userData, given the $versionId.
//Else the most recent saved version of the exercise is returned.

if (isset($versionId)) {
  $selectUserData = $userData[$versionId];
} else {
  $selectUserData = getPreviousSAQSubmissions($userId, $exerciseId, 1, 1);
}

//SelectedVersion is the id of the data used on the loaded page.
$selectedVersion = $selectUserData['id'];

echo "<br>Select User Data:<br>";
print_r($selectUserData);


//$allUserData is an array of all previously saved versions, but only id, datetime, and version returned. To be used for drop-down list.

$allUserData = getPreviousSAQSubmissions($userId, $exerciseId);

//echo "<br>All User Data:<br>";
//print_r($allUserData);



function dataToArray($jsonStringArray, $questionId = 0) {

  //Converts json array into associative array of user entry data or feedback data
  //First argument is a json string representing the array of answers or feedback.
  //Second argument is control. $questionId = 0 to return entire array, else $questionId = id of question to be returned.

  global $conn;

  $array = json_decode($jsonStringArray);
  $questionsArray = array();

  foreach ($array as $value) {
    $questionsArray[$value[0]] = $value[1];
  }

  if ($questionId == 0) {
    return $questionsArray;
  } else {
    if(isset($questionsArray[$questionId])) {
      return $questionsArray[$questionId];
    }
    
  }

  

}





//print_r(dataToArray($selectUserData['answers']));
//echo "<br>";
//echo dataToArray($selectUserData['answers'], 1);

//Retrieve Exercise Information:

function getSAQExerciseInfoById($exerciseId) {
  //Returns array of exercise information from given $exerciseId

  global $conn;
  $sql = "SELECT * FROM saq_exercises WHERE id = ?";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param("i", $exerciseId);
  $stmt->execute();
  $result= $stmt->get_result();

  if($result->num_rows>0) { 
    
    $row = $result->fetch_assoc();
    /*
    $questionsArray = explode(",", $row['questions']);
    foreach($questionsArray as &$value) {
      $value = trim($value);
    }
    
    $row['questions'] = $questionsArray;
    */
    return $row;

  }


}



//$exercise is an array with all fields from saq_exercises
$excercise = getSAQExerciseInfoById($exerciseId);
//echo "<br>";
//print_r($excercise);



//Retreive question information information from exerciseId:

function getSAQExerciseQuestionsById($exerciseId) {
  //Returns array of questions from SAQ exercises table given $exerciseId

  global $conn;
  $sql = "SELECT * FROM saq_exercises WHERE id = ?";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param("i", $exerciseId);
  $stmt->execute();
  $result= $stmt->get_result();

  if($result->num_rows>0) { 
    $row = $result->fetch_assoc();
    //print_r($row);
    $questionsArray = explode(",", $row['questions']);
    foreach($questionsArray as &$value) {
      $value = trim($value);
    }
    $exerciseName = $row['exerciseName'];
  
    //print_r($questionsArray);
  
    $questions = array();
  
    $sql = "SELECT * FROM saq_question_bank_3 WHERE id=?";
    $stmt=$conn->prepare($sql);
  
    foreach($questionsArray as $value) {
      $stmt->bind_param("i", $value);
      $stmt->execute();
      $result=$stmt->get_result();
      if ($result->num_rows>0) {
        $row = $result->fetch_assoc();
        //print_r($row);
        array_push($questions, $row);
      }
  
    }
  
    return $questions;



  }
    


}

//Retrieve structure information from $exerciseID:

function getSAQExerciseStructureById($exerciseId) {

  global $conn;
  $sql = "SELECT * FROM saq_exercises WHERE id = ?";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param("i", $exerciseId);
  $stmt->execute();
  $result= $stmt->get_result();

  if($result->num_rows>0) {
    $row=$result->fetch_assoc();
    //echo $row['structure'];
    $structure = json_decode($row['structure']);
    foreach($structure as &$array) {
      if($array[0]=="qs") {
        $questionsArray = explode(",", $array[1]);
        foreach($questionsArray as &$value) {
          $value = trim($value);
        }
        $array[1] = $questionsArray;

      }
    }
    return $structure;
  }

}

//$structure is the array of all exercise elements
$structure = getSAQExerciseStructureById($exerciseId);


echo "<pre>";
print_r($structure);
echo "</pre>";


$questions = getSAQExerciseQuestionsById($exerciseId);
$questionsCount = count($questions);
echo $questionsCount;

//print_r($questions);


echo "<br>";
foreach ($questions as $data) {
  //print_r($data);
  ////echo "<br>";
}



$controlData = array("exerciseId"=>$exerciseId, "timeStart"=>date('Y-m-d H:i:s'), "exerciseName"=>$excercise['exerciseName'], "version"=>$excercise['version']);

print_r($controlData);



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php

  $head_insert = "


  <style>


  .answerBox {
    
    width: 100%;
    height: 200px;
    resize: none;
    font-family: 'Arial', Times, serif;
    font-size: 12px;
    white-space: pre-wrap;
    
  }

  .linebreak {
    
    white-space: pre-wrap;
    
  }

  #logindiv {
    
    border: 1px solid black;
    background-color: coral;
    
    
  }

  .questionImage {
    width:100%;
      max-width:600px;
    
    
  }

  .questionContainer {
    
    border-top: 3px solid pink;
    margin-top: 5px;
    //border: 2px solid black;
    //margin: 5px;
    //padding: 5px;
    
  }

  #submitMessage {
    
    
    background-color: coral;
  }

  ";

  ?>
  <?=$head_insert;?>
  </style>

</head>

<body>

  <h1>Short Answer Questions: <?=$excercise['exerciseName']?></h1>

  <form method = "post" action = "">
    <select name = "savedId">
      <?php

        foreach ($allUserData as $key=>$row) {
          ?>
          <option <?php
          
          if ($key == $selectedVersion) {
              echo "selected";
            }
          echo " value = ".$row['id'];
            ?>
          ><?=$row['datetime']?></option>
          <?php
        }
      ?>
    </select>
    <input type = "submit" name = "control" value="Get Version">

  </form>

  <form method="post" action="">
  <input type="submit" name="control" value="Save Work">
  <input type="hidden" name="questionCount" value ="<?=$questionsCount?>">

  <?php
  
    foreach($questions as $key=>$row) {
      //Populate page;
      ?>

    <div class="questionContainer">
      <p><?=$key+1?>: <?=$row['question']?> (<?=$row['points']?>)</p>

      <?php
        if($row['img']!="") {
          ?>
            <p>
              <img src = "<?=$row['img']?>" class="questionImage">
            </p>
          <?php
        }
      ?>

      <textarea class="answerBox" id="answerBox_<?=$key?>" name = "response_<?=$key?>" onselectstart="return false" onpaste="return false" oncopy="return false"><?php
        echo dataToArray($selectUserData['answers'], $row['id']);
      ?></textarea>
      <input type ="hidden" name= "id_<?=$key?>" value = "<?=$row['id']?>"
      

      
    </div>


    <?php
    }
  ?>
  </form>

</body>


</html>
