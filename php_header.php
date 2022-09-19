<?php



//Commands which are common to all scripts:


  // Initialize the session
  session_start();

  $_SESSION['this_url'] = $_SERVER['REQUEST_URI'];

  /*
  if (!isset($_SESSION['userid'])) {
    
    header("location: /login.php");
    
  }
  */

  //Define server path:
  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/../secrets/secrets.php";
  include($path);

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
  }


//Functions:


/*
checkGroupAccess(int $userId, int $groupId): bool

Given a username, will determine whether the user has teacher priviliges for the group in question.
*/

function checkGroupAccess($userId, $groupId) {
  global $conn;

  $sql = "SELECT * FROM groups WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $groupId);
  $stmt->execute();

  $result = $stmt->get_result();

  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    $teachers = json_decode($row['teachers']);
    
    if(in_array($userId, $teachers)) {
      return true;
    } else {
      return  false;
    }
  }

}


/*

getGroupsList(int $userId, $activeReturn bool = true) : array

Returns a list of groups for whom the $userId is listed as a teacher


*/


function getGroupsList($userId, $activeReturn = true) {
  global $conn;

  $userIdSql = '%\"'.$userId.'\"%';

  $sql = "SELECT * FROM groups WHERE teachers LIKE ? AND active = 1";

  if($activeReturn == false) {
    $sql = "SELECT * FROM groups WHERE teachers LIKE ?";
  }
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("s", $userIdSql);
  $stmt->execute();
  $result = $stmt->get_result();

  $groups = array();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($groups, $row);
    }
  }
  return $groups;
}



/*

getAssignmentsList(int $userId, int $groupId = null, string $type = all) : array

Returns a list of assignments by the user who created it, optional filter by type by type.

  used in:
  -mcq_assignment_review3.0.php

*/

function getAssignmentsList($userId, $classId = null, $type = "all") {
  global $conn;

  $state = array(0,0);

  $sql ="SELECT * FROM assignments WHERE userCreate = ?";

  if($classId != null) {
    $classIdSql = '%\"'.$classId.'\"%';
    $sql .= " AND groupid_array LIKE ?";
    $state[0] = 1;
  }

  if($type != "all") {
    $sql .= " AND type = ?";
    $state[1]=1;
  }
    //echo $sql;
    $stmt=$conn->prepare($sql);
    //print_r($state);

    if($state == [0,0]) {
      $stmt->bind_param("i", $userId);
    } elseif ($state == [1,0]) {
      $stmt->bind_param("is", $userId, $classIdSql);
    } elseif ($state == [0,1]) {
      $stmt->bind_param("is", $userId, $type);
    } elseif ($state == [1,1]) {
      $stmt->bind_param("iss", $userId, $classIdSql, $type);
    }

  $stmt->execute();
  $result=$stmt->get_result();

  $assignments = array();

  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
      array_push($assignments, $row);

    }
  }

  return $assignments;

  
  
}

/*
getGroupUsers(int $groupId): array

Will produce an array of all users in a given groupId.
  
*/

function getGroupUsers($groupId) {
  global $conn;

  $groupIdSql = '%\"'.$groupId.'\"%';

  $sql = "SELECT * FROM users WHERE groupid_array LIKE ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $groupIdSql);
  $stmt->execute();

  $students = array();

  $result=$stmt->get_result();
  
  if($result->num_rows>0) {
    while($row = $result->fetch_assoc()){
      array_push($students, $row);
    }
  }

  return $students;

}



?>