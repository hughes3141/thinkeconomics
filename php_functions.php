<?php

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


function getAssignmentInfoById($assignId) {
  /*
  Returns information from assignments table from input id.

  */

  global $conn;
  $sql = "SELECT * FROM assignments WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $assignId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    return $row;
  }
  




}




function getAssignmentsList($userId, $classId = null, $type = "all") {

  /*
  Returns a list of assignments by the user who created it, optional filter by type by type.

  used in:
  -mcq_assignment_review3.0.php 
  */
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


/*

maxOrder(str $tableName) : int

Returns the current order number

Used in:
  -notes_list.php
*/

function maxOrder($tableName) {
  global $conn;

  $sql = $sql = "SELECT MAX(orderNo) AS maxOrder FROM ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $tableName);
  $stmt->execute();

  if($result) {
    $maxOrder = $result->fetch_assoc();
  }
  return intval($maxOrder['maxOrder']);

}


/*

orderUpdate($input, $userId) : null

*/


/*

getUserInfo ($userId) : array

Returns an array of all information about a user.


*/

function getUserInfo($userId) {
  global $conn;
  $sql = "SELECT * FROM users WHERE id = ? ";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows>0) {	
  $row = $result->fetch_assoc();
  return $row;   
     
  }
}


function getUpcomingAssignmentsArray($groupIdArray) {

  /*
  This function generates an array of upcoming assignmnents. Input is an array (in JSON form) of the groups that a studnet is listed in.
  */

  global $conn;
  $t = time();
  $now = $now = date("Y-m-d H:i:s", $t);

  $groupIdSql = array();

  $list = array();
  $paramType = "";

  $sql = "SELECT * FROM assignments WHERE (";

  $count = count($groupIdArray);
  for($x =0; $x< $count; $x++) {
    $valueSql = '%\"'.$groupIdArray[$x].'\"%';
    array_push($groupIdSql, $valueSql);
    $sql .= "groupid_array LIKE ? ";
    if($x < ($count - 1)) {
      $sql .= " OR ";
    }
    $paramType .= "s";
  }
  
  $sql .= ") AND dateDue > CURRENT_TIMESTAMP()";

  //echo $sql."<br>".$paramType;
  $stmt = $conn->prepare($sql);
  $stmt->bind_param($paramType, ...$groupIdSql);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }

  return $list;

}

function getUpcomingAssignments($groupId) {
  global $conn;
  $t = time();
  $now = date("Y-m-d H:i:s", $t);

  $groupIdSql = '%\"'.$groupId.'\"%';

  //echo $groupIdSql;

  $list = array();
  
  $sql = "SELECT * FROM assignments WHERE groupid_array LIKE ? AND dateDue > CURRENT_TIMESTAMP()";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $groupIdSql);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }

  return $list;

}


function getAssignmentsArray($groupIdArray) {

  /*
  This function generates an array of assigned work. Input is an array (in JSON form) of the groups that a studnet is listed in.
  */

  global $conn;

  $groupIdSql = array();

  $list = array();
  $paramType = "";

  $sql = "SELECT * FROM assignments WHERE (";

  $count = count($groupIdArray);
  for($x =0; $x< $count; $x++) {
    $valueSql = '%\"'.$groupIdArray[$x].'\"%';
    array_push($groupIdSql, $valueSql);
    $sql .= "groupid_array LIKE ? ";
    if($x < ($count - 1)) {
      $sql .= " OR ";
    }
    $paramType .= "s";
  }
  
  $sql .= ")";


  //echo $sql."<br>".$paramType;
  $stmt = $conn->prepare($sql);
  $stmt->bind_param($paramType, ...$groupIdSql);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($list, $row);
    }
  }
  
  return $list;

}


function getMCQquizInfo($quizId) {

  /*
  This function returns array of all columns for a particular id in mcq_quizzes
  */

  global $conn;
  $sql = "SELECT * FROM mcq_quizzes WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $quizId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    $row = $result->fetch_assoc();
    return $row;
  }
  
}


function getMCQquizzesByTopic($topic) {
  /*
  This function returns an array of all entries from mcq_quizzes table that match a $topic category
  */

  global $conn;
  $quizzes = array();
  $sql = "SELECT * FROM mcq_quizzes WHERE topic LIKE ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("s", $topic);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    
    while($row = $result->fetch_assoc()){
      array_push($quizzes, $row);
      
    }
    return $quizzes;
  }
  

}


function getGroupInfoById($groupId) {
  /*
  Returns array of all information from groups table from input $groupId
  */

  global $conn;
  $sql = "SELECT * FROM groups WHERE id = ?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("i", $groupId);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows>0) {
    
    $row = $result->fetch_assoc();
    $row['teachers'] = json_decode($row['teachers']);
    return $row;
  }


}

?>